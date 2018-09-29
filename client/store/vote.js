import {
    getField,
    updateField
} from 'vuex-map-fields';
export const state = () => ({
    voteForm: {},
})
export const getters = {
    voteForm: (state) => state.voteForm,
    getField,

}
export const mutations = {
    SET_CURRENT_VOTE_FORM: (state, vote) => state.voteForm = {
        user_vote: vote.user_vote
    },
    updateField,

}
export const actions = {
    setVote({
        dispatch
    }, payload) {
        return dispatch('set' + payload.category + 'Vote', payload)
    },
    setVideoVote({
        dispatch
    }, payload) {
        if (payload.type) {
            return dispatch('setVideoUpVote', payload.identifier)
        }
        return dispatch('setVideoDownVote', payload.identifier)
    },
    setVideoUpVote({
        commit
    }, identifier) {
        return this.$axios.$post(`/videos/${identifier}/votes`).then(response => {
            // update vote form.
            commit('SET_CURRENT_VOTE_FORM', response.data)
                // update vote of the video.
            commit('video/SET_VIDEO_VOTES', {
                uid: identifier,
                votes: response.data
            }, {
                root: true
            })

            // update the current vote of the viewed video.
            commit('video/SET_CURRENT_VIDEO_VOTES', response.data, {
                root: true
            })
        })
    },
    setVideoDownVote({
        commit
    }, identifier) {
        return this.$axios.$delete(`/videos/${identifier}/votes`).then(response => {

            // update vote form.
            commit('SET_CURRENT_VOTE_FORM', response.data)
                // update vote of the video.
            commit('video/SET_VIDEO_VOTES', {
                uid: identifier,
                votes: response.data
            }, {
                root: true
            })

            // update the current vote of the viewed video.
            commit('video/SET_CURRENT_VIDEO_VOTES', response.data, {
                root: true
            })

        })
    }
}