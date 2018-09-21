<template>
<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-pulled-left">
                <h1 class="title has-text-grey">Got something to update ?</h1>
                <div class="box">
                    <form action="#" method="POST">
                        <div class="field">
                            <div class="file is-info has-name">
                                <label class="file-label">
                                    <input ref="video" class="file-input" @change="fileInputChange"  type="file">
                                    <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">
                                            Browse file..
                                        </span>
                                    </span>
                                    <span class="file-name" v-if="video_filename && typeof video_filename.name != 'undefined'">
                                        {{ video_filename.name }}
                                    </span>
                                </label>
                            </div>
                        </div>
                        <template>
                             <div class="field" v-if="hasMultipleChannels">
                            <label class="label">Tell me, which channel </label>
                            <div class="control">
                                  <div class="select  is-rounded is-fullwidth">
                                    <select v-model="channel_id">
                                      <option :value="channel.id" :key="channel.id" v-for="channel in channels">{{ channel.name }}</option>
                                    </select>
                                  </div>
                            </div>
                            <p class="help is-danger" v-if="errors.channel_id">{{ errors.channel_id[0] }}</p>
                        </div>
                        <div class="field">
                            <label class="label">Title</label>
                            <div class="control">
                                <input class="input is-large" :class="{'is-danger' : errors.title}" v-model="title" type="text" placeholder="Untitled" >
                            </div>
                            <p class="help is-danger" v-if="errors.title">{{ errors.title[0] }}</p>
                        </div>
                        <div class="field">
                            <label class="label">Description</label>
                            <div class="control">
                                <textarea class="input is-large" :class="{'is-danger' : errors.description}" v-model="description" >
                                </textarea>
                            </div>
                            <p class="help is-danger" v-if="errors.description">{{ errors.description[0] }}</p>
                        </div>
                        <div class="field">
                            <label class="label">Visibility</label>
                            <div class="control">
                                  <div class="select  is-rounded is-fullwidth">
                                    <select v-model="visibility">
                                      <option value="private">private</option>
                                      <option value="unlisted">unlisted</option>
                                      <option value="public">public</option>
                                    </select>
                                  </div>
                            </div>
                            <p class="help is-danger" v-if="errors.visibility">{{ errors.visibility[0] }}</p>
                        </div>
                        <div class="field">
                            <label class="checkbox is-pulled-left">
                              <input type="checkbox" v-model="allow_comments" true-value="1" false-value="0">
                                Allow Comments
                            </label>
                        </div>
                        <div class="is-clearfix"></div>
                        <div class="field">
                            <label class="checkbox is-pulled-left">
                              <input type="checkbox" v-model="allow_votes" true-value="1" false-value="0">
                                Allow Votes
                            </label>
                        </div>
                        <div class="field">
                            <div class="control">
                                <span class="help pull-right" v-if="saveStatus">{{ saveStatus }} </span>
                                <button class="button is-large is-primary is-fullwidth" type="submit" @click.prevent="store">Release Video</button>
                            </div>
                        </div>
                        </template>
                    </form>
                </div>
            </div>
            <div class="column is-4 is-pulled-right" >
                    <div class="card">
                      <div class="card-image">
                        <figure class="image is-4by3">
                          <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                        </figure>
                      </div>
                      <div class="card-content">
                        <div class="media">
                          <div class="media-left">
                            <figure class="image is-48x48">
                              <img :src="video.user.avatar" alt="Placeholder image">
                            </figure>
                          </div>
                          <div class="media-content">
                            <p class="title is-4">{{ video.user.name }}</p>
                            <p class="subtitle is-6">@{{ video.channel.name }}</p>
                          </div>
                        </div>

                        <div class="content">
                            <template v-if="video.description">
                              {{ video.description }}
                            </template>
                            <template v-else>
                                {{ video.channel.description }}
                            </template>
                          <br>
                            <p class="has-text-grey">Created {{ video.created_at_human }}</p>
                        </div>
                      </div>
                    </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
import {mapGetters,mapActions } from 'vuex'
import { mapFields } from 'vuex-map-fields';
export default {
    middleware : 'auth',
    data(){
        return {
            failed : false,
            uploading : false,
            uploadingComplete:false,
            saveStatus : null,
        }
    },
    computed : {
        ...mapFields('video', {
            description :  'videoForm.description',
            title :  'videoForm.title',
            visibility : 'videoForm.visibility',
            channel_id : 'videoForm.channel_id',
            video_filename : 'videoForm.video_filename',
            allow_votes : 'videoForm.allow_votes',
            allow_comments : 'videoForm.allow_comments',
        }),
        channels () {
            return this.userChannels(this.user.id)
        },
        ...mapGetters('channel' , { userChannels : 'getUserChannels'}),
        ...mapGetters('video', { video : 'getCurrentVideo'}),
        hasMultipleChannels(){
            return this.channels.length > 1
        },
    },
    created(){
        this.$store.dispatch('video/setCurrentVideo',this.$route.params.uid).then(() =>
            this.$store.dispatch('video/setVideoForm',this.$route.params.uid)
        )
    },
    methods : {
        ...mapActions('video', [
            'updateVideo',
        ]),
        store(){
            this.saveStatus = 'Updating Changes..'
            this.upload()
            this.updateVideo(this.$route.params.uid).then(() => {
                this.saveStatus = 'Changes Updated.'
                setTimeout(() => {
                    this.saveStatus = null
                },3000)
                // this.$router.push({
                //     name :'index'
                // })
            })
        },
        upload(){
            if (!this.hasMultipleChannels) {
                this.channel_id = this.channels[0].id
            }
        },
        fileInputChange(){
            this.uploading = true
            this.failed = false
            this.video_filename = this.$refs.video.files[0]
        },
    }
};
</script>