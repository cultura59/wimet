<template>
	<div>
		<button v-if="showBtnLoginGoogle" id="customBtn" class="container-social__btn btn-google" @click="loginGoogle()">
			<img src="/img/google_logo.svg" class="icon-social" alt="Login Google">
			<span>Iniciar sesión con Google</span>
		</button>
		<button v-if="!showBtnLoginGoogle" class="container-social__btn btn-google">
			<img src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-pig_oxestq.svg" alt="Cargando ..." height="50px" />
		</button>
	</div>
</template>
<script>
    import {registerLogin} from '../mixins/registerLogin';
	export default {
        mixins: [registerLogin],
		data() {
			return {
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
						this.firstname = resGoogle.ofa;
						this.lastname = resGoogle.wea;
						this.email = resGoogle.U3;
						this.password = resGoogle.Eea;
						this.imagesource = resGoogle.Paa;
						this.status = true;
						this.registrar();
						}
	                });
				}, error => {
					console.log(JSON.stringify(error, undefined, 2));
				});
			}
        }
	}
</script>