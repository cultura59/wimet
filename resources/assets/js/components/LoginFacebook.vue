<template>
	<div>
		<button v-show="showBtnLoginFacebook" class="container-social__btn btn-facebook" @click="myFacebookLogin()">
		<img src="/img/facebook_logo.svg" class="icon-facebook" alt="Login Google">
			<span>Iniciar sesión con Facebook</span>
		</button>
		<button v-show="!showBtnLoginFacebook" class="container-social__btn btn-google">
			<img src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-pig_oxestq.svg" alt="Cargando ..." height="50px" />
		</button>
	</div>
</template>
<script>
	import swal from 'sweetalert';
	export default {
	    props: [
	        'urlredirect'
		],
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
							if(this.urlredirect == 1) {
							    this.getUserAuthenticated();
							}else {
                                location.reload();
                            }
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
			},
            getUserAuthenticated() {
                let vm = this;
                if(this.$auth.isAuthenticated()) {
                    if (localStorage.getItem("user") !== null){
                        this.user = this.$auth.getUser();
                    } else {
                        vm.$http.get('api/usersession', {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem('token')}`
                            }
                        })
						.then(res => {
							this.$auth.setUser(res.body);
							this.user = this.$auth.getUser();
							location.href = `/publicar/user/${res.body.id}/primer-paso`;
						});
                    }
                }
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