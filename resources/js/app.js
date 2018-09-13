
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Vue.component('example-component', require('./components/ExampleComponent.vue'))
Vue.component('home-page', require('./components/HomePage.vue'))
Vue.component('card-intro', require('./components/CardIntro.vue'))
Vue.component('card-forum', require('./components/CardForum.vue'))
Vue.component('card-user', require('./components/CardUser.vue'))
const app = new Vue({
    el: '#app'
});
