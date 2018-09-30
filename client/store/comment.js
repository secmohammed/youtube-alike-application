import {
    getField,
    updateField
} from 'vuex-map-fields';
import Vue from 'vue'
export const state = () => ({
    comments: {},
    currentComments: [],
    commentForm: {}
})
export const getters = {
    getComments: (state) => (uid) => state.comments[uid],
    getCurrentComments: (state) => state.currentComments,
}
export const mutations = {
    SET_CURRENT_COMMENTS(state, comments) {
        state.currentComments = comments
    },
    PUSH_COMMENTS(state, payload) {
        let uid = payload.uid
        state.comments[uid] = payload.comments
    }
}
export const actions = {
    async setCurrentComments({
        commit,
        getters
    }, uid) {
        let comments = getters.getComments(uid)
        if (comments) {
            commit('SET_CURRENT_COMMENTS', comments)
            return comments
        }
        let response = await this.$axios.$get(`/videos/${uid}/comments`)
        commit('SET_CURRENT_COMMENTS', response.data)
        commit('PUSH_COMMENTS', {
            uid: uid,
            comments: response.data
        })
        return response.data
    }
}