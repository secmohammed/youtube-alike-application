<template>
  <div class="container">
    <div class="columns">
      <div class="column is-8">
        <div class="image">
          <img src="https://placehold.it/800x500">
        </div>
        <br>
        <div class="box video-meta">
          <div class="video-title">A video title would go here</div>
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
                      <a href="#" class="button is-danger">Subscribe</a>
                    </p>
                  </div>
                  <div class="column is-6">
                        <span class="title is-4 is-pulled-right">124 304 views</span>
                  </div>

                </div>
                <nav class="level is-pulled-right">
                  <p class="level-item has-text-right">
                    <a class="button is-default"><i class="fa fa-thumbs-up"></i> 5254</a>
                    <a class="button is-default"><i class="fa fa-thumbs-down"></i> 1</a>
                  </p>
                </nav>
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
        <div class="box">
          <article class="media">
            <figure class="media-left">
              <p class="image is-64x64">
                <img src="http://placehold.it/128x128">
              </p>
            </figure>
            <div class="media-content">
              <p class="control">
                <textarea class="textarea" placeholder="Add a comment..."></textarea>
              </p>
              <nav class="level">
                <div class="level-left">
                  <div class="level-item">
                    <a class="button is-info">Post comment</a>
                  </div>
                </div>
                <div class="level-right">
                  <div class="level-item">
                    <label class="checkbox">
                      <input type="checkbox"> Press enter to submit
                    </label>
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
        </div>
      </div>
      <div class="column is-4">
        <div class="box related-list">
          <p class="autoplay">
            <span class="autoplay-title">Up next</span>
            <span class="autoplay-toggle">
              Autoplay
              <i class="fa fa-info-circle"></i>
            </span>
          </p>
          <article class="media related-card">
            <div class="media-left">
              <figure class="image">
                <img src="http://placehold.it/120x90" alt="Image">
              </figure>
            </div>
            <div class="media-content">
              <div class="content">
                <p>
                  <span class="video-title">A video title</span>
                  <span class="video-account">asasdas</span>
                  <span class="video-views">239 views</span>
                </p>
              </div>
            </div>
          </article>
          <hr>
        </div>
      </div>
    </div>
</div>
</template>