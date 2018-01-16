import Vue from 'vue'
import VueResource from 'vue-resource'

Vue.component('dasboard-index', require('./components/dashboard/Index.vue'));

import Vuex from 'vuex'
import VueRouter from 'vue-router';
import {router} from './components/dashboard/routes';
import {store} from './components/home/Services';
import Auth from './packages/auth/Auth.js';

Vue.use(VueResource);
Vue.use(Vuex);
Vue.use(VueRouter);
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
    Vue.http.options.root = `${protocol}://wimet.co`;
}

Vue.http.headers.common['Authorization'] = `Bearer ${Vue.auth.getToken()}`;

const app = new Vue({
    el: '#dashboard',
    router,
    store
});

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
Vue.prototype.$mercadopago = Mercadopago;