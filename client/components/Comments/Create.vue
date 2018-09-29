<template>
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
</template>