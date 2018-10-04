<template>
<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-6 is-offset-2">
                <div class="box related-list">
                    <article class="media related-card">
                        <div class="media-left">
                            <figure class="image">
                                <img :src="videos[0].channel.avatar + 'default.png'" style="max-width:200px" class="is-16by9" alt="Image">
                            </figure>
                        </div>
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    <span class="video-title">{{ videos[0].channel.name }} </span>
                                </p>
                                <SubscribeButton :channelSlug="videos[0].channel.slug" />
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <div class="column is-4" v-for="video in videos"  :key="video.uid">
                <ShowVideo :video="video" />
            </div>
        </div>
    </div>
</section>
</template>
<script>
import ShowVideo from '~/components/Videos/Show'
import SubscribeButton from '~/components/SubscribeButton'
import {mapGetters} from 'vuex'
export default {
    components : {
        ShowVideo,
        SubscribeButton
    },
    data(){
        videos : {}
    },
    async asyncData({ app , params}){
        return app.$axios.$get('/channel/' + params.slug + '/videos').then((response) => {
            return {
                videos : response.data
            }
        })
    }
};
</script>