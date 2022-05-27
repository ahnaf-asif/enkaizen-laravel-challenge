require('./bootstrap');
window.Vue = require('vue').default;
import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);

Vue.component('Navbar', require('./components/Navbar.vue').default);
Vue.component('notification', require('./components/Notification.vue').default);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});
