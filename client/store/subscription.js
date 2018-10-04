export const state = () => ({
    subscriptions: {},
    currentChannelSubscription: {}
})
export const getters = {
    getChannelSubscriptions: (state) => state.subscriptions,
    getCurrentChannelSubscription: (state) => state.currentChannelSubscription
}
export const mutations = {
    PUSH_CHANNEL_SUBSCRIPTION(state, payload) {
        let slug = payload.slug
        state.subscriptions[slug] = payload.subscriptions
    },
    SET_CURRENT_CHANNEL_SUBSCRIPTION(state, subscription) {
        state.currentChannelSubscription = subscription
    },
    UNSUBSCRIBE_TO_CHANNEL(state, slug) {
        state.currentChannelSubscription.user_subscribed = false
        state.currentChannelSubscription.count -= 1
        state.subscriptions[slug] = state.currentChannelSubscription

    },
    SUBSCRIBE_TO_CHANNEL(state, slug) {
        state.currentChannelSubscription.user_subscribed = true
        state.currentChannelSubscription.count += 1
        state.subscriptions[slug] = state.currentChannelSubscription
    }

}
export const actions = {
    fetchChannelSubscriptions({
        commit
    }, slug) {
        return this.$axios.$get(`/subscriptions/${slug}`).then(response => {
            commit('PUSH_CHANNEL_SUBSCRIPTION', {
                slug: slug,
                subscriptions: response.data
            })
            commit('SET_CURRENT_CHANNEL_SUBSCRIPTION', response.data)
        })
    },
    subscribe({
        commit
    }, slug) {
        return this.$axios.$post(`/subscription/${slug}`).then(response => {
            commit('SUBSCRIBE_TO_CHANNEL', slug)
        })
    },
    unsubscribe({
        commit
    }, slug) {
        return this.$axios.$delete(`/subscription/${slug}`).then(response => {
            commit('UNSUBSCRIBE_TO_CHANNEL', slug)
        })
    },
}