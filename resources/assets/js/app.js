
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.component('search-home', require('./components/SearchHome.vue'));
Vue.component('search-filter', require('./components/SearchFilter.vue'));
Vue.component('header-espacio', require('./components/HeaderEspacio.vue'));
Vue.component('aside-reserva', require('./components/AsideReserva.vue'));
Vue.component('confirm-reserva', require('./components/ConfirmReserva.vue'));
Vue.component('espacio-search', require('./components/EspacioSearch.vue'));

const app = new Vue({
    el: '#home-espacio'
});