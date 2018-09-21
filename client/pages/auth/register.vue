<template>
<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h1 class="title has-text-grey">Register</h1>
                <div class="box">
                        <form action="#" @submit.prevent="register">
            <div class="field">
                <label class="label">E-mail</label>
                <div class="control">
                    <input class="input is-large" :class="{'is-danger' : errors.email}" v-model="form.email" type="text" placeholder="E-mail address.">
                </div>
                <p class="help is-danger" v-if="errors.email">{{ errors.email[0] }}</p>
            </div>
            <div class="field">
                <label class="label">Full Name</label>
                <div class="control">
                    <input class="input is-large" :class="{'is-danger' : errors.name}" v-model="form.name" type="text" placeholder="E-mail address.">
                </div>
                <p class="help is-danger" v-if="errors.name">{{ errors.name[0] }}</p>
            </div>
            <div class="field">
                <label class="label">Channel Name</label>
                <div class="control">
                    <input class="input is-large" :class="{'is-danger' : errors.channel_name}" v-model="form.channel_name" type="text" placeholder="Your Fancy Channel Name !">
                </div>
                <p class="help is-danger" v-if="errors.channel_name">{{ errors.channel[0] }}</p>
            </div>
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
                    <button class="button is-large is-primary is-fullwidth" type="submit">Register</button>
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
                    name : null,
                    password_confirmation: null,
                    channel_name : null
                }
            }
        },
        methods : {
            async register(){
                await this.$axios.post('/auth/register' , this.form)
                this.$router.push({
                    name :'index'
                })
            },
        }
    };
</script>