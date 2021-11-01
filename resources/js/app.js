require('./bootstrap');

import Vue from "vue"
import VueRouter from "vue-router"

import App from "./components/App"
import Home from "./components/Home"
import About from "./components/About"

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        }, {
            path: '/about',
            name: 'about',
            component: About
        },
    ]
})

Vue.use(VueRouter)

const app = new Vue({
    el: '#app',
    components: {App},
    router,
});
