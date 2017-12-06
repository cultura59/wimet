<template>
    <div>
        <template v-if="authenticated">
            <!-- Header Home -->
            <wimet-login fixed="false"></wimet-login>
            <main>
                <div v-if="$store.getters.getUser.tipo_clientes_id > 1" class="dashboard-navbar">
                    <router-link to="/" :class="{active: $route.path == '/'}">Dashboard</router-link>
                    <router-link to="/mensajes" :class="{active: $route.name == 'Mensajes'}">Mensajes</router-link>
                    <router-link to="/propuestas" :class="{active: $route.name == 'Propuestas'}">Propuestas</router-link>
                    <router-link to="/espacios" :class="{active: $route.name == 'Espacios'}">Espacios</router-link>
                    <router-link to="/favoritos" :class="{active: $route.name == 'Favoritos'}">Favoritos</router-link>
                    <router-link to="/perfil" :class="{active: $route.name == 'Perfil'}">Mi perfil</router-link>
                </div>
                <section class="dashboard-container">
                    <div class="dashboard-body">
                        <router-view></router-view>
                    </div>
                </section>
            </main>
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
    import wimetLogin from '../WimetLogin.vue';
    import loginFacebook from '../loginFacebook.vue';
    import loginGoogle from '../loginGoogle.vue';
    import {registerLogin} from '../../mixins/registerLogin';
    export default {
        mixins: [registerLogin],
        components: {
            'wimet-login': wimetLogin,
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
        }
    }
</script>
<style lang="sass" scoped>
    .dashboard-navbar {
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