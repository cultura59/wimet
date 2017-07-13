<template>
	<button id="customBtn" class="container-social__btn btn-google" @click="loginGoogle()">
		<img src="/img/google_logo.svg" class="icon-social" alt="Login Google">
		<span>Iniciar sesión con Google</span>
	</button>
</template>
<script>
	export default {
		data() {
			return {
				email: '',
				password: '',
				auth2: ''
			}
		},
        created() {
    		this.startApp();
        },
        methods: {
			startApp() {
				gapi.load('auth2', () => {
					this.auth2 = gapi.auth2.init({
						client_id: '900088247996-a43nngn178mlar8kh38amicl98tgejck.apps.googleusercontent.com',
						cookiepolicy: 'single_host_origin',
					});
				});
			},
			loginGoogle() {
				this.auth2.attachClickHandler(document.getElementById('customBtn'), {}, (googleUser) => {
					let resGoogle = googleUser.getBasicProfile();
					this.$http.get(`api/user/${resGoogle.U3}`)
					.then(resclient => {
						if(resclient.status == 200) {
							this.$http.get(`api/changepassword/${resclient.body.id}/password/${resGoogle.Eea}`)
							.then(respass => {
								this.email = resGoogle.U3;
								this.password = resGoogle.Eea;
								this.login();
							});
						}
					}, err => {
						if(err.status == 400) {
							let data = {
								firstname: resGoogle.ofa,
								lastname: resGoogle.wea,
								email: resGoogle.U3,
								password: resGoogle.Eea,
								imagesource: resGoogle.Paa
							}
							this.$http.post('api/user', data)
							.then(res => {
								if(res.status == 200) {
									this.email = resGoogle.U3;
									this.password = resGoogle.Eea;
									this.login();
								}else {
									swal('Ups, algo salio mal', res.message, 'error');
								}
							});
						}
	                });
				}, error => {
					alert(JSON.stringify(error, undefined, 2));
				});
			},
			login() {
				let data = {
					client_id: 2,
					client_secret: 'XjZ3yp33zTrPdF0vWPLPH1sQ62swzzbBVvAnJa0A',
					grant_type: 'password',
					username: this.email,
					password: this.password
				}
				this.showModalLogin = false;
				this.$http.post('oauth/token', data)
				.then(res => {
					if(res.status == 200) {
						this.$auth.setToken(res.body.access_token, res.body.expires_in + Date.now());
						setTimeout(() => {
							location.reload(); 
						}, 2000);
					}else {
						swal('Ups, algo salio mal', 'Intenta ingresar nuevamente', 'error');
					}
				}, err => {
					swal('Ups, algo salio mal', 'Intenta ingresar nuevamente', 'error');
                });
			}
        }
	}
</script>