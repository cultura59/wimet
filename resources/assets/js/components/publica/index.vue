<template>
	<div>
		<template v-if="authenticated">
			<div class="publica-navbar">
				<a href="#" :class="{active: $route.path == '/'}" @click="changeUrl($event, 'basico', null)">1. Basico</a>
				<template v-if="$store.getters.getEspacio.prices.length == 0 || $store.getters.getEspacio.prices == undefined">
					<a href="#" :class="{active: $route.name == 'actividades'}">2. Actividades</a>
				</template>
				<template v-if="$store.getters.getEspacio.prices.length > 0">
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
		font-family: Ubuntu;
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
</style>