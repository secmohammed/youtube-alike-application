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
                    <input class="input is-large" v-validate="'required|min:8|email'" name="email" :class="{'is-danger' : errors.has('email')}" v-model="form.email" type="text" placeholder="E-mail address.">
                </div>
                <p class="help is-danger" v-if="errors.has('email')">{{ errors.first('email') }}</p>
            </div>
            <div class="field">
                <label class="label">Full Name</label>
                <div class="control">
                    <input class="input is-large" v-validate="'required|min:8'" name="name" :class="{'is-danger' : errors.has('name')}" v-model="form.name" type="text" placeholder="Your Full Name !">
                </div>
                <p class="help is-danger" v-if="errors.has('name')">{{ errors.first('name') }}</p>
            </div>
            <div class="field">
                <label class="label">Channel Name</label>
                <div class="control">
                    <input class="input is-large" :class="{'is-danger' : errors.has('channel_name')}" v-validate="'required'" name="channel_name" v-model="form.channel_name" type="text" placeholder="Your Fancy Channel Name !">
                </div>
                <p class="help is-danger" v-if="errors.has('channel_name')">{{ errors.first('channel_name') }}</p>
            </div>
            <div class="field">
                <label class="label">Password</label>
                <div class="control">
                    <input class="input is-large" v-validate="'required|min:8|max:32|confirmed:password_confirmation'" :class="{'is-danger' : errors.has('password')}" name="password" v-model="form.password" type="password" placeholder="Password">
                </div>
                <p class="help is-danger" v-if="errors.has('password')">{{ errors.first('password') }}</p>
            </div>
            <div class="field">
                <label class="label">Password Confirmation</label>
                <div class="control">
                    <input class="input is-large" v-model="form.password_confirmation" type="password" placeholder="Password">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-large is-primary is-fullwidth" type="submit" :disabled="errors.any() || isCompleted">Register</button>
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
        computed : {
            isCompleted(){
                for (let field in this.form) {
                    if (!this.form[field]) {
                        return false
                    }
                }
                return true
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