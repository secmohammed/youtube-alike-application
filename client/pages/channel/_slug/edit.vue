<template>
<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h1 class="title has-text-grey">Edit Your {{ channel.name }} Channel.</h1>
                <div class="box">
                        <form action="#" @submit.prevent="submit">
            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <input class="input is-large" :class="{'is-danger' : errors.name}" name="name" v-model="name" type="text" placeholder="Your Channel Name">
                </div>
                <p class="help is-danger" v-if="errors.name">{{ errors.name[0] }}</p>
            </div>
            <div class="field">
                <label class="label">Unique URL</label>
                <div class="control">
                    <input class="input is-large" :class="{'is-danger' : errors.slug}" v-model="slug" type="text" placeholder="Your Channel URL ">
                </div>
                <p class="help is-danger" v-if="errors.slug">{{ errors.slug[0] }}</p>
            </div>
            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                    <textarea class="input is-large" :class="{'is-danger' : errors.description}" v-model="description" rows="10" cols="30"></textarea>
                </div>
                <p class="help is-danger" v-if="errors.description">{{ errors.description[0] }}</p>
            </div>
            <div class="field">
                <label class="label">Upload a fancy picture</label>
                <div class="control">
                    <input type="file" class="input"  ref="fileInput" style="display:none" v-on:change="updateAvatar" />
                    <button  class="button" :class="{'is-danger' : errors.channel_image}" @click.prevent ="$refs.fileInput.click()">Update Profile Picture.</button>

                </div>
                <p class="help is-danger" v-if="errors.description">{{ errors.description[0] }}</p>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-large is-primary is-fullwidth" type="submit">Let's do it !</button>
                </div>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
    import {mapGetters,mapActions} from 'vuex'
    import { mapFields } from 'vuex-map-fields';
    export default {
        middleware : ['auth','edit-channel'],
        computed : {
            ...mapFields('channel', {
                name :  'channelForm.name',
                slug : 'channelForm.slug',
                description : 'channelForm.description',
                avatar : 'channelForm.avatar'
            }),


            ...mapGetters('channel',{
                channel : 'getCurrentChannel'
            })
        },
        created(){
            this.$store.dispatch('channel/setCurrentChannel',this.$route.params.slug).then(() =>
                this.$store.dispatch('channel/setChannelForm',this.$route.params.slug)
            )
        },

        methods : {
            ...mapActions('channel',{
                updateChannel: 'UPDATE_CHANNEL'
            }),
            updateAvatar(e) {
              let reader = new FileReader();
              reader.readAsDataURL(e.target.files[0]);
              reader.onload = e => {
                this.avatar = e.target.result;
              };
            },
            submit(){
                this.updateChannel().then(res => {
                    this.$router.push({
                        name : 'channel-slug-edit',
                        params : { slug : res.slug}
                    })
                })
            },
        },
        // async asyncData({app , params, store}){
        //     let response = await app.$axios.$get('/channel/' + params.slug)
        //     store.dispatch('channel/setCurrentChannel',response.data)
        // }
    };
</script>