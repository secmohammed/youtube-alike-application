import {
    getField,
    updateField
} from 'vuex-map-fields';

export const state = () => ({
    channels: [],
    currentChannel: null,
    channelForm: {}
})

export const getters = {
    getChannels: (state) => state.channels,
    getCurrentChannel: (state) => state.currentChannel,
    getUserChannels: (state) => (userId) => state.channels.filter(channel => channel.user.id == userId),
    getChannel: (state) => (slug) => state.channels.find(channel => channel.slug == slug),
    getChannelForm: (state) => state.channelForm,
    getField,


}

export const mutations = {
    SET_CHANNELS(state, channels) {
        state.channels = channels
    },
    SET_CURRENT_CHANNEL(state, channel) {
        state.currentChannel = channel
    },
    SET_CHANNEL(state, channel) {
        state.channels.push(channel)
    },
    UNSET_CHANNEL(state, channel) {
        state.channels = state.channels.filter(ch => ch.id !== channel.id)
    },
    UPDATE_CHANNEL_FORM: (state, channel) => {
        state.channelForm = channel
    },
    UNSET_CHANNEL_FORM: (state) => state.channelForm = {},
    updateField,

}

export const actions = {
    async nuxtServerInit({
        dispatch,
        rootGetters
    }) {
        if (rootGetters['auth/authenticated']) {
            await dispatch('fetchUserChannels')
        }
    },
    SET_CHANNELS({
        commit
    }, channels) {
        commit('SET_CHANNELS', channels)
    },
    SET_CHANNEL({
        commit
    }, channel) {
        commit('SET_CHANNEL', channel)
    },
    UPDATE_CHANNEL({
        commit,
        getters
    }) {
        let current = getters.getCurrentChannel
        return this.$axios.$put(`/channel/${current.slug}`, getters.getChannelForm).then((response) => {
            commit('UNSET_CHANNEL', current)
            commit('SET_CHANNEL', response.data)
            commit('SET_CURRENT_CHANNEL', response.data)
            return response.data
        })
    },
    fetchChannelVideos({
        commit,
        getters
    }, slug) {

    },
    fetchUserChannels({
        commit,
        rootGetters
    }) {
        return this.$axios.$get(`/user/${rootGetters['auth/user'].id}/channels`).then(response => {
            commit('SET_CHANNELS', response.data)
            return response.data
        })
    },
    setCurrentChannel({
        commit,
        getters
    }, slug) {
        let channel = getters['getChannel'](slug)
        if (channel) {
            commit('SET_CURRENT_CHANNEL', channel)
            return getters.getCurrentChannel
        } else {
            return this.$axios.get(`/channel/${slug}`).then(res => {
                commit('SET_CURRENT_CHANNEL', res.data)
                commit('SET_CHANNEL', res.data)
                return res.data
            })
        }

    },
    setChannelForm({
        commit,
        dispatch
    }, slug) {
        dispatch('setCurrentChannel', slug).then((channel) => {
            commit('UPDATE_CHANNEL_FORM', {
                name: channel.name,
                slug: channel.slug,
                avatar: channel.avatar,
                description: channel.description
            })
        })

    },

}