<template>
    <nav class="level is-pulled-right">
      <p class="level-item has-text-right">
        <a class="button is-default"><i class="fa fa-thumbs-up"></i> 5254</a>
        <a class="button is-default"><i class="fa fa-thumbs-down"></i> 1</a>
      </p>
    </nav>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    // it works with mounted.
    async asyncData({app, params}){
        let response = await app.$axios.$get(`/videos/${params.uid}/votes`)
        return {
            can_vote : response.data.can_vote
        }

    },
};
</script>
