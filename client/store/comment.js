import {
    getField,
    updateField
} from 'vuex-map-fields';
export const state = () => ({
    comments: {},
    currentComments: [],
    commentForm: {
        body: null,
    },
    replyForm: {
        body: null,
        reply_id: null
    }
})
export const getters = {
    getComments: (state) => (uid) => state.comments[uid],
    getCurrentComments: (state) => state.currentComments,
    getCommentForm: (state) => state.commentForm,
    getReplyForm: (state) => state.replyForm,
    getField,

}
export const mutations = {
    SET_CURRENT_COMMENTS(state, comments) {
        state.currentComments = comments
    },
    PUSH_TO_CURRENT_COMMENTS(state, comment) {
        state.currentComments.unshift(comment)
    },
    PUSH_REPLY_TO_COMMENTS(state, payload) {
        let uid = payload.uid
        let comment = state.comments[uid].find(comment => {
            return comment.id == payload.reply.reply_id
        })
        if (comment.replies) {
            comment.replies.unshift(payload.reply)
        } else {
            comment.replies = [payload.reply]
        }

    },
    CLEAR_REPLY_FORM(state) {
        state.replyForm = {
            reply_id: null,
            body: null
        }
    },
    CLEAR_COMMENT_FORM(state) {
        state.commentForm = {
            body: null
        }
    },
    PUSH_COMMENTS(state, payload) {
        let uid = payload.uid
        if (state.comments[uid]) {
            state.comments[uid].unshift(payload.comments)
        } else {
            state.comments[uid] = payload.comments
        }
    },
    UNSET_COMMENT(state, payload) {
        let uid = payload.uid
        state.comments[uid] = state.comments[uid].filter(comment => comment.id != payload.id)

    },
    UNSET_REPLY(state, payload) {
        let uid = payload.uid
        state.comments[uid] = state.comments[uid].map(comment => {
            if (comment.replies) {
                comment.replies = comment.replies.filter(reply => reply.id != payload.id)
            }
            return comment
        })
    },
    updateField,

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
    },
    createComment({
        commit,
        getters
    }, uid) {
        this.$axios.$post(`/comments/${uid}`, getters.getCommentForm).then(response => {
            commit('PUSH_TO_CURRENT_COMMENTS', response.data)
            commit('PUSH_COMMENTS', {
                uid: uid,
                comments: response.data
            })
            commit('CLEAR_COMMENT_FORM')
        })
    },
    createReply({
        commit,
        getters
    }, uid) {
        this.$axios.$post(`/comments/${uid}`, getters.getReplyForm).then(response => {
            commit('PUSH_REPLY_TO_COMMENTS', {
                uid: uid,
                reply: response.data
            })
            commit('SET_CURRENT_COMMENTS', getters.getComments(uid))
            commit('CLEAR_REPLY_FORM')
        })
    },
    deleteComment({
        commit,
        getters
    }, payload) {
        this.$axios.$delete(`/videos/${payload.uid}/comments/${payload.id}`).then(() => {
            commit('UNSET_COMMENT', payload)
            commit('SET_CURRENT_COMMENTS', getters.getComments(payload.uid))
        })
    },
    deleteReply({
        commit,
        getters
    }, payload) {
        this.$axios.$delete(`/videos/${payload.uid}/comments/${payload.id}`).then(() => {
            commit('UNSET_REPLY', payload)
            commit('SET_CURRENT_COMMENTS', getters.getComments(payload.uid))
        })
    }

}