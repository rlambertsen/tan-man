import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
Vue.use(VueRouter)
window.axios = axios
import App from './App.vue'
import Welcome from './views/welcome.vue'
import upload from './views/upload'
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Welcome
        },
        {
            path: '/upload',
            name: 'upload',
            component: upload
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
