import {
    getField,
    updateField
} from 'vuex-map-fields';
export const state = () => ({
    videos: [],
    currentVideo: null,
    videoForm: {
        description: null,
        title: null,
        video_filename: null,
        visibility: null
    },
    videoUploadProgress: 0,
    searches: [],
    subscriptionVideos: []
})
export const getters = {
    videos: (state) => state.videos,
    getVideo: (state) => (uid) => state.videos.find(video => video.uid == uid),
    getUserVideos: (state) => (userId) => state.videos.filter(video => video.user_id == userId),
    getCurrentVideo: (state) => state.currentVideo,
    getVideoForm: (state) => state.videoForm,
    getSearchedData: (state) => state.searches,
    getSubscriptionVideos: (state) => state.subscriptionVideos,
    getField,
}
export const mutations = {
    SET_SEARCH_DATA: (state, data) => state.searches = data,
    SET_VIDEOS: (state, videos) => state.videos = videos,
    SET_VIDEO: (state, video) => state.videos.push(video[0]),
    UPDATE_VIDEO_FORM: (state, video) => {
        state.videoForm = video
    },
    SET_CURRENT_VIDEO: (state, video) => {
        state.currentVideo = video
    },
    UNSET_CURRENT_VIDEO: (state) => {
        state.currentVideo = null
    },
    UNSET_VIDEO: (state, uid) => state.videos = state.videos.filter(video => video.uid != uid),
    SET_UPLOAD_PORGRESS_BAR: (state, progress) => {
        state.videoUploadProgress = progress
    },
    UNSET_VIDEO_FORM: (state) => state.videoForm = {
        description: null,
        title: null,
        video_filename: null,
        visibility: null
    },
    SET_CURRENT_VIDEO_VOTES: (state, votes) => state.currentVideo.votes = votes,
    SET_VIDEO_VOTES: (state, payload) => {
        let video = state.videos.find(video => video.uid == payload.uid)
        if (video && video.allow_votes) {
            video.votes = payload.votes
        }
    },
    SET_CURRENT_VIDEO_VIEWS: (state, views) => state.currentVideo.views = views,
    SET_VIDEO_VIEWS: (state, payload) => {
        let video = state.videos.find(video => video.uid == payload.uid)
        if (video) {
            video.views = payload.views
        }
    },
    // Improve : once the user is subscribing to a new channel ,fetch its videos and push to subscriptions instantly.
    SET_SUBSCRIPTION_VIDEOS(state, videos) {
        state.subscriptionVideos = videos
    },
    updateField,
}
export const actions = {
    async nuxtServerInit({
        dispatch,
        rootGetters
    }) {
        if (rootGetters['auth/authenticated']) {
            await dispatch('fetchUserVideos')
            await dispatch('fetchSubscriptionVideos')
        }
    },
    fetchSubscriptionVideos({
        commit,
    }) {
        return this.$axios.$get('/subscription/videos').then(response => {
            commit('SET_SUBSCRIPTION_VIDEOS', response.data)
            return response.data
        })

    },
    fetchUserVideos({
        commit,
        rootGetters
    }) {
        return this.$axios.$get(`/user/${rootGetters['auth/user'].id}/videos`).then(response => {
            console.log(response.data.data)
            commit('SET_VIDEOS', response.data)
            return response.data
        })
    },
    setVideos: ({
        commit
    }, videos) => commit('SET_VIDEOS', videos),
    setVideo: ({
        commit
    }, video) => commit('SET_VIDEO', video),
    setCurrentVideo({
        commit,
        getters
    }, uid) {
        let localVideo = getters.getVideo(uid)
        if (localVideo) {
            commit('SET_CURRENT_VIDEO', localVideo)
            return getters.getCurrentVideo
        } else {
            return this.$axios.$get(`/videos/${uid}`).then(res => {
                commit('SET_CURRENT_VIDEO', res.data)
                commit('SET_VIDEO', res.data)
                return res.data
            })
        }
    },
    setVideoForm({
        commit,
        dispatch
    }, uid) {
        dispatch('setCurrentVideo', uid).then((video) => {
            commit('UPDATE_VIDEO_FORM', {
                channel_id: video.channel.id,
                title: video.title,
                visibility: video.visibility,
                video_filename: video.video_filename,
                description: video.description,
                allow_votes: !!video.allow_votes,
                allow_comments: !!video.allow_comments
            })
        })

    },
    createVideo({
        commit,
        getters
    }, channelSlug) {
        let form = new FormData
        for (let input in getters.getVideoForm) {
            form.append(input, getters.getVideoForm[input])
        }
        return this.$axios.$post(`/videos/${channelSlug}`, form, {
            onUploadProgress: uploadEvent => {
                if (getters.getVideoForm.video_filename) {
                    commit('SET_UPLOAD_PORGRESS_BAR', Math.round(uploadEvent.loaded / uploadEvent.total) * 100)
                }
            }
        }).then((response) => {
            commit('SET_VIDEO', response.data)
            commit('UNSET_VIDEO_FORM')
        })
    },
    updateVideo({
        commit,
        getters
    }, uid) {
        let form = new FormData()
        for (let input in getters.getVideoForm) {
            if (input == 'video_filename' && typeof getters.getVideoForm[input] == 'object') {
                form.append(input, getters.getVideoForm[input], getters.getVideoForm[input].name)
            }
            if (input != 'video_filename') {
                form.append(input, getters.getVideoForm[input])
            }
        }
        return this.$axios.$post(`/videos/${uid}/update`, form).then((response) => {
            commit('UNSET_VIDEO', uid)
            commit('SET_VIDEO', response.data)
            commit('UNSET_VIDEO_FORM')
        })
    },
    destroyVideo({
        commit,
        getters
    }, uid) {
        return this.$axios.$delete(`/videos/${uid}`).then(() => {
            commit('UNSET_VIDEO', uid)
            commit('UNSET_VIDEO_FORM')
            commit('UNSET_CURRENT_VIDEO')
        })
    },
    createView({
        commit,
        getters
    }) {
        let video = getters.getCurrentVideo
        this.$axios.$post(`/videos/${video.uid}/views`).then((response) => {
            commit('SET_CURRENT_VIDEO_VIEWS', response.data.views)
            commit('SET_VIDEO_VIEWS', {
                video: video,
                views: response.data.views
            })
        })
    },
    setSearchData({
        commit
    }, query) {
        return this.$axios.$get('/search?q=' + query).then((response) => {
            commit('SET_SEARCH_DATA', response.data)
        })
    }
}