/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.component('home-search', require('./components/home/HomeSearch.vue'));
Vue.component('home-espacio', require('./components/home/Espacio.vue'));
Vue.component('title-home', require('./components/home/titleHome.vue'));
Vue.component('wimet-login', require('./components/WimetLogin.vue'));
Vue.component('button-publica', require('./components/home/buttonPublica.vue'));
Vue.component('search-home', require('./components/SearchHome.vue'));
Vue.component('header-espacio', require('./components/home/HeaderEspacio.vue'));
Vue.component('confirm-reserva', require('./components/ConfirmReserva.vue'));
Vue.component('espacio-search', require('./components/EspacioSearch.vue'));
Vue.component('list-images', require('./components/ListImages.vue'));
Vue.component('aside-reserva', require('./components/AsideReserva.vue'));
Vue.component('consulta-reserva', require('./components/ConsultaReserva.vue'));

Vue.component('navbar-primero', require('./components/publica/primerParte/navbarPrimera.vue'));
Vue.component('navbar-segundo', require('./components/publica/segundaParte/navbarSegunda.vue'));
Vue.component('navbar-tercero', require('./components/publica/terceraParte/navbarTercera.vue'));
Vue.component('publica-index', require('./components/publica/primerParte/index.vue'));
Vue.component('publica-image', require('./components/publica/segundaParte/image.vue'));
Vue.component('publica-title', require('./components/publica/segundaParte/title.vue'));
Vue.component('publica-price', require('./components/publica/segundaParte/price.vue'));
Vue.component('publica-disponibilidad', require('./components/publica/terceraParte/Disponibilidad.vue'));

Vue.component('dasboard-eventos', require('./components/dashboard/Eventos.vue'));
Vue.component('dasboard-propuestas', require('./components/dashboard/Propuestas.vue'));
Vue.component('dasboard-evento', require('./components/dashboard/Evento.vue'));
Vue.component('dasboard-mensajes', require('./components/dashboard/Mensajes.vue'));
Vue.component('dasboard-chats', require('./components/dashboard/Chat.vue'));
Vue.component('dasboard-nueva-propuesta', require('./components/dashboard/NuevaPropuesta.vue'));
Vue.component('dasboard-confirmar', require('./components/dashboard/Confirmar.vue'));

import {store} from './components/home/Services';
import Auth from './packages/auth/Auth.js';
Vue.use(Auth);

window.fbAsyncInit = () => {
	FB.init({
		appId      : '1951432991743202',
		xfbml      : true,
		version    : 'v2.9'
	});
	FB.AppEvents.logPageView();
};

(function(d, s, id){
	let js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/es_LA/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

const ip = location.host;
let protocol = "http";

if (window.location.protocol == "https") {
    protocol = "https";
}

if(ip !== "") {
    Vue.http.options.root = `${protocol}://${ip}`;
} else {
    Vue.http.options.root = `${protocol}://localhost:8000`;
}

Vue.http.headers.common['Authorization'] = `Bearer ${Vue.auth.getToken()}`;

import moment from 'moment';
import toastr from 'toastr';
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "4000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
Vue.prototype.$moment = moment;
Vue.prototype.$toastr = toastr;

const app = new Vue({
    el: '#home-espacio',
    store
});