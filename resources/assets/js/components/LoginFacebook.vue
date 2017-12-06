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
    import {registerLogin} from '../mixins/registerLogin';
	import swal from 'sweetalert';
	export default {
        mixins: [registerLogin],
	    props: [
	        'urlredirect'
		],
		data() {
			return {
                showBtnLoginFacebook: true
			}
		},
		methods: {
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
									this.firstname = res.first_name;
									this.lastname = res.last_name;
									this.email = res.email;
									this.password = res.id;
									this.imagesource =  res.picture.data.url;
									this.status = true;
									this.terminos = true;
									this.registrar();
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