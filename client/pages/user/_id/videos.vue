<template>
<div class="container has-text-centered columns is-multiline is-centered">
  <div class="column is-one-third is-offset-2" v-for="video in videos" :key="video.uid">
    <ShowVideo :video="video" />
    <VideoControls :video="video" />
  </div>
</div>
</template>

<script>
import {mapGetters} from 'vuex'
import ShowVideo from '~/components/Videos/Show'
import VideoControls from '~/components/Videos/VideoControls'
export default {
  components : {
    ShowVideo,
    VideoControls
  },
  middleware : 'auth',
  async fetch({ store }){
    await store.dispatch('video/syncUserVideos')
  },
  computed : {
    videos(){
      return this.getUserVideos(this.$route.params.id)
    },
    ...mapGetters('video',{
      getUserVideos : 'getUserVideos'
    })
  },
};
</script>