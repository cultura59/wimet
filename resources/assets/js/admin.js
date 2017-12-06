require('./bootstrap');
import Auth from './packages/auth/Auth.js';
import VueRouter from 'vue-router';
import {router} from './components/admin/routes';

Vue.use(Auth);
Vue.use(VueRouter);

const ip = location.host;
Vue.http.options.root = `http://${ip}`;
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