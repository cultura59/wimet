
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
Vue.component('wimet-login', require('./components/WimetLogin.vue'));
Vue.component('search-home', require('./components/SearchHome.vue'));
Vue.component('search-filter', require('./components/SearchFilter.vue'));
Vue.component('header-espacio', require('./components/HeaderEspacio.vue'));
Vue.component('confirm-reserva', require('./components/ConfirmReserva.vue'));
Vue.component('espacio-search', require('./components/EspacioSearch.vue'));
Vue.component('list-images', require('./components/ListImages.vue'));
Vue.component('aside-reserva', require('./components/AsideReserva.vue'));
Vue.component('aside-dashboard', require('./components/AsideDashboard.vue'));

Vue.component('index-publica', require('./components/publica/indexPublica.vue'));
Vue.component('publica-index', require('./components/publica/primerParte/index.vue'));
Vue.component('publica-title', require('./components/publica/segundaParte/title.vue'));

import Auth from './packages/auth/Auth.js';
Vue.use(Auth);

const ip = location.host;
Vue.http.options.root = `http://${ip}`;

Vue.http.headers.common['Authorization'] = `Bearer ${Vue.auth.getToken()}`;

const app = new Vue({
    el: '#home-espacio'
});