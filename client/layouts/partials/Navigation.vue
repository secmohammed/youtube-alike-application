<template>
<nav class="navbar is-white">
    <div class="container">
        <div class="navbar-brand">
            <nuxt-link :to="{ name : 'index'}"  class="navbar-item">
            Youtube
            </nuxt-link>
            <div class="navbar-burger burger" data-target="nav">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div id="nav" class="navbar-menu">
            <div class="navbar-end">
                <template v-if="authenticated">
                    <nuxt-link :to="{ name : 'channel-slug', params : { slug : channel.slug }}" v-for="(channel,index) in channels" class="navbar-item" :key="channel.slug" v-if="index <= 1">
                        {{ channel.name }}
                    </nuxt-link>

                    <div class="navbar-item is-hoverable has-dropdown">
                            <a href="#" class="navbar-link">{{ user.name }}</a>
                        <div class="navbar-dropdown">
                            <a href="#"  class="navbar-item" @click.prevent="logout">Logout</a>
                            <nuxt-link :to="{ name : 'channel-slug-edit', params : { slug : channel.slug }}" v-for="channel in channels" class="navbar-item" :key="channel.slug">
                                {{ channel.name }} Settings
                            </nuxt-link>
                            <nuxt-link :to="{ name : 'user-id-videos', params : { id : user.id }}" class="navbar-item">
                               My Videos
                            </nuxt-link>
                            <nuxt-link :to="{ name : 'video-create' }" class="navbar-item">
                               Upload a Video
                            </nuxt-link>
                        </div>
                    </div>

                </template>
                <template v-else>
                    <nuxt-link :to="{ name : 'auth-register'}" class="navbar-item">
                        Register
                    </nuxt-link>
                    <nuxt-link :to="{ name : 'auth-login'}" class="navbar-item">
                        Login
                    </nuxt-link>

                </template>
            </div>
        </div>
    </div>
</nav>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    computed : {
        ...mapGetters('channel' , {
            channels : 'getChannels'
        })
    },
    methods : {
        logout(){
            this.$auth.logout();
        }
    }
};
</script>
<style>
</style>