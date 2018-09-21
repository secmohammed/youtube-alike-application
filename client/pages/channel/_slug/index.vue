<template>
<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4" v-for="video in videos"  :key="video.uid">
                <div class="card">
                    <div class="card-image">
                        <figure class="image is-4by3">
                            <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                        </figure>
                    </div>
                    <div class="card-content">
                        <div class="media">
                            <div class="media-left">
                                <figure class="image is-48x48">
                                    <img :src="video.user.avatar" alt="Placeholder image">
                                </figure>
                            </div>
                            <div class="media-content">
                                <p class="title is-4">{{ video.user.name }}</p>
                            </div>
                        </div>
                        <div class="content">
                            <template v-if="video.description">
                            {{ video.description }}
                            </template>
                            <br>
                            <p class="has-text-grey">Created {{ video.created_at_human }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        videos : {}
    },
    async asyncData({ app , params}){
        return app.$axios.$get('/channel/' + params.slug + '/videos').then((response) => {
            return {
                videos : response.data
            }
        })
    }
};
</script>