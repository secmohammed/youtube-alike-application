<template>
<div class="card">
    <div class="card-image">
        <nuxt-link :to="{ name : 'video-uid' , params : { uid : video.uid}}">
        <figure class="image is-4by3">
            <img :src="video.thumbnail" alt="Placeholder image">
        </figure>
        </nuxt-link>
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
                <p class="subtitle is-6">
                    <nuxt-link :to="{ name : 'channel-slug', params : { slug : video.channel.slug}}" >@{{ video.channel.name }}</nuxt-link>
                </p>
            </div>
        </div>
        <div class="content">
            <template v-if="video.processed && video.processed_percentage">
                <progress class="progress is-primary" :value="video.processed_percentage" max="100">{{ video.processed_percentage }}%</progress>
            </template>
            <template v-if="video.description">
                {{ video.description }}
            </template>
            <template v-else>
                {{ video.channel.description }}
            </template>
            <br>
            <p class="has-text-grey">Created {{ video.created_at_human }}</p>
        </div>
    </div>
</div>
</template>
<script>
    export default {
        props : ['video']
    };
</script>