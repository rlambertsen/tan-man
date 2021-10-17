export default {
    namespaced: true,
    state: {
        imageObject: null,
        nearImages: null,
    },
    actions: {
        async getSingleImage({commit}, payload) {
            try{
                return await window.axios.get('/api/view-image/' + payload.id)
            }
            catch(e) {
                throw e
            }
        },
        async instantImage({commit}) {
            try{
                let results = await window.axios.get('/api/random')
                commit('SINGLE_IMAGE', results.data[0])
                return results
            }
            catch(e) {
                throw e
            }
        },
        async getNearImages({commit}, payload) {
            try{
                let results = await window.axios.get('/api/get_near_images/'+payload)
                commit('NEAR_IMAGES', results.data)
                return results
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
        NEAR_IMAGES(state, payload) {
            state.nearImages = payload
        },
    }
}
