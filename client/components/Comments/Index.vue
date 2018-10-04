<template>
<div class="box" >
    <CreateComment v-if="authenticated" />
    <article class="media" v-for="comment in comments" :key="comment.id">
        <figure class="media-left">
            <p class="image is-64x64">
                <img :src="comment.user.avatar">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>
                    <strong>{{ comment.user.name }}</strong> <small> · {{ comment.created_at_human }}</small>
                    <br>
                    {{ comment.body }}
                    <br>
                    <small v-if="authenticated"> <a @click.prevent="toggleReplyForm(comment.id)" v-if="authenticated">{{ reply_id === comment.id ? 'Cancel' : 'Reply' }}</a> . <a @click.prevent="deleteComment(comment.id)" v-if="user.id == comment.user.id">Delete</a></small>
                    <CreateReply v-if="authenticated && reply_id == comment.id" :commentId="comment.id" />

                </p>
            </div>
            <article class="media" v-if="comment.replies" v-for="reply in comment.replies" :key="reply.id">
                <figure class="media-left">
                    <p class="image is-64x64">
                        <img :src="reply.user.avatar">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>{{ reply.user.name }}</strong> <small> · {{ reply.created_at_human }}</small>
                            <br>
                            {{ reply.body }}
                            <br>
                            <small v-if="authenticated"><a @click.prevent="deleteReply(reply.id)" v-if="user.id == reply.user.id">Delete</a></small>
                        </p>
                    </div>
                </div>
            </article>
        </div>
    </article>
    <div class="spacer"></div>
</div>
</template>
<script>
    import CreateComment from './Create.vue'
    import CreateReply from '../Replies/Create.vue'
    import { mapFields } from 'vuex-map-fields';
    import {mapActions} from 'vuex';
    export default {
        props : ['comments'],
        components : {
            CreateComment,
            CreateReply
        },
        computed : {
            ...mapFields('comment', {
               reply_id :  'replyForm.reply_id',
               replyBody : 'replyForm.body'
            }),

        },
        methods : {
            ...mapActions('comment',{
              delete : 'deleteComment',
              destroy : 'deleteReply'
            }),
            deleteComment(commentId){
                this.delete({
                    uid: this.$route.params.uid,
                    id : commentId
                })
            },
            deleteReply(replyId){
                this.destroy({
                    uid: this.$route.params.uid,
                    id : replyId
                })
            },
            toggleReplyForm(commentId){
                this.replyBody = null
                if (this.reply_id == commentId) {
                    this.reply_id = null
                    return;
                }
                this.reply_id = commentId
            },
        }
    };
</script>