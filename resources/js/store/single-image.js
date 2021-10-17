export default {
    namespaced: true,
    state: {
        imageObject: null,
    },
    actions: {
        async getSingleImage({commit}, payload) {
            try{
                return await window.axios.get('/view-image/' + payload.id)
            }
            catch(e) {
                throw e
            }
        },
        holdImage({commit}, payload) {
            commit('SINGLE_IMAGE', payload)
        },
    },
    mutations: {
        SINGLE_IMAGE(state, payload) {
            state.imageObject = payload
        },
    }
}
