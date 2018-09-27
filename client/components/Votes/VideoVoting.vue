<template>
    <nav class="level is-pulled-right">
      <p class="level-item has-text-right">
        {{ votes.user_vote }}
        <a class="button is-default"><i class="fa fa-thumbs-up"></i> {{ votes.up || 0 }}</a>
        <a class="button is-default"><i class="fa fa-thumbs-down"></i> {{ votes.down || 0 }}</a>
      </p>
    </nav>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    props : ['votes'],
    mounted(){
        console.log(this.votes.user_vote , this.votes.up)
    },
};
</script>
