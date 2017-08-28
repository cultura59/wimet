<template>
	<div>
		<button v-show="showBtnLoginFacebook" class="container-social__btn btn-facebook" @click="myFacebookLogin()">
		<img src="/img/facebook_logo.svg" class="icon-facebook" alt="Login Google">
			<span>Iniciar sesión con Facebook</span>
		</button>
		<button v-show="!showBtnLoginFacebook" class="container-social__btn btn-google">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
			<path opacity="0.2" fill="#FC5289" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
			s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
			c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
			<path fill="#FC5289" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
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
	import swal from 'sweetalert';
	export default {
		data() {
			return {
				email: '',
				password: '',
                showBtnLoginFacebook: true
			}
		},
		methods: {
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
			},
			myFacebookLogin() {
			    this.showBtnLoginFacebook = false;
				FB.login( (res) => {
					if (res.authResponse) {
						FB.api('/me', {fields: 'first_name,last_name,email,picture.type(large)'}, (res) => {
							this.$http.get(`api/user/${res.email}`)
							.then(resclient => {
								if(resclient.status == 200) {
									this.$http.get(`api/changepassword/${resclient.body.id}/password/${res.id}`)
									.then(respass => {
										this.email = res.email;
										this.password = res.id;
										this.login();
									});
								}
							}, err => {
								if(err.status == 400) {
                                    this.showBtnLoginFacebook = true;
									let data = {
										firstname: res.first_name,
										lastname: res.last_name,
										email: res.email,
										password: res.id,
										imagesource: res.picture.data.url
									}
									this.$http.post('api/user', data)
									.then(response => {
										if(response.status == 200) {
											this.email = res.email;
											this.password = res.id;
											this.login();
										}else {
                                            this.showBtnLoginFacebook = false;
											swal('Ups, algo salio mal', res.message, 'error');
										}
									});
								}
			                });
						});
					} else {
                        this.showBtnLoginFacebook = false;
						console.log('User cancelled login or did not fully authorize.');
					}
				}, {scope: 'email,user_likes'});
			}
		}
	}
</script>
<style lang="sass">
	.container-social {
	    padding-bottom: 1em;
	    &__btn {
		    border: none;
		    width: 100%;
		    height: 50px;
		    border-radius: 2px;
		    margin-top: 5px;
		}
	    .btn-facebook {
	    	background-color: #3b5998;
	    	color: #fff;
	    	&:hover {
	    		background-color: rgba(59, 89, 152, 0.80);
	    	}
	    	.icon-facebook {
				color: #fff;
				margin-right: 1em;
				width: 8px;
	    	}
	    }
	}
</style>