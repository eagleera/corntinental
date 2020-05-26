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
        name: 'Game',
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
    if (User.loggedIn() && to.name === 'Home') next({ name: 'AuthHome' })
    if (!User.loggedIn() && to.name === 'AuthHome') next({ name: 'Home' })
    if(User.loggedIn() && to.query.user && to.name == 'Game') return next();
    if (!localStorage.getItem('guest_id') && to.name === 'Game') next({ name: 'Home' })
    if (localStorage.getItem('guest_id') && to.name === 'Home') next({ name: 'Game', params: { id: localStorage.getItem('game_id')}})
    if (localStorage.getItem('guest_id') && to.name === 'AuthHome') next({ name: 'Game', params: { id: localStorage.getItem('game_id')}})
    else next()
})

export default router