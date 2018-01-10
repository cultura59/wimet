<template>
	<div>
		<template v-if="authenticated">
			<div class="publica-navbar">
				<a href="#" :class="{active: $route.path == '/'}" @click="changeUrl($event, 'basico', null)">1. Basico</a>
				<template v-if="$store.getters.getEspacio.prices == undefined">
					<a href="#" :class="{active: $route.name == 'actividades'}">2. Actividades</a>
				</template>
				<template v-if="$store.getters.getEspacio.prices !== undefined">
					<router-link
						v-for="(cat, key) in $store.getters.getEspacio.prices"
						v-if="cat.categoria.name != undefined"
						:to="`/actividad/${cat.categoria.name}`"
						:class="{active: $route.params.name == cat.categoria.name}">2.{{key+1}} {{cat.categoria.name}}
					</router-link>
				</template>
				<router-link to="/amenities" :class="{active: $route.name == 'amenities'}">3. Amenities</router-link>
				<router-link to="/disponibilidad" :class="{active: $route.name == 'disponibilidad'}">4. Disponibilidad</router-link>
				<router-link to="/foto" :class="{active: $route.name == 'foto'}">5. Fotos</router-link>
				<router-link to="/descripcion" :class="{active: $route.name == 'descripcion'}">6. Descripción</router-link>
			</div>
			<div class="container">
				<router-view></router-view>
			</div>
		</template>
		<template v-if="!authenticated">
			<div class="login-modal__content">
				<h3>¡Te estábamos esperando!</h3>
				<div v-if="msgError != ''" class="alert alert-danger" role="alert">{{msgError}}</div>
				<div class="container-social">
					<login-facebook urlredirect="0"></login-facebook>
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
						<img src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-white.svg" alt="Cargando ..." height="50px" />
					</button>
				</div>
				<div class="container-footer">
					<span class="container-footer__pregunta">¿No tienes cuenta?</span>
					<span class="container-footer__registro" @click="openModalRegistro()">Registrate</span>
				</div>
			</div>
		</template>
	</div>
</template>
<script>
    import loginFacebook from '../loginFacebook.vue';
    import loginGoogle from '../loginGoogle.vue';
    import {registerLogin} from '../../mixins/registerLogin';
    export default {
        name: 'index-publica',
        mixins: [registerLogin],
        components: {
            'login-facebook': loginFacebook,
            'login-google': loginGoogle
        },
        data() {
            return {
                authenticated: this.$auth.isAuthenticated(),
            }
        },
        mounted() {
            if(this.$auth.isAuthenticated()) {
                this.getUserAuthenticated();
            }
        },
		methods: {
			changeUrl(e, name, params) {
                e.preventDefault();
                if(params !== null) {
                    this.$router.push({name: name, params: params});
                }else {
                    this.$router.push({name: name});
				}
			}
		}
    }
</script>
<style lang="sass" scoped>
	.publica-navbar {
		transition: none;
		font-family: Avenir;
		display: flex;
		justify-content: baseline;
		align-items: center;
		height: 45px;
		background-color: #f8f8f8;
		padding: 0 50px;
		a {
			transition: none;
			color: #333;
			margin: 10px 30px 0px 15px;
			padding-bottom: 10px;
			&:hover, &:focus {
				transition: none;
				text-decoration: none;
				border-bottom: 2px solid #d17f87;
			}
		}
		.active {
			transition: none;
			color: #d17f87;
			margin: 10px 30px 0px 15px;
			padding-bottom: 10px;
			transition: none;
			text-decoration: none;
			border-bottom: 2px solid #d17f87;
			&:hover, &:focus {
				transition: none;
				text-decoration: none;
				border-bottom: 2px solid #d17f87;
			}
		}
	}
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
	}
</style>