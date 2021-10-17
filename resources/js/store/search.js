export default {
    namespaced: true,
    state: {
        results: null,
    },
    actions: {
        async textSearch({commit}, payload) {
            try{
                let results = await window.axios.post('/api/search', {search: payload})
                commit('SEARCH_RETURN', results.data)
                return results
            }
            catch(e) {
                throw e
            }
        },
    },
    mutations: {
        SEARCH_RETURN(state, payload) {
            state.results = payload
        }
    }
}
