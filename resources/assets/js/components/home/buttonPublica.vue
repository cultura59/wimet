<template>
	<div>
		<button :class="typeBtn" @click="publicaUrl()">¡COMIENZA AHORA!</button>
	</div>
</template>
<script>
	import loginFacebook from '../loginFacebook.vue';
	import swal from 'sweetalert';

	export default {
		props: [
			'typeBtn'
		],
		components: {
			'login-facebook': loginFacebook
		},
		data() {
			return {
				email: '',
				password: '',
				imagesource: '',
				showModalLogin: false,
				showModalRegistro: false,
				authenticated: this.$auth.isAuthenticated(),
				user: {},
				msgError: '',
				teminos: true
			}
		},
		mounted() {
            this.getUserAuthenticated();
        },
		methods: {
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
			},
			reloadPage(url, event) {
				event.preventDefault();
				location.href = url;
			},
			publicaUrl() {
				if(this.$auth.isAuthenticated()) {
                    this.$store.commit('setEspacio', {});
                    location.href = `/publica/espacio`;
				}else {
					this.$root.showModalRegistro = true;
				}
			}
		}
	}
</script>
<style lang="sass">
	.login-modal {
	    position: fixed;
	    z-index: 1;
	    left: 0;
	    top: 0;
	    width: 100%;
	    height: 100%;
	    background-color: rgba(0, 0, 0, 0.4);
	    &__content {
		    width: 450px;
		    padding: 5px 20px 10px 20px;
		    margin: 2.5% auto;
		    border-radius: 2px;
		    border: 1px solid #888;
			background-color: #fefefe;
		    font-weight: 400;
		    position: relative;
		    h3 {
				opacity: 0.87;
				font-size: 18px;
				font-weight: 500;
				letter-spacing: -0.1px;
				text-align: center;
				color: #4a4a4a;
		    }
		    .login-modal-title {
		    	display: flex;
		    	justify-content: center;
		    	align-items: center;
		    	padding: 1em;
				font-size: 13px;
				font-weight: 500;
				letter-spacing: -0.2px;
				text-align: center;
				color: #888b8d;
		    }
		    .close-modal {
				color: #888b8d;
				font-size: 28px;
				font-weight: bold;
				cursor: pointer;
				position: absolute;
				top: 0;
				right: .5em;
			}
			.container-social {
			    padding-bottom: 1em;
			    &__btn {
				    border: none;
				    width: 100%;
				    height: 50px;
				    border-radius: 2px;
				    margin-top: 5px;
				}
			    .btn-linkedin {
			    	background-color: #007ab6;
			    	color: #fff;
			    	&:hover {
			    		background-color: rgba(0, 122, 182, 0.80);
			    	}
			    }
			    .btn-google {
			    	background-color: #fff;
			    	border: solid 1px #979797;
			    	color: #979797;
			    	&:hover {
			    		color: #000;
			    	}
			    }
		    	.icon-social {
					color: #fff;
					margin-right: 1.5em;
					width: 15px;
		    	}
			}
			.container-login {
			    display: flex;
			    flex-direction: column;
			    input {
			    	border-radius: 2px;
				    border: solid 1px #979797;
				    padding: 1em;
				    width: 100%;
				    height: 50px;
				    margin-bottom: 5px;
				    color: #979797;
			    }
			    &__login {
				    width: 100%;
				    height: 50px;
				    border-radius: 2px;
				    background-color: #FC5289;
				    border: none;
				    color: #fff;
				    &:hover {
				    	background-color: rgba(234, 81, 109, 0.80);
				    }
				}
				.container-terminos {
				    display: flex;
				    justify-content: center;
				    margin-top: 1em;
				    &__texto {
					    font-size: 13px;
					    font-weight: 500;
					    letter-spacing: -0.2px;
					    text-align: center;
					    color: #888b8d;
					    cursor: pointer;
					    :before {
					    	margin-right: 1em;
					    }
					}
				}
			}
			.container-footer {
			    display: flex;
			    justify-content: center;
			    align-items: center;
			    padding: 1em 0;
			    &__pregunta {
					font-size: 14px;
					font-weight: 500;
					letter-spacing: -0.2px;
					color: #424242;
				}
				&__registro {
					color: #e2385a;
					margin-left: 1em;
					cursor: pointer;
				}
			}
	    }
	    @media only screen and (max-width: 768px) {
	    	&__content {
			    width: 100%;
			    padding: 5px 20px 10px 20px;
			    margin: 2.5% auto;
			    border-radius: 2px;
			    border: 1px solid #888;
				background-color: #fefefe;
			    font-weight: 400;
			    position: relative;
	    	}
	    }
	}
</style>