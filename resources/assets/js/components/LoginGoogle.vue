<template>
	<div>
		<button v-show="showBtnLoginGoogleGoogle" id="customBtn" class="container-social__btn btn-google" @click="loginGoogle()">
			<img src="/img/google_logo.svg" class="icon-social" alt="Login Google">
			<span>Iniciar sesión con Google</span>
		</button>
		<button v-show="!showBtnLoginGoogleGoogle" class="container-social__btn btn-google">
			<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
				<path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
				s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
				c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
				<path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
				C22.32,8.481,24.301,9.057,26.013,10.047z">
				<animateTransform attributeType="xml"
				attributeName="transform"
				type="rotate"
				from="0 20 20"
				to="360 20 20"
				dur="0.5s"
				repeatCount="indefinite"/>
				</path>
			</svg>
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
				showBtnLoginGoogleGoogle: true
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
				this.showBtnLoginGoogle = false;
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
									this.showBtnLoginGoogle = true;
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