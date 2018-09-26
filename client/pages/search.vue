<template>
<div class="container">
    <p class="has-text-grey">Available Channels for {{ $route.query.query }}</p>
    <div class="columns" v-for="channel in channels" :key="channel.slug">
        <div class="column is-6 is-offset-2">
            <div class="box related-list">
                <article class="media related-card">
                    <div class="media-left">
                        <figure class="image">
                            <img :src="channel.avatar" style="max-width:200px" class="is-16by9" alt="Image">
                        </figure>
                    </div>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <span class="video-title">{{ channel.name }}</span>
                                <span class="video-views">239 subscribes</span>
                            </p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <hr>
     <p class="has-text-grey">Available Videos for {{ $route.query.query }}</p>
    <div class="columns" v-for="video in videos" :key="video.uid">
        <div class="column is-6 is-offset-2">
            <div class="box related-list">
                <article class="media related-card">
                    <div class="media-left">
                        <figure class="image">
                            <img :src="video.thumbnail" class="is-16by9" style="max-width:200px"  :alt="video.title + ' thumbnail'">
                        </figure>
                    </div>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <span class="video-title"> {{ video.title}}</span>
                                <span class="video-account">{{ video.channel.name }}</span>
                                <span class="video-views">{{ video.views }}</span>
                            </p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default {
        computed : {
            ...mapGetters('channel' , {
                channels : 'getSearchedData'
            }),
            ...mapGetters('video' , {
                videos : 'getSearchedData'
            })
        }
    };
</script>
<style scoped>
.related-card .video-account,.related-card .video-views {
  display:block;
  font-size: 11px;
  color: #95A5A6;
}
.video-title {
  font-size: 1.5em;
  font-weight: 500;
}
.box.video-description {
  padding:20px 20px 5px 20px;
}
.related-card .video-title {
  display:block;
  font-size: 13px;
  font-weight: 500;
}

</style>