export default function(Vue) {
	let authenticatedUser = {};
	Vue.auth = {
		setToken (token, expiration) {
			localStorage.setItem('token', token);
			localStorage.setItem('exppiration', expiration);
		},
		getToken () {
			let token = localStorage.getItem('token');
			let exppiration = localStorage.getItem('exppiration');

			if(!token || !exppiration) {
				return null;
			}

			if(Date.now() > parseInt(exppiration)) {
				this.destroyToken();
				return null;
			}else {
				return token;
			}
		},
		destroyToken () {
			localStorage.removeItem('user');
			localStorage.removeItem('token');
			localStorage.removeItem('exppiration');
		},
		isAuthenticated () {
			if(this.getToken()) {
				return true;
			}else {
				return false;
			}
		},
		setUser (user) {
			let userString = JSON.stringify(user);
			let encodedString = btoa(userString);
			localStorage.setItem('user', encodedString);
		},
		getUser () {
			let decodedString = atob(localStorage.getItem('user'));
			let userJson = JSON.parse(decodedString);
			return userJson;
		}
	}
	Object.defineProperties(Vue.prototype, {
		$auth: {
			get: () => {
				return Vue.auth
			}
		}
	});
}