<template>
	<div>
		<button v-show="showBtnLoginGoogle" id="customBtn" class="container-social__btn btn-google" @click="loginGoogle()">
			<img src="/img/google_logo.svg" class="icon-social" alt="Login Google">
			<span>Iniciar sesión con Google</span>
		</button>
		<button v-show="!showBtnLoginGoogle" class="container-social__btn btn-google">
			<img src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-pig_oxestq.svg" alt="Cargando ..." height="50px" />
		</button>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				email: '',
				password: '',
				auth2: '',
				showBtnLoginGoogle: true
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
                            this.showBtnLoginGoogle = false;
							this.$http.get(`api/changepassword/${resclient.body.id}/password/${resGoogle.Eea}`)
							.then(respass => {
								this.email = resGoogle.U3;
								this.password = resGoogle.Eea;
								this.login();
							});
						}
					}, err => {
						if(err.status == 400) {
						    this.showBtnLoginGoogle = false;
							let data = {
								firstname: resGoogle.ofa,
								lastname: resGoogle.wea,
								email: resGoogle.U3,
								password: resGoogle.Eea,
								imagesource: resGoogle.Paa,
								status: true
							}
							this.$http.post('api/user', data)
							.then(res => {
								if(res.status == 200) {
									this.email = resGoogle.U3;
									this.password = resGoogle.Eea;
									this.login();
								}else {
									this.showBtnLoginGoogle = true;
									swal('Ups, algo salio mal', res.message, 'error');
								}
							});
						}
	                });
				}, error => {
					console.log(JSON.stringify(error, undefined, 2));
				});
			},
			login() {
                this.showBtnLoginGoogle = false;
				let data = {
					client_id: 2,
					client_secret: 'XjZ3yp33zTrPdF0vWPLPH1sQ62swzzbBVvAnJa0A',
					grant_type: 'password',
					username: this.email,
					password: this.password
				}
				this.$http.post('oauth/token', data)
				.then(res => {
					if(res.status == 200) {
						this.$auth.setToken(res.body.access_token, res.body.expires_in + Date.now());
						setTimeout(() => {
							location.reload(); 
						}, 1000);
					}else {
						this.showBtnLoginGoogle = true;
						swal('Ups, algo salio mal', 'Intenta ingresar nuevamente', 'error');
					}
				}, err => {
					this.showBtnLoginGoogle = true;
					swal('Ups, algo salio mal', 'Intenta ingresar nuevamente', 'error');
                });
			}
        }
	}
</script>