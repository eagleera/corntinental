import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../components/Home'
import Room from '../components/Room'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/juego/:id',
        component: Room
    }
]

const router = new VueRouter({
    routes,
    mode : 'history'
})

export default router