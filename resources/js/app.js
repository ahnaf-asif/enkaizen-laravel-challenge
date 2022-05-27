require('./bootstrap');
window.Vue = require('vue').default;
import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);


import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from "./store"

const store = new Vuex.Store(
    storeData
)

Vue.component('Navbar', require('./components/Navbar.vue').default);
Vue.component('notification', require('./components/Notification.vue').default);

const app = new Vue({
    el: '#app',
    store,
    router: new VueRouter(routes)
});
