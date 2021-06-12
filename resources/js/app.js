import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
Vue.use(VueRouter)
window.axios = axios
import App from './App.vue'
import Welcome from './views/welcome.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Welcome
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
