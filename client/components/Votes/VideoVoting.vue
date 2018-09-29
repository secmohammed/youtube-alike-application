<template>
    <nav class="level is-pulled-right">
      <p class="level-item has-text-right">
        <a class="button" :class="{'is-default' : !type , 'is-primary' : type }" @click.prevent="changeVote(true)"><i class="fa fa-thumbs-up" ></i> {{ votes.up || 0 }}</a>
        <a class="button" :class="{'is-default' : type , 'is-danger' : !type }" @click.prevent="changeVote(false)"><i class="fa fa-thumbs-down"></i> {{ votes.down || 0 }}</a>
      </p>
    </nav>
</template>
<script>
import {mapMutations, mapActions} from 'vuex'
import {mapFields} from 'vuex-map-fields'
export default {
  props : ['votes'],
  computed : {
    ...mapFields('vote', {
      type : 'voteForm.user_vote'
    })
  },
  methods : {
    ...mapMutations('vote', {
      setVote : 'SET_CURRENT_VOTE_FORM'
    }),
    ...mapActions('vote', {
      pushVote : 'setVote'
    }),
    changeVote(val){
      if (this.type == !val) {
        this.type = val
        this.pushVote({ category : 'Video' , type : val , identifier : this.$route.params.uid})
      }
    }

  },
  mounted(){
    this.setVote(this.votes)
  }
};
</script>
