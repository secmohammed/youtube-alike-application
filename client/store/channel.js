import {
    getField,
    updateField
} from 'vuex-map-fields';

export const state = () => ({
    channels: [],
    currentChannel: null,
    channelForm: {},
    searches: []
})

export const getters = {
    getChannels: (state) => state.channels,
    getCurrentChannel: (state) => state.currentChannel,
    getUserChannels: (state) => (userId) => state.channels.filter(channel => channel.user.id == userId),
    getChannel: (state) => (slug) => state.channels.find(channel => channel.slug == slug),
    getChannelForm: (state) => state.channelForm,
    getSearchedData: (state) => state.searches,
    getField,


}

export const mutations = {
    SET_SEARCH_DATA(state, data) {
        state.searches = data
    },
    SET_CHANNELS(state, channels) {
        state.channels = channels
    },
    SET_CURRENT_CHANNEL(state, channel) {
        state.currentChannel = channel
    },
    SET_CHANNEL(state, channel) {
        state.channels.push(channel)
    },
    UNSET_CHANNEL(state, slug) {
        state.channels = state.channels.filter(channel => channel.slug !== slug)
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
    }, slug) {
        let current = getters.getChannelForm
        let form = new FormData()
        for (let input in getters.getChannelForm) {
            if (input == 'avatar' && typeof current[input] == 'object') {
                form.append(input, current[input], current[input].name)
            }
            if (input != 'avatar') {
                form.append(input, current[input])
            }
        }
        return this.$axios.$post(`/channel/${slug}/update`, form).then((response) => {
            commit('UNSET_CHANNEL', slug)
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
    async setSearchData({
        commit,
        dispatch
    }, query) {
        let response = await this.$axios.$get('/search?q=' + query)
        commit('SET_SEARCH_DATA', response.data)
        commit('video/SET_SEARCH_DATA', response.videos, {
            root: true
        })
        return response
    }

}