<template>
<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h1 class="title has-text-grey">Let's reset your password and get you back to work. !</h1>
                <div class="box">
                    <form action="#" @submit.prevent="reset">
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input is-large"  :class="{'is-danger' : errors.password}" v-model="form.password" type="password" placeholder="Password">
                            </div>
                            <p class="help is-danger" v-if="errors.password">{{ errors.password[0] }}</p>
                        </div>
                        <div class="field">
                            <label class="label">Password Confirmation</label>
                            <div class="control">
                                <input class="input is-large"  :class="{'is-danger' : errors.password_confirmation}" v-model="form.password_confirmation" type="password" placeholder="Password">
                            </div>
                            <p class="help is-danger" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</p>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-large is-primary is-fullwidth" type="submit">reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    middleware : ['guest','has-reset-token'],
    data(){
        return {
            form : {
                password : null,
                password_confirmation:  null
            }
        }
    },
    methods : {
        async reset(){
            await this.$axios.$post('/auth/reset-password?token=' + this.$route.query.token, this.form)
            this.$router.push({
                name :'index'
            })
        },
    }
};
</script>