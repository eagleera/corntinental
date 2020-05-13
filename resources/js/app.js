/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import BootstrapVue from 'bootstrap-vue'
window.Vue = require('vue');
import Vue from 'vue'
import Room from './helpers/Room'
window.Room = Room;

Vue.use(BootstrapVue)

Vue.component('AppHome', require('./components/AppHome.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.EventBus = new Vue();
import router from './router/index.js'

const app = new Vue({
    el: '#app',
    router
});
