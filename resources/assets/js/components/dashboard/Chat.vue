<template>
    <div>
        <router-link to="/mensajes" class="left-icon"><img src="/img/ic_left.svg"> ATRAS</router-link>
        <div class="container-evento">
            <span class="container-evento__title">EVENTO</span>
        </div>
        <div class="evento-main">
            <div v-show="espacio.id == undefined || evento.id == undefined || mensajes.length == 0" class="wt-center-center">
                <img src="https://res.cloudinary.com/wimet/image/upload/fotosespacios/logo_wimet.gif" width="50%">
            </div>
            <template v-if="espacio.id != undefined && evento.id != undefined && mensajes.length > 0">
            <div class="row">
                <div class="col-md-6">
                    <h4>{{evento.nombre_evento}}</h4>
                    <div class="alerta">La mayoría de los anfitriones responden en un plazo de 24 hs. Si has elegido esta publicación y estas de acuerdo con sus políticas y precio, demuestra tu interés solicitando el presupuesto formal al anfitrión.</div>
                    <textarea rows="4" class="evento-main__textarea" placeholder="Escribe tu respuesta..." v-model="mensajeEnviar"></textarea>
                    <div class="content-bottons">
                        <button
                            v-if="$store.getters.getUser.id != evento.cliente_id"
                            @click="enviarPropuesta()"
                            class="content-bottons__transparent">¡ENVIAR PRESUPUESTO!
                        </button>
                        <button
                            v-if="$store.getters.getUser.id == evento.cliente_id"
                            @click="solicitarPropuesta()"
                            class="content-bottons__transparent">¡SOLICITAR PRESUPUESTO!
                        </button>
                        <button class="content-bottons__send" @click="sendMensaje()">
                            <span v-show="!showLoading">ENVIAR MENSAJE</span>
                            <img v-if="showLoading" src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-white.svg" alt="Cargando ..." height="30px" />
                        </button>
                    </div>
                    <div class="container-chats">
                        <div v-for="mensaje in mensajes" :key="mensaje.id">
                            <div v-if="$store.getters.getUser.id != mensaje.user_id" class="container-chats__cliente">
                                <div class="cliente-texto">
                                    <span class="cliente-texto__fecha">{{mensaje.created_at}}</span>
                                    <span>{{mensaje.mensaje}}</span>
                                </div>
                                <div class="cliente-user">
                                    <span>{{mensaje.firstname}}</span>
                                    <img v-if="mensaje.imagesource != undefinded" class="cliente-user__img" :src="mensaje.imagesource" :alt="mensaje.firstname">
                                </div>
                            </div>
                            <div v-if="$store.getters.getUser.id == mensaje.user_id" class="container-chats__user">
                                <div class="user-texto">
                                    <span class="user-texto__fecha">{{mensaje.created_at}}</span>
                                    <span>{{mensaje.mensaje}}</span>
                                </div>
                                <div class="user-user">
                                    <img v-if="mensaje.imagesource != undefinded" class="user-user__img" :src="mensaje.imagesource" :alt="mensaje.firstname">
                                    <span class="user-user__nombre">{{mensaje.firstname}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Resumen</h4>
                    <div class="resumen-detalle">
                        <div :style="backgroundEspacio"></div>
                        <div class="resumen-detalle__info">
                            <div>
                                <p><strong>ESTADO:</strong> {{evento.estado}}</p>
                                <p><strong>PRECIO ESTIMADO:</strong> ${{evento.sub_total}}</p>
                            </div>
                            <div>
                                <p><strong>ACTIVIDAD:</strong> {{getCategoria(evento.estilo_espacios_id)}}</p>
                                <p><strong>INVITADOS:</strong> {{evento.invitados}}</p>
                            </div>
                        </div>
                        <div class="resumen-detalle__fechas">
                            <hr>
                            <strong>FECHAS</strong>
                            <ul>
                                <li v-for="dia in dias" :key="dia.id">
                                    <span>{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}}</span>
                                    <span v-if="dia.tipo == 'all'"> - todo el día</span>
                                    <span v-if="dia.tipo == 'morning'"> - mañana-tarde</span>
                                    <span v-if="dia.tipo == 'night'"> - tarde-noche</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h4 class="text-center">Propuestas</h4>
                    <div v-if="propuestas.length == 0" class="preview-propuestas">
                        <span class="preview-propuestas_texto">Aún no tienes propuestas</span>
                    </div>
                    <div class="content-anfitrion">
                        <img v-if="espacio.user.imagesource != undefined" :src="espacio.user.imagesource" :alt="espacio.user.firstname">
                        <div class="content-anfitrion__detail">
                            <span>{{espacio.user.firstname}}</span>
                            <span class="subtitle">Anfitrión</span>
                        </div>
                    </div>
                </div>
            </div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        name: "chat",
        data() {
            return {
                mensajeEnviar: '',
                mensajes: [],
                evento: {},
                espacio: {},
                propuestas: [],
                dias: [],
                showLoading: false,
                backgroundEspacio: {},
                fee: 0
            }
        },
        mounted() {
            this.getEvento();
            this.getMensajes();
        },
        methods: {
            getEvento() {
                this.$http.get(`api/evento/${this.$route.params.id}`)
                    .then(res => {
                        this.evento = res.body;
                        this.fee = (parseFloat(this.evento.sub_total) * 5) / 100;
                        this.getDias();
                        this.getEspacio();
                    });
            },
            getMensajes() {
                this.$http.get(`api/mensaje/${this.$route.params.id}`)
                    .then(res => {
                        this.mensajes = res.body;
                    });
            },
            enviarPropuesta() {},
            solicitarPropuesta() {
                let data = {
                    evento_id: this.$route.params.id,
                    user_id: 1,
                    presupuesto: true,
                    mensaje: `El usuario ${this.$store.getters.getUser.firstname} a solicitado que le envies un presupuesto.`
                }
                this.$http.post('api/mensaje', data)
                    .then(res => {
                        if(res.status == 204) {
                            this.getMensajes();
                            this.mensajeEnviar = '';
                            this.$toastr.success(
                                "Presupuesto solicitado!",
                                "Dentro de las próximas 48hs el dueño se pondrá en contacto"
                            );
                        }else {
                            this.$toastr.error("Mensaje no enviado!", "Revisa los datos envíados");
                        }
                    });
            },
            sendMensaje(){
                if(this.showLoading) {
                    return;
                }
                this.showLoading = true;
                let data = {
                    evento_id: this.$route.params.id,
                    user_id: this.$store.getters.getUser.id,
                    presupuesto: false,
                    mensaje: this.mensajeEnviar
                }
                this.$http.post('api/mensaje', data)
                    .then(res => {
                        this.showLoading = false;
                        if(res.status == 204) {
                            this.getMensajes();
                            this.mensajeEnviar = '';
                        }else {
                            this.$toastr.error("Mensaje no enviado!", "Revisa los datos envíados");
                        }
                    });
            },
            getEspacio() {
                this.$http.get(`api/espacio/${this.evento.espacio_id}`)
                .then(res => {
                    this.espacio = res.body;
                    this.backgroundEspacio = {
                        backgroundImage: `url(https://res.cloudinary.com/wimet/image/upload/q_60/${this.espacio.images[0].name})`,
                        backgroundSize: 'cover',
                        backgroundPosition: 'center',
                        height: '200px',
                        borderTopLeftRadius: '10px',
                        borderTopRightRadius: '10px'
                    }
                }, err => {
                    console.log(err);
                });
            },
            getPropuestas() {
                this.$http.get(`api/propuesta?eventoId=${this.evento.id}`)
                    .then(res => {
                        this.propuestas = res.body;
                    }, err => {
                        console.log(err);
                    });
            },
            getDias() {
                this.$http.get(`api/eventosdias/${this.$route.params.id}`)
                    .then(res => {
                        this.dias = res.body;
                    });
            },
            getCategoria(id) {
                switch(id) {
                    case 1:
                        return 'REUNIÓN';
                    case 2:
                        return 'EVENTO';
                    case 3:
                        return 'PRODUCCIÓN';
                    case 4:
                        return 'POP-UPS';
                }
            }
        }
    }
</script>

<style lang="sass" scoped>
    .left-icon {
        position: absolute;
        left: 3em;
        top: 1em;
        text-decoration: none;
    }
    .container-evento {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 0 2em;
        margin-top: 3em;
        align-items: flex-end;
        &__title {
            font-family: Ubuntu;
            font-size: 16px;
            font-weight: bold;
            color: #333333;
        }
    }
    .evento-main {
        margin-top: 2em;
        padding: 2em;
        background-color: #ffffff;
        box-shadow: 0 0 68px 0 rgba(0, 0, 0, 0.1);
        color: #333333;
        h4 {
            text-align: center;
            font-weight: bold;
        }
        .alerta {
            width: 100%;
            padding: 1em;
            margin: 2em 0;
            background-color: #fce9ed;
            font-size: 11px;
            font-style: italic;
            color: #545454;
        }
        &__textarea {
            width: 100%;
            padding: 1em;
            border: solid 1px #dadada;
            overflow: hidden;
        }
        .content-bottons {
            display: flex;
            justify-content: space-between;
            margin: 1em 0;
            &__transparent {
                font-size: 12px;
                background-color: #fff;
                border: solid 2px #fc5289;
                padding: 1em;
                color: #fc5289;
                border-radius: 2px;
            }
            &__send {
                font-size: 12px;
                background-color: #fc5289;
                border: solid 2px #fc5289;
                padding: 1em;
                color: #fff;
                border-radius: 2px;
                min-width: 100px;
            }
        }
        .container-chats {
            margin-top: 2em;
            &__cliente {
                font-family: Ubuntu;
                font-size: 12px;
                color: #545454;
                margin-top: 1em;
                .cliente-texto {
                    border-radius: 1px;
                    border: 1px solid #bbbbbb;
                    padding: 1em;
                    display: flex;
                    flex-direction: column;
                    &__fecha {
                        text-align: right;
                        margin-bottom: 1em;
                    }
                }
                .cliente-user {
                    display: flex;
                    justify-content: flex-end;
                    align-items: center;
                    margin-top: 1em;
                    margin-right: 1.5em;
                    &__img {
                        width: 44px;
                        height: 44px;
                        border-radius: 50%;
                        margin-left: 1em;
                    }
                }
            }
            &__user {
                font-family: Ubuntu;
                font-size: 12px;
                color: #545454;
                margin-top: 1em;
                .user-texto {
                    border-radius: 1px;
                    background-color: #f8f8f8;
                    padding: 1em;
                    display: flex;
                    flex-direction: column;
                    &__fecha {
                        text-align: right;
                        margin-bottom: 1em;
                    }
                }
                .user-user {
                    display: flex;
                    justify-content: flex-start;
                    align-items: center;
                    margin-top: 1em;
                    margin-left: 1.5em;
                    &__img {
                        width: 44px;
                        height: 44px;
                        border-radius: 50%;
                    }
                    &__nombre {
                        margin-left: 1em;
                    }
                }
            }
        }
        .resumen-detalle {
            border-radius: 10px;
            background-color: #ffffff;
            border: solid 1px #dadada;
            margin-top: 1em;
            margin-bottom: 3em;
            &__info {
                padding: 0 2em;
                margin-top: 2em;
                display: flex;
                justify-content: space-between;
                align-items: baseline;
            }
            &__fechas {
                padding: 0 2em;
                margin-bottom: 2em;
                ul {
                    list-style: none;
                }
            }
        }
        .preview-propuestas {
            height: 150px;
            border-radius: 10px;
            background-color: #f8f8f8;
            display:flex;
            justify-content: center;
            align-items: center;
            &__texto {
                font-size: 13px;
                font-style: italic;
                color: #545454;
            }
        }
        .content-anfitrion {
            padding: 3em;
            display: flex;
            align-items: center;
            img {
                width: 74px;
                margin-right: 1em;
                border-radius: 50%;
            }
            &__detail {
                display: flex;
                flex-direction: column;
                font-style: italic;
                .subtitle {font-size: 10px;}
            }
        }
    }
</style>