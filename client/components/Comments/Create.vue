<template>
<article class="media">
    <figure class="media-left">
        <p class="image is-64x64">
            <img :src="user.avatar">
        </p>
    </figure>
    <div class="media-content">
        <p class="control">
            <textarea class="textarea" name="body" v-model="body" placeholder="Add a comment..." v-validate.lazy="'required|min:3|max:250'"></textarea>
        </p>
        <br>
        <nav class="level">
            <div class="level-left">
                <div class="level-item">
                    <button class="button is-info" type="submit" @click.prevent="submit" :disabled="errors.any() || !isCompleted">Post comment</button>
                </div>
            </div>
            <div class="level-right">
                <p class="help is-danger" v-if="errors.has('body')">{{ errors.first('body') }}</p>
            </div>
        </nav>
    </div>
</article>
</template>
<script>
    import { mapActions } from 'vuex'
    import { mapFields } from 'vuex-map-fields';
    export default {
        computed : {
            ...mapFields('comment', {
               body :  'commentForm.body',
            }),

            isCompleted(){
                return !! this.body
            }
        },
        methods : {
            ...mapActions('comment',{
                create : 'createComment'
            }),
            submit(){
                this.create(this.$route.params.uid)
            }
        }
    };
</script>