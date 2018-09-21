<template>
<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h1 class="title has-text-grey">Show the world something worthy !</h1>
                <div class="box">
                    <form action="#" method="POST" >
                        <div class="field">
                            <div class="file is-info has-name" v-if="!uploading">
                                <label class="file-label">
                                    <input ref="video" class="file-input" type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">
                                    <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">
                                            Browse file..
                                        </span>
                                    </span>
                                    <span class="file-name" v-if="video_filename != null">
                                        {{ video_filename.name }}
                                    </span>
                                </label>
                            </div>
                            <p class="help is-danger" v-if="failed">Something went wrong.</p>
                        </div>
                        <template v-if="uploading && !failed">
                            <p class="help is-info" v-if="!uploadingComplete"> Your video will be available at x </p>
                            <p class="help is-success" v-if="uploadingComplete"> Your video is processing. <a href="#">go to your video</a></p>
                            <div v-if="!uploadingComplete">
                                <progress class="progress is-medium" max="100" :value="progress" :class="{ 'is-success' : uploading && !failed , 'is-danger' : failed}">{{ progress }}%</progress>
                            </div>
                             <div class="field" v-if="hasMultipleChannels">
                            <label class="label">Tell me, which channel </label>
                            <div class="control">
                                  <div class="select  is-rounded is-fullwidth">
                                    <select v-model="channel_slug">
                                      <option :value="channel.slug" :key="channel.slug" v-for="channel in channels">{{ channel.name }}</option>
                                    </select>
                                  </div>
                            </div>
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
                            <div class="control">
                                <span class="help pull-right" v-if="saveStatus">{{ saveStatus }} </span>
                                <button class="button is-large is-primary is-fullwidth" type="submit" @click.prevent="store">Release Video</button>
                            </div>
                        </div>
                        </template>
                    </form>
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
    mounted(){
        window.onbeforeunload = () => {
            if(this.uploading && !this.uploadingComplete && !this.failed){
                return 'Are you sure you want to navigate away ?'
            }
        }
    },
    data(){
        return {
            uploading: false,
            uploadingComplete: false,
            failed: false,
            saveStatus: null,
            channel_slug : null,
        }
    },
    computed : {
        ...mapFields('video', {
           description :  'videoForm.description',
            title : 'videoForm.title',
            visibility : 'videoForm.visibility',
            video_filename : 'videoForm.video_filename',
            progress : 'videoUploadProgress'
        }),

        channels () {
            return this.userChannels(this.user.id)
        },
        ...mapGetters('channel' , { userChannels : 'getUserChannels'}),
        hasMultipleChannels(){
            return this.channels.length > 1
        }
    },
    methods : {
        ...mapActions('video', [
            'createVideo'
        ]),
        store(){
            this.saveStatus = 'Saving Changes..'
            this.upload()
            this.createVideo(this.channel_slug).then(() => {
                this.saveStatus = 'Changes Saved.'
                this.uploadingComplete = true
                this.progress = 0
                setTimeout(() => {
                    this.saveStatus = null
                },3000)
            }, () => {
                this.failed = true
            }, () => {
                this.failed = true
            })
        },
        upload(){
            if (!this.hasMultipleChannels) {
                this.channel_slug = this.channels[0].slug
            }
        },
        fileInputChange(e){
            this.uploading = true
            this.failed = false
            this.video_filename = this.$refs.video.files[0]
        },
    }
};
</script>