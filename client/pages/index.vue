<template>
  <section class="container">
    <p class="is-danger">Hello</p>
    {{ videos }}
  </section>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
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

