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
				<div v-if="authenticated">
					<a href="#" id="menu-user" :class="userloged">{{ user.firstname }}</a>
				    <ul class="menue-list">
				        <li class="menue-list__item">
				            <a href="#" @click="reloadPage(`/dashboard/user/${user.id}/datos`, $event)" style="color: #333;">Editar perfil</a>
				        </li>
				        <li class="menue-list__item">
				            <a href="#" @click="reloadPage(`/dashboard/user/${user.id}/misespacios`, $event)" style="color: #333;">Mi cuenta</a>
				        </li>
				        <li class="menue-list__item active">
				            <a href="#" @click="reloadPage(`/publicar/primer-paso`, $event)" style="color: #333;">PUBLICAR TU ESPACIO</a>
				        </li>
				        <li class="menue-list__last-item">
				            <a href="#" @click="logout($event)" style="color: #333;">Salir</a>
				        </li>
				    </ul>
			    </div>
			</li>
		</ul>
		<div v-if="showModalLogin" class="login-modal">
			<div class="login-modal__content">
				<h3>¡Te estábamos esperando!</h3>
				<div v-if="msgError != ''" class="alert alert-danger" role="alert">{{msgError}}</div>
				<span class="close-modal" @click="closeModals()">×</span>
				<div class="container-social">
					<login-facebook></login-facebook>
					<button class="container-social__btn btn-google">Iniciar sesión con Google</button>
				</div>
				<div class="login-modal-title">
					<span class="text-center">Inicia sesión con tu email</span>
				</div>
				<div class="container-login">
					<input type="email" class="container-login__email" placeholder="Email" v-model="email" />
					<input type="password" class="container-login__email" placeholder="Contraseña" v-model="password" />
					<button class="container-login__login" @click="login()">Iniciar sesión</button>
				</div>
				<div class="container-footer">
					<span class="container-footer__pregunta">¿No tienes cuenta?</span>
					<span class="container-footer__registro" @click="openModalRegistro()">Registrate</span>
				</div>
			</div>
		</div>
		<div v-if="showModalRegistro" class="login-modal">
			<div class="login-modal__content">
				<h3>¡Crea tu cuenta y comienza a explorar!</h3>
				<span class="close-modal" @click="closeModals()">×</span>
				<div class="container-social">
					<login-facebook></login-facebook>
					<button class="container-social__btn btn-google">Iniciar sesión con Google</button>
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
				</div>
				<div class="container-footer">
					<span class="container-footer__pregunta">¿Ya tienes cuenta?</span>
					<span class="container-footer__registro" @click="openModalLogin()">Inicia sesión</span>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import loginFacebook from './loginFacebook.vue';
	import swal from 'sweetalert';

	export default {
		props: [
			'typeLogin',
			'typeSvg',
			'userloged'
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
				msgError: ''
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
			registrar() {
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
					this.msgError = `El email ${this.email} no existe, registralo :)`;
					setInterval(() => {
						this.msgError = '';
					}, 3000);
				});
			},
			logout(event) {
				event.preventDefault();
				this.$auth.destroyToken();
				FB.getLoginStatus((resStatusFb) => {
					resStatusFb.status === 'connected';
					FB.logout();
				});
				location.href = '/';
			},
			getUserAuthenticated() {
				let vm = this;
				if(this.$auth.isAuthenticated()) {
					vm.$http.get('api/usersession')
					.then(res => {
						this.user = res.body;
					});
				}
			},
			reloadPage(url, event) {
				event.preventDefault();
				location.href = url;
			},
			publicaUrl(e) {
				e.preventDefault();
				if(this.$auth.isAuthenticated()) {
					location.href = `/publicar/user/${this.user.id}/primer-paso`;
				}else {
					this.openModalLogin();
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
		    padding: 5px 20px 20px 20px;
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
			}
			.container-login {
			    display: flex;
			    flex-direction: column;
			    padding: 1em 0;
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
	}
</style>