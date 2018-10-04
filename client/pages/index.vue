<template>
<div class="container has-text-centered columns is-multiline is-centered">
  <div class="column is-one-third is-offset-2" v-for="video in videos" :key="video.uid">
    <ShowVideo :video="video" />

  </div>
</div>
</template>

<script>
import {mapGetters} from 'vuex'
import ShowVideo from '~/components/Videos/Show'
export default {
    components : {
        ShowVideo,
    },
    middleware: 'auth',
    computed : {
        ...mapGetters('video',{
            videos : 'getSubscriptionVideos'
        })
    },
};
</script>

<style>

</style>

