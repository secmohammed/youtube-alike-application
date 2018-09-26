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
    data(){
        return {
            up : null,
            down : null,
            userVote : null,
        }
    },
    computed : {
        ...mapGetters('video',{
            video : 'getCurrentVideo'
        })
    }
};
</script>
