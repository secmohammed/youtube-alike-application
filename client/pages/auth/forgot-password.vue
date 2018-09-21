<template>
    <div>
        <section class="hero">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <div class="column is-4 is-offset-4">
                        <h1 class="title has-text-grey">It's okei, we all lose our passwords one day :/</h1>
                        <div class="box">
                                <form action="#" @submit.prevent="submit">
                    <div class="field">
                        <label class="label">E-mail</label>
                        <div class="control">
                            <input class="input is-large" :class="{'is-danger' : errors.email}" v-model="form.email" type="text" placeholder="E-mail address.">
                        </div>
                        <p class="help is-danger" v-if="errors.email">{{ errors.email[0] }}</p>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-large is-primary is-fullwidth" type="submit">Give me token !</button>
                        </div>
                    </div>
                </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    export default {
        middleware : ['guest'],
        data(){
            return {
                form : {
                    email : null
                }
            }
        },
        methods : {
            submit(){
                this.$axios.$post('/auth/forgot-password',this.form).then(res => alert(res.message))
            }
        }
    };
</script>