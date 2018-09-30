
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// //CKEDITOR
// $(document).ready(function () {
//     CKEDITOR.replace( 'description_short' );
//     CKEDITOR.replace( 'description' );
// });

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('ex-comp', require('./components/ExampleComponent.vue'));
Vue.component('new-comp', require('./components/NewComponent.vue'));
Vue.component('ajax-comp', require('./components/AjaxComponent.vue'));
Vue.component('chartline-comp', require('./components/ChartlineComponent.vue'));
Vue.component('chartpie-comp', require('./components/ChartpieComponent.vue'));
Vue.component('socket-comp', require('./components/SocketComponent.vue'));
Vue.component('socket-chat-component', require('./components/SocketChatComponent.vue'));
Vue.component('socket-privat-chat-component', require('./components/SocketPrivatChatComponent.vue'));
Vue.component('chat', require('./components/ChatComponent.vue'));
Vue.component('private-chat', require('./components/PrivateChatComponent.vue'));

const app = new Vue({
    el: '#app'
});
