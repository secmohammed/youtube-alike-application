<template v-if="subscription.count">
    <div>
        <p> {{ subscription.count }} Subscribers</p>
        <a href="#" @click.prevent="handle" class="button is-danger is-small" v-if="subscription.can_subscribe"><i class="fa fa-plus-square"></i>{{  subscription.user_subscribed ? 'Unsubscribe' : 'Subscribe'}}</a>
    </div>
</template>
<script>
    import {mapActions , mapGetters} from 'vuex'
    export default {
        props : {
            channelSlug : null
        },
        computed:{
            ...mapGetters('subscription',{
                subscription : 'getCurrentChannelSubscription'
            })
        },
        methods : {
            ...mapActions('subscription',['fetchChannelSubscriptions','subscribe','unsubscribe']),
            handle(){
                if (this.subscription.user_subscribed) {
                    this.unsubscribe(this.channelSlug)
                }else {
                    this.subscribe(this.channelSlug)
                }
            }
        },
        created(){
            this.fetchChannelSubscriptions(this.channelSlug)
        }
    };
</script>