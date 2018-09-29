<template>
<div class="box" >
    <CreateComment />
    <article class="media">
        <figure class="media-left">
            <p class="image is-64x64">
                <img src="http://placehold.it/128x128">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>
                    <strong>Barbara Middleton</strong> <small> · 3 hrs</small>
                    <br>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis porta eros lacus, nec ultricies elit blandit non. Suspendisse pellentesque mauris sit amet dolor blandit rutrum. Nunc in tempus turpis.
                    <br>
                    <small><a>Like</a> · <a>Reply</a></small>
                </p>
            </div>
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