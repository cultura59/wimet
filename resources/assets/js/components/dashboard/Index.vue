<template>
    <div>
        <template v-if="authenticated">
            <!-- Header Home -->
            <wimet-login fixed="false"></wimet-login>
            <main>
                <div v-if="$store.getters.getUser.tipo_clientes_id > 1" class="dashboard-navbar">
                    <router-link to="/" :class="{active: $route.path == '/'}">Escritorio</router-link>
                    <router-link to="/mensajes" :class="{active:
                        $route.name == 'Mensajes' ||
                        $route.name == 'Mensaje' ||
                        $route.name == 'nueva-propuesta'||
                        $route.name == 'solicitud'
                    }">Mensajes</router-link>
                    <router-link to="/propuestas" :class="{active: $route.name == 'Propuestas' || $route.name == 'Custom' || $route.name == 'Propuesta'}">Propuestas</router-link>
                    <router-link to="/espacios" :class="{active: $route.name == 'Espacios'}">Espacios</router-link>
                    <router-link to="/favoritos" :class="{active: $route.name == 'Favoritos'}">Favoritos</router-link>
                    <router-link to="/perfil" :class="{active: $route.name == 'Perfil'}">Mi perfil</router-link>
                </div>
                <section class="dashboard-container">
                    <div class="container">
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
        font-family: Avenir;
        display: flex;
        justify-content: baseline;
        align-items: center;
        background-color: #666666;
        padding: 0 50px;
        height: 100%;
        a {
            transition: none;
            color: #fff;
            padding: .5em 1em;
            text-align: center;
            width: 100px;
            padding-top: 4px;
            &:hover, &:focus {
                transition: none;
                text-decoration: none;
                border-top: 4px solid #fc5289;
            }
        }
        .active {
            color: #fc5289;
            height: 100%;
            width: 110px;
            background-color: #f8f8f8;
            border-top: 4px solid #fc5289;
            &:hover, &:focus {
                transition: none;
                text-decoration: none;
                border-top: 4px solid #fc5289;
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
</style>