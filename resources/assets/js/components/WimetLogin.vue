<template>
	<div class="actions">
		<ul>
			<li>
	            <a href="#" @click="publicaUrl($event)" class="wt-btn-transparent">
	                PUBLICA TU ESPACIO
	            </a>
	        </li>
	        <li>
				<button v-if="!authenticated" :class="typeLogin" @click="openModalLogin()">Ingresar</button>
				<template v-if="authenticated">
					<a href="#" id="menu-user" :class="userloged">{{ user.firstname }}</a>
				    <ul class="menue-list">
				        <li class="menue-list__item">
				            <a href="#" @click="reloadPage(`/dashboard/user/${user.id}/datos`, $event)" style="color: #333;">Editar perfil</a>
				        </li>
				        <li class="menue-list__item">
				            <a href="#" @click="reloadPage(`/dashboard/user/${user.id}/misespacios`, $event)" style="color: #333;">Mi cuenta</a>
				        </li>
				        <li class="menue-list__item active">
				            <a href="#" @click="reloadPage(`/publica`, $event)" style="color: #333;">PUBLICAR TU ESPACIO</a>
				        </li>
				        <li class="menue-list__last-item">
				            <a href="#" @click="logout($event)" style="color: #333;">Salir</a>
				        </li>
				    </ul>
			    </template>
			</li>
		</ul>
		<template v-if="showModalLogin">
			<div class="login-modal" @click="closeModalEvent($event)">
				<div class="login-modal__content">
					<h3>¡Te estábamos esperando!</h3>
					<div v-if="msgError != ''" class="alert alert-danger" role="alert">{{msgError}}</div>
					<span class="close-modal" @click="closeModals()">×</span>
					<div class="container-social">
						<login-facebook></login-facebook>
						<login-google></login-google>
					</div>
					<div class="login-modal-title">
						<span class="text-center">Inicia sesión con tu email</span>
					</div>
					<div class="container-login">
						<input type="email" class="container-login__email" placeholder="Email" v-model="email" />
						<input type="password" class="container-login__email" placeholder="Contraseña" v-model="password" @keyup.enter="login()"/>
						<button v-if="showBtnLogin" class="container-login__login" @click="login()">Iniciar sesión</button>
						<button v-if="!showBtnLogin" class="container-login__login" @click="login()">
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
					<div class="container-footer">
						<span class="container-footer__pregunta">¿No tienes cuenta?</span>
						<span class="container-footer__registro" @click="openModalRegistro()">Registrate</span>
					</div>
				</div>
			</div>
		</template>
		<template v-if="showModalRegistro">
			<div class="login-modal" @click="closeModalEvent($event)">
				<div class="login-modal__content">
					<h3>¡Crea tu cuenta y comienza a explorar!</h3>
					<div v-if="msgError != ''" class="alert alert-danger" role="alert">{{msgError}}</div>
					<span class="close-modal" @click="closeModals()">×</span>
					<div class="container-social">
						<login-facebook></login-facebook>
						<login-google></login-google>
					</div>
					<div class="login-modal-title">
						<span class="text-center">Regístrate con tu email</span>
					</div>
					<div class="container-login">
						<input type="text" class="container-login__email" placeholder="Nombre" v-model="firstname" />
						<input type="text" class="container-login__email" placeholder="Apellido" v-model="lastname" />
						<input type="email" class="container-login__email" placeholder="Email" v-model="email" />
						<input type="password" class="container-login__email" placeholder="Contraseña" v-model="password" />
						<button class="container-login__login" @click="registrar()">Regístrate</button>
						<div class="container-terminos">
							<input type="checkbox" id="terminos" v-model="terminos" style="display:none">
							<label for="terminos" class="container-terminos__texto">Acepto los términos y condiciones.</label>
						</div>
					</div>
					<div class="container-footer">
						<span class="container-footer__pregunta">¿Ya tienes cuenta?</span>
						<span class="container-footer__registro" @click="openModalLogin()">Inicia sesión</span>
					</div>
				</div>
			</div>
		</template>
	</div>
</template>
<script>
	import loginFacebook from './loginFacebook.vue';
	import loginGoogle from './loginGoogle.vue';
	import swal from 'sweetalert';

	export default {
		props: [
			'typeLogin',
			'typeSvg',
			'userloged'
		],
		components: {
			'login-facebook': loginFacebook,
			'login-google': loginGoogle
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
				terminos: true,
				showBtnLogin: true
			}
		},
		mounted() {
            this.getUserAuthenticated();
        },
		methods: {
			openModalLogin() {
				this.showModalRegistro = false;
				this.showModalLogin = true;
			},
			openModalRegistro() {
				this.showModalLogin = false;
				this.showModalRegistro = true;
			},
			closeModals() {
				this.showModalLogin = false;
				this.showModalRegistro = false;
			},
			closeModalEvent(event) {
				var specifiedElement = document.querySelector(".login-modal__content");
				var isClickInside = specifiedElement.contains(event.target);
				
				if (!isClickInside) {
					this.showModalLogin = false;
					this.showModalRegistro = false;
				}
			},
			registrar() {
				if(!this.terminos) {
					this.msgError = 'Debe aceptar los terminos y condiciones';
					setInterval(() => {
						this.msgError = '';
					}, 3000);
					return;
				}
				let data = {
					firstname: this.firstname,
					lastname: this.lastname,
					email: this.email,
					password: this.password,
					imagesource: this.imagesource
				}
				this.$http.post('api/user', data)
				.then(res => {
					if(res.status == 200) {
						this.login();
						this.showModalRegistro = false;
					}else {
						swal('Ups, algo salio mal', res.message, 'error');
					}
				});
			},
			login() {
				this.showBtnLogin = false;
				let data = {
					client_id: 2,
					client_secret: 'XjZ3yp33zTrPdF0vWPLPH1sQ62swzzbBVvAnJa0A',
					grant_type: 'password',
					username: this.email,
					password: this.password
				}
				//this.showModalLogin = false;
				this.$http.post('oauth/token', data)
				.then(res => {
					if(res.status == 200) {
						this.$auth.setToken(res.body.access_token, res.body.expires_in + Date.now());
						this.showModalLogin = false;
						setTimeout(() => {
							location.reload(); 
						}, 1000);
					}
				}, err => {
					this.showBtnLogin = true;
					this.msgError = `El email ${this.email} no existe, registralo :)`;
					setInterval(() => {
						this.msgError = '';
					}, 3000);
				});
			},
			logout(event) {
				event.preventDefault();
				this.$auth.destroyToken();
				gapi.auth.signOut();
				FB.getLoginStatus((resStatusFb) => {
					resStatusFb.status === 'connected';
					FB.logout();
				});
				window.localStorage.clear();
				location.href = '/';
			},
			getUserAuthenticated() {
				let vm = this;
				if(this.$auth.isAuthenticated()) {
					if (localStorage.getItem("user") !== null){
						this.user = this.$auth.getUser();
					} else {
						vm.$http.get('api/usersession')
						.then(res => {
							this.$auth.setUser(res.body);
							this.user = this.$auth.getUser();
						});
					}
				}
			},
			reloadPage(url, event) {
				event.preventDefault();
				location.href = url;
			},
			publicaUrl(e) {
				e.preventDefault();
				location.href = `/publica`;
			}
		}
	}
</script>
<style lang="sass">
	svg path, svg rect{fill: #fff;}
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
				font-family: Poppins;
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
		    	font-family: Roboto;
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
				    background-color: #ea516d;
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
					    font-family: Roboto;
					    font-size: 13px;
					    font-weight: 500;
					    letter-spacing: -0.2px;
					    text-align: center;
					    color: #888b8d;
					    cursor: pointer;
					}
				}
			}
			.container-footer {
			    display: flex;
			    justify-content: center;
			    align-items: center;
			    padding: 1em 0;
			    &__pregunta {
				    font-family: Roboto;
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