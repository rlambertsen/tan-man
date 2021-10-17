import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import store from './store'
import router from './router'
import App from './App.vue'

import gifShot from 'gifshot'
Vue.prototype.$gifShot = gifShot
Vue.use(VueRouter)
// assign axios to global property
window.axios = axios




const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
});
