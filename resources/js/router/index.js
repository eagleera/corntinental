import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../components/Home'
import Room from '../components/Room'
import Login from '../components/Auth/Login'
import AuthHome from '../components/AuthHome'
import User from '../helpers/User'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/juego/:id',
        component: Room
    },
    {
        path: '/home',
        name: 'AuthHome',
        component: AuthHome
    }
]

const router = new VueRouter({
    routes,
    mode : 'history'
})
router.beforeEach((to, from, next) => {
    if ( User.loggedIn() && to.name === 'Home') next({ name: 'AuthHome' })
    if (!User.loggedIn() && to.name === 'AuthHome') next({ name: 'Home' })
    else next()
})

export default router