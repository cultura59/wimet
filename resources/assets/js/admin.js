import Vue from 'vue';
import Auth from './packages/auth/Auth.js';
import VueRouter from 'vue-router';
import {router} from './components/admin/routes';

Vue.use(Auth);
Vue.use(VueRouter);

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

const admin = new Vue({
	data: {
		logued: false,
		u: '',
		p: ''
	},
	methods: {
		l()	{
			if (this.u == "serafin" && this.p == "neverpony") {
				this.logued = true;
			}else {
				console.log("Entro por no");
			}
		}
	},
    router
}).$mount('#adminApp');

import moment from 'moment';

Vue.prototype.$moment = moment;