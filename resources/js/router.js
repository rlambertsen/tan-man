import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import imageGrid from './views/image-grid.vue'
import upload from './views/upload'
import imageView from './views/view-image'
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: imageGrid
        },
        {
            path: '/upload',
            name: 'upload',
            component: upload
        },
        {
            path: '/view-image',
            name: 'view-image',
            component: imageView
        },
    ],
});

export default router
