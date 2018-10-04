<template>
<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4" v-for="video in videos"  :key="video.uid">
               <ShowVideo :video="video" />
            </div>
        </div>
    </div>
</section>
</template>
<script>
import ShowVideo from '~/components/Videos/Show'
export default {
    components : {
        ShowVideo
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