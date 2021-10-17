import Vue from 'vue'
import Vuex from 'vuex'

import singleImage from './store/single-image'
import search from './store/search'
Vue.use(Vuex)



const store = new Vuex.Store({
    modules: {
        singleImage: singleImage,
        search: search,
    }
})

export default store
