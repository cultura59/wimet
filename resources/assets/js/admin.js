require('./bootstrap');
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const ip = location.host;
Vue.http.options.root = `http://${ip}`;

import {router} from './components/routes';
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