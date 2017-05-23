<template>
	<div class="actions">
		<ul>
			<li>
	            <a href="#" @click="publicaUrl($event)" class="wt-btn-transparent btn-hov">
	                PUBLICA TU ESPACIO
	                <svg :class="typeSvg">
	                    <rect x="0" y="0" fill="none" width="100%" height="100%"/>
	                </svg>
	            </a>
	        </li>
	        <li>
				<button v-if="!authenticated" :class="typeLogin" @click="openModalLogin()">Ingresar</button>
				<div v-if="authenticated">
					<a href="#" id="menu-user">{{ user.firstname }}</a>
				    <ul class="menue-list">
				        <li class="menue-list__item">
				            <a href="#" @click="reloadPage(`dashboard/user/${user.id}/datos`, $event)" style="color: #333;">Editar perfil</a>
				        </li>
				        <li class="menue-list__item">
				            <a href="#" @click="reloadPage(`dashboard/user/${user.id}/misespacios`, $event)" style="color: #333;">Mi cuenta</a>
				        </li>
				        <li class="menue-list__item active">
				            <a href="#" @click="reloadPage(`publicar/primer-paso`, $event)" style="color: #333;">PUBLICAR TU ESPACIO</a>
				        </li>
				        <li>
				            <a href="#" @click="logout($event)" style="color: #333;">Salir</a>
				        </li>
				    </ul>
			    </div>
			</li>
		</ul>
		<div v-if="showModalLogin" class="login-modal">
			<div class="login-modal__content">
				<span class="close-modal" @click="closeModals()">×</span>
				<div class="container-social">
					<button class="container-social__btn btn-facebook">Iniciar sesión con Facebook</button>
					<button class="container-social__btn btn-linkedin">Iniciar sesión con LinkedIn</button>
					<button class="container-social__btn btn-google">Iniciar sesión con Google</button>
				</div>
				<div class="container-login">
					<input type="email" class="container-login__email" placeholder="Email" v-model="email" />
					<input type="password" class="container-login__email" placeholder="Contraseña" v-model="password" />
					<button class="container-login__login" @click="login()">Iniciar sesión</button>
				</div>
				<div class="container-footer">
					<span class="container-footer__pregunta">¿No tienes cuenta?</span>
					<button class="registrar" @click="openModalRegistro()">Registrarte</button>
				</div>
			</div>
		</div>
		<div v-if="showModalRegistro" class="login-modal">
			<div class="login-modal__content">
				<div class="container-social">
					<button class="container-social__btn btn-facebook">Iniciar sesión con Facebook</button>
					<button class="container-social__btn btn-linkedin">Iniciar sesión con LinkedIn</button>
					<button class="container-social__btn btn-google">Iniciar sesión con Google</button>
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
					<button class="registrar" @click="openModalLogin()">Inicia sesión</button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import swal from 'sweetalert';
	export default {
		props: [
			'typeLogin',
			'typeSvg'
		],
		data() {
			return {
				email: '',
				password: '',
				showModalLogin: false,
				showModalRegistro: false,
				authenticated: this.$auth.isAuthenticated(),
				user: {}
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
					password: this.password
				}
				this.$http.post('api/user', data)
				.then(res => {
					if(res.status == 200) {
						this.login();
						this.showModalRegistro = false;
						swal('Buen trabajo!', 'te registraste con exito', 'success');
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
				this.showModalLogin = false;
				this.$http.post('oauth/token', data)
				.then(res => {
					if(res.status == 200) {
						swal('Bienvenido!!!', 'Gracias por volver a nuestra familia', 'success');
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
			logout(event) {
				event.preventDefault();
				this.$auth.destroyToken();
				this.authenticated = this.$auth.isAuthenticated();
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
		    .close-modal {
			    color: #000;
			    font-size: 28px;
			    font-weight: bold;
			    cursor: pointer;
			}
			.container-social {
			    padding-bottom: 1em;
			    border-bottom: solid 1px #979797;
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
			    justify-content: space-between;
			    align-items: baseline;
			    border-top: solid 1px #979797;
			    padding-top: 1em;
			    &__pregunta {
				    font-size: 12px;
				    font-weight: 500;
				    letter-spacing: -0.2px;
				    color: #1c3240;
				}
				.registrar {
				    background: #fff;
				    border-radius: 2px;
				    border: solid 1px #ea516d;
				    color: #ea516d;
				    font-size: 12px;
				    padding: 1em;
				}
			}
	    }
	}
</style>