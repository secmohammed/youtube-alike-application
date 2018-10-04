<template>
    <footer class="card-footer" v-if="user.id == video.user.id">
      <nuxt-link :to="{name : 'video-uid-edit' , params : { uid : video.uid}}" class="card-footer-item">Edit</nuxt-link>
      <a href="#" class="card-footer-item" @click.prevent="destroy(video.uid)">Delete</a>
    </footer>
</template>
<script>
    import {mapActions } from 'vuex'
    export default {
        props : ['video'],
          methods : {
            ...mapActions('video',{
              destroy : 'destroyVideo'
            })
        }
    };
</script>