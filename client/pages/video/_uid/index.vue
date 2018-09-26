<template>
<div class="container">
    <div class="columns">
      <div class="column is-8">
        <div  class="video-player-box" :playsinline="true" v-video-player:myVideoPlayer="playerOptions" @playing="onPlayerPlaying($event)"></div>
        <br>
        <div class="box video-meta">
          <div class="video-title">{{ video.title }}</div>
          <br>
          <article class="media">
            <div class="media-left">
              <figure class="image is-64x64">
                <img :src="video.channel.avatar" alt="Image">
              </figure>
            </div>
            <div class="media-content">
              <div class="content">
                <div class="columns">
                  <div class="column is-6">
                    <p>
                      <strong>{{ video.channel.name }}</strong>
                      <br>
                      <a href="#" class="button is-danger"><i class="fa fa-plus-square"></i>Subscribe</a>
                    </p>
                  </div>
                  <div class="column is-6">
                        <span class="title is-4 is-pulled-right">{{ video.views }} views</span>
                  </div>

                </div>
                <VideoVoting/>
              </div>
            </div>
          </article>
        </div>
        <div class="box video-description">
          <p><strong>Uploaded {{ video.created_at_human }}</strong></p>
          <p v-if="video.description" v-text="video.description"></p>
          <hr>
          <p v-if="video.description.length > 10" class="has-text-centered has-text-muted video-description-more">Show More</p>
        </div>
        <div class="box" >
          <article class="media" v-if="authenticated">
            <figure class="media-left">
              <p class="image is-64x64">
                <img :src="user.avatar">
              </p>
            </figure>
            <div class="media-content">
              <p class="control">
                <textarea class="textarea" placeholder="Add a comment..."></textarea>
              </p>
              <br>
              <nav class="level">
                <div class="level-left">
                  <div class="level-item">
                    <a class="button is-info">Post comment</a>
                  </div>
                </div>
              </nav>
            </div>
          </article>
          <hr>
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
      </div>
    </div>
</div>
</template>
<script>
    import {mapGetters,mapActions} from 'vuex'
    import VideoVoting from '~/components/Votes/VideoVoting'
    export default {
        components: {
            VideoVoting
        },
        data(){
            return {
                duration : null
            }
        },
        computed : {
            ...mapGetters('video',{
                video : 'getCurrentVideo'
            }),
            playerOptions(){
                return {
                  height: '920',
                  width : '1080',
                  autoplay: false,
                  muted: false,
                  language: 'en',
                  playbackRates: [0.7, 1.0, 1.5, 2.0],
                  sources: [{
                    type: "video/mp4",
                    src: this.video.video_url,
                  }],
                  poster: this.video.thumbnail,
                }
            }
        },
        async fetch({ store , params }){
            await store.dispatch('video/setCurrentVideo', params.uid)
        },
        methods : {
            ...mapActions('video',{
                createView : 'createView'
            }),
            hasHitQuotaView(player){
                if (!this.duration) {
                    return false;
                }
                if (player) {
                    return Math.round(player.currentTime()) === Math.round(10 * this.duration / 100 );
                }
            },
            onPlayerPlaying(player) {
                if (player) {
                    this.duration = Math.round(player.duration())
                    setInterval(() => {
                        if (this.hasHitQuotaView(player)) {
                            this.createView()
                        }
                    }, 1000)
                }
            },
        }
    };
</script>

<style scoped>
 .has-text-muted {
  color: #95A5A6;
}
.spacer {
  height:20px;
}
.nav-left .searchbox {
  margin-top: 10px;
}
.avatar-photo {
  border-radius: 50px;
}
.video-title {
  font-size: 1.5em;
  font-weight: 500;
}
.box.video-description {
  padding:20px 20px 5px 20px;
}
.video-description-more {
  font-size: 12px;
  font-weight: bold;
  text-transform: uppercase;
  margin-top: -15px;
}
.related-card .video-title {
  display:block;
  font-size: 13px;
  font-weight: 500;
}
.related-card .video-account,.related-card .video-views {
  display:block;
  font-size: 11px;
  color: #95A5A6;
}

.related-card img {
  height:68px;
}
.related-card.media .media, .related-card.media+.media {
    border-top: none;
}
.related-list .autoplay {
  padding-bottom: 10px;
}

.related-list .autoplay .autoplay-title {
  font-weight: bold;
}
.related-list .autoplay .autoplay-toggle {
  float:right;
}
.related-list .autoplay .autoplay-toggle .fa{
  font-size: 13px;
  padding:5px 10px;
}
</style>