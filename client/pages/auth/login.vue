<template>
<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h1 class="title has-text-grey">Login</h1>
                <div class="box">
                        <form action="#" @submit.prevent="login">
            <div class="field">
                <label class="label">E-mail</label>
                <div class="control">
                    <input class="input is-large" :class="{'is-danger' : errors.email}" v-model="form.email" type="text" placeholder="E-mail address.">
                </div>
                <p class="help is-danger" v-if="errors.email">{{ errors.email[0] }}</p>
            </div>
            <div class="field">
                <label class="label">Password</label>
                <div class="control">
                    <input class="input is-large"  :class="{'is-danger' : errors.password}" v-model="form.password" type="password" placeholder="Password">
                </div>
                <p class="help is-danger" v-if="errors.password">{{ errors.password[0] }}</p>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-large is-primary is-fullwidth" type="submit">Login</button>
                    <p class="help has-text-grey has-text-centered"><nuxt-link :to="{ name : 'auth-forgot-password'}">Forgot your password?</nuxt-link></p>
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
        middleware : 'guest',
        data(){
            return {
                form : {
                    password : null,
                    email : null,
                }
            }
        },
        methods : {
            login(){
                this.$auth.login({
                    data : this.form
                }).then(() => window.location = '/')
            },
        }
    };
</script>