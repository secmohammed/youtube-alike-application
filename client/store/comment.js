import {
    getField,
    updateField
} from 'vuex-map-fields';

export const state = () => ({
    comments: [],
    currentComments: [],
    commentForm: {}
})
export const getters = {
    getComments: (state) => (uid) => state.comments.find(comment => comment.uid == uid),
    getCurrentComments: (state) => state.currentComments,
}
export const mutations = {
    SET_CURRENT_COMMENTS(state, comments) {
        state.currentComments = comments
    },
    PUSH_COMMENTS(state, comments) {
        state.comments.push(comments)
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
        commit('PUSH_COMMENTS', response.data)
        return response.data
    }
}