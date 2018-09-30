<template>
<div class="box" >
    <CreateComment />
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
                    <small><a>Like</a> · <a>Reply</a></small>
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
                            <small><a>Like</a> · <a>Reply</a></small>
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
    export default {
        props : ['comments'],
        components : {
            CreateComment
        },
    };
</script>