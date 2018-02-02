<template>
    <div>
        <router-link to="/mensajes" class="left-icon"><img src="https://res.cloudinary.com/wimet/image/upload/v1515117771/icons/ic_left.svg"> ATRAS</router-link>
        <div class="container-evento">
            <span class="container-evento__title">EVENTO</span>
        </div>
        <div class="evento-main">
            <div v-show="espacio.id == undefined || evento.id == undefined || mensajes.length == 0" class="wt-center-center">
                <img src="https://res.cloudinary.com/wimet/image/upload/fotosespacios/logo_wimet.gif" width="50%">
            </div>
            <template v-if="espacio.id != undefined && evento.id != undefined && mensajes.length > 0">
            <div class="row">
                <h4 class="text-center">{{evento.nombre_evento}}</h4>
                <div class="col-md-8">
                    <div class="alerta">La mayoría de los anfitriones responden en un plazo de 14 hs. Si has elegido esta publicación y estas de acuerdo con sus políticas y precio, demuestra tu interés solicitando el presupuesto formal al anfitrión.</div>
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
                            class="content-bottons__transparent">¡SOLICITAR DATOS!
                        </button>
                        <button class="content-bottons__send" @click="sendMensaje()">
                            <span v-show="!showLoading">ENVIAR MENSAJE</span>
                            <img v-if="showLoading" src="https://res.cloudinary.com/wimet/image/upload/v1504053199/loading-white.svg" alt="Cargando ..." height="10px" />
                        </button>
                    </div>
                    <div class="container-chats">
                        <div v-for="mensaje in mensajes" :key="mensaje.id">
                            <div v-if="$store.getters.getUser.id != mensaje.user_id" class="container-chats__cliente">
                                <div class="cliente-texto">
                                    <span class="cliente-texto__fecha">{{$moment(mensaje.created_at).subtract(3, 'hours').locale('es').format("D MMM YYYY HH:MM")}}</span>
                                    <span>{{mensaje.mensaje}}</span>
                                </div>
                                <div class="cliente-user">
                                    <span>{{mensaje.firstname}}</span>
                                    <img v-if="mensaje.imagesource != undefinded" class="cliente-user__img" :src="mensaje.imagesource" :alt="mensaje.firstname">
                                </div>
                            </div>
                            <div v-if="$store.getters.getUser.id == mensaje.user_id" class="container-chats__user">
                                <div class="user-texto">
                                    <span class="user-texto__fecha">{{$moment(mensaje.created_at).subtract(3, 'hours').locale('es').format("D MMM YYYY HH:MM")}}</span>
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
                <div class="col-md-4">
                    <div class="box-resumen wt-m-top-1">
                        <img :src="espacio.portada" class="img-responsive">
                        <div class="box-resumen__body">
                            <span class="wt-m-bot-1">Estado: {{evento.estado}}</span>
                            <span class="wt-m-bot-1">Actividad: {{getCategoria(evento.estilo_espacios_id)}}</span>
                            <span class="wt-m-bot-1">Invitados: {{evento.invitados}}</span>
                            <span class="wt-m-bot-1">Fechas solicitadas</span>
                            <span v-if="$store.getters.getUser.isAdmin" class="wt-m-bot-1">Teléfono de contacto: {{evento.telefono}}</span>
                            <ul>
                                <li v-for="dia in dias" :key="dia.id">
                                    <span v-if="dia.tipo == 'all'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (jornada completa)</span>
                                    <span v-if="dia.tipo == 'morning'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - am)</span>
                                    <span v-if="dia.tipo == 'night'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - pm)</span>
                                </li>
                            </ul>
                            <h4 class="wt-m-top-1">PRECIO</h4>
                            <div class="box-resumen__precios">
                                <div class="wt-space-block wt-m-bot-1">
                                    <span>Total x espacio</span>
                                    <span>${{evento.sub_total}}</span>
                                </div>
                                <div v-if="evento.user_id === $store.getters.getUser.id" class="wt-space-block wt-m-bot-1">
                                    <span>Comisión Wimet</span>
                                    <span>$1800</span>
                                </div>
                                <div v-if="evento.user_id === $store.getters.getUser.id" class="wt-space-block">
                                    <strong>Recibirás</strong>
                                    <strong>${{evento.sub_total - 1800}}</strong>
                                </div>
                                <div v-if="evento.cliente_id === $store.getters.getUser.id" class="wt-space-block wt-m-bot-1">
                                    <span>Seña a favor</span>
                                    <span>$ -{{getSenia()}}</span>
                                </div>
                                <div v-if="evento.cliente_id === $store.getters.getUser.id" class="wt-space-block">
                                    <strong>Saldo restante</strong>
                                    <strong>${{evento.sub_total - senia}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="dashboard-title text-center wt-m-top-4">Propuestas</h3>
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Número</th>
                                    <th class="text-center">Creación</th>
                                    <th class="text-center">Enviada</th>
                                    <th class="text-center">Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="propuesta in propuestas" @click="redirectPropuesta($event, propuesta.id)" class="cursor-pointer active">
                                    <td>{{propuesta.id}}</td>
                                    <td>{{$moment(propuesta.reserva_desde).subtract(3, 'hours').locale('es').format("MMM DD")}}</td>
                                    <td>{{$moment(propuesta.created_at).subtract(3, 'hours').locale('es').format("MMM DD")}}</td>
                                    <td>${{propuesta.sub_total}}</td>
                                </tr>
                            </tbody>
                        </table>
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
                senia: 0
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
                        this.getDias();
                        this.getEspacio();
                        this.getPropuestas();
                    });
            },
            getMensajes() {
                this.$http.get(`api/mensaje/${this.$route.params.id}`)
                    .then(res => {
                        this.mensajes = res.body;
                    });
            },
            enviarPropuesta() {
                this.$router.push({name: 'nueva-propuesta', params: { eventoId: this.$route.params.id }});
            },
            solicitarPropuesta() {
                let aux = false;
                for(let i = 0; i < this.$store.getters.getUser.senias.length; i++) {

                    if(
                        this.$store.getters.getUser.senias[i].vencimiento > this.$moment().format('YYYY-MM-DD hh:mm:ss')
                        && this.$store.getters.getUser.senias[i].estado === 'pendiente'
                        && this.$store.getters.getUser.descuentos > 0
                    ) {
                        aux = true;
                        let data = {
                          user_id: this.$store.getters.getUser.id,
                          espacio_id: this.espacio.id
                        };
                        this.$http.post('api/sendata', data)
                        .then(res => {
                            this.$toastr.success("Se enviaron los datos del espacio a su email", "Datos envíados!");
                            this.$store.commit('setUser', res.body);
                        }, err => {
                            this.$toastr.error(err, "Ups hubo un error!");
                        });
                    }

                }
                if(aux) {
                    this.$router.push({name: 'Mensajes'});
                }else {
                    location.href = `https://wimet.co/dashboard#/mensaje/${this.$route.params.id}/solicitud`;
                }
            },
            sendMensaje(){
                if(this.showLoading) {
                    return;
                }
                let phoneExp = /(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([1-9]1[01-9]|[1-9][01-8]1|[1-9][01-8][01-9])\s*\)|([1-9]1[01-9]|[1-9][01-8]1|[1-9][01-8][01-9]))\s*(?:[.-]\s*)?)?([1-9]1[01-9]|[1-9][01-9]1|[1-9][01-9]{1})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/img;
                let emailExp = /([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/img;
                this.mensajeEnviar = this.mensajeEnviar.replace(phoneExp, '###############');
                this.mensajeEnviar = this.mensajeEnviar.replace(emailExp, '*****@*****.***');
                this.showLoading = true;
                this.$toastr.info("Su mensaje se está enviando, aguarde unos segundos", "Mensaje enviandose...");
                let data = {
                    evento_id: this.$route.params.id,
                    user_id: this.$store.getters.getUser.id,
                    presupuesto: false,
                    mensaje: this.mensajeEnviar,
                    status: 0
                }
                this.$http.post('api/mensaje', data)
                .then(res => {
                    this.showLoading = false;
                    this.$toastr.success("Su mensaje ha sido enviando", "Mensaje enviado!");
                    this.getMensajes();
                    this.mensajeEnviar = '';
                });
            },
            getEspacio() {
                this.$http.get(`api/espacio/${this.evento.espacio_id}`)
                .then(res => {
                    this.espacio = res.body;
                }, err => {
                    console.log(err);
                });
            },
            getPropuestas() {
                this.$http.get(`api/propuesta?evento_id=${this.evento.id}`)
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
                    case 1:
                        return 'EVENTO';
                    case 3:
                        return 'PRODUCCIÓN';
                    case 4:
                        return 'RETAIL';
                }
            },
            getSenia() {
                let senias = this.$store.getters.getUser.senias;
                let now = this.$moment();
                for(let i = 0; i < senias.length; i++) {
                    let dif = now.diff(this.$moment(senias[i].vencimiento));
                    if(dif > 0) {
                        this.senia = 1800;
                        return;
                    }
                }
                return;
            },
            redirectPropuesta(e, id) {
                e.preventDefault();
                this.$router.push({name: 'Propuesta', params: { id: id }});
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
        color: #333333;
    }
    .container-evento {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 0 1em;
        margin-top: 3em;
        align-items: flex-end;
        &__title {
            font-family: Avenir;
            font-size: 16px;
            font-weight: bold;
            color: #333333;
        }
    }
    .evento-main {
        margin-top: 1em;
        padding: 1em;
        background-color: #ffffff;
        box-shadow: 0 0 68px 0 rgba(0, 0, 0, 0.1);
        color: #333333;
        .alerta {
            width: 100%;
            padding: 1em;
            margin: 1em 0;
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
                font-size: 11px;
                background-color: #fff;
                border: solid 1px #fc5189;
                padding: 1em;
                color: #fc5189;
                border-radius: 1px;
            }
            &__send {
                font-size: 11px;
                background-color: #fc5189;
                border: solid 1px #fc5189;
                padding: 1em;
                color: #fff;
                border-radius: 1px;
                min-width: 100px;
            }
        }
        .container-chats {
            margin-top: 1em;
            &__cliente {
                font-family: Avenir;
                font-size: 11px;
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
                font-family: Avenir;
                font-size: 11px;
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
                padding: 0 1em;
                margin-top: 1em;
                display: flex;
                justify-content: space-between;
                align-items: baseline;
            }
            &__fechas {
                padding: 0 1em;
                margin-bottom: 1em;
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