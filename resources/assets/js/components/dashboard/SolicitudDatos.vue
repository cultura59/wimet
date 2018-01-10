<template>
    <div>
        <router-link :to="`/mensaje/${$route.params.id}`" class="left-icon"><img src="https://res.cloudinary.com/wimet/image/upload/v1515117772/icons/ic_left.svg"> ATRAS</router-link>
        <div class="container-evento">
            <span class="container-evento__title">Solicitud de datos</span>
        </div>
        <div class="evento-main">
            <div v-show="espacio.id == undefined || evento.id == undefined" class="wt-center-center">
                <img src="https://res.cloudinary.com/wimet/image/upload/fotosespacios/logo_wimet.gif" width="50%">
            </div>
            <div v-show="espacio.id != undefined && evento.id != undefined" class="row">
                <div class="col-md-8">
                    <div class="evento-main__body">
                        <h4>Datos para la autorización</h4>
                        <p class="wt-m-top-3">Solicitaremos una autorización y captura por $1800 en concepto de seña, pero el cobro no se hará efectivo hasta tanto hayas definido el espacio que quieras contratar.</p>
                        <p class="wt-m-bot-3">Este importe será descontado de la propuesta final que recibas por parte del anfitrión.</p>
                        <div class="wt-space-block">
                            <img src="https://res.cloudinary.com/wimet/image/upload/v1515327246/mercado-pago-medios-de-pago.png" class="img-promos">
                            <div class="credit-card-box">
                            <div class="flip" :class="{'flip--active': flip}">
                                <div class="front">
                                    <div class="chip"></div>
                                    <div class="logo">
                                        <svg version="1.1" id="visa" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             width="47.834px" height="47.834px" viewBox="0 0 47.834 47.834" style="enable-background:new 0 0 47.834 47.834;">
                                            <g>
                                                <g>
                                                    <path d="M44.688,16.814h-3.004c-0.933,0-1.627,0.254-2.037,1.184l-5.773,13.074h4.083c0,0,0.666-1.758,0.817-2.143
                             c0.447,0,4.414,0.006,4.979,0.006c0.116,0.498,0.474,2.137,0.474,2.137h3.607L44.688,16.814z M39.893,26.01
                             c0.32-0.819,1.549-3.987,1.549-3.987c-0.021,0.039,0.317-0.825,0.518-1.362l0.262,1.23c0,0,0.745,3.406,0.901,4.119H39.893z
                             M34.146,26.404c-0.028,2.963-2.684,4.875-6.771,4.875c-1.743-0.018-3.422-0.361-4.332-0.76l0.547-3.193l0.501,0.228
                             c1.277,0.532,2.104,0.747,3.661,0.747c1.117,0,2.313-0.438,2.325-1.393c0.007-0.625-0.501-1.07-2.016-1.77
                             c-1.476-0.683-3.43-1.827-3.405-3.876c0.021-2.773,2.729-4.708,6.571-4.708c1.506,0,2.713,0.31,3.483,0.599l-0.526,3.092
                             l-0.351-0.165c-0.716-0.288-1.638-0.566-2.91-0.546c-1.522,0-2.228,0.634-2.228,1.227c-0.008,0.668,0.824,1.108,2.184,1.77
                             C33.126,23.546,34.163,24.783,34.146,26.404z M0,16.962l0.05-0.286h6.028c0.813,0.031,1.468,0.29,1.694,1.159l1.311,6.304
                             C7.795,20.842,4.691,18.099,0,16.962z M17.581,16.812l-6.123,14.239l-4.114,0.007L3.862,19.161
                             c2.503,1.602,4.635,4.144,5.386,5.914l0.406,1.469l3.808-9.729L17.581,16.812L17.581,16.812z M19.153,16.8h3.89L20.61,31.066
                             h-3.888L19.153,16.8z"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="number">{{payment.cardNumber}}</div>
                                    <div class="card-holder">
                                        <label>Card holder</label>
                                        <div>{{payment.cardholderName}}</div>
                                    </div>
                                    <div class="card-expiration-date">
                                        <label>Expires</label>
                                        <div>{{payment.cardExpirationMonth}}/{{payment.cardExpirationYear}}</div>
                                    </div>
                                </div>
                                <div class="back">
                                    <div class="strip"></div>
                                    <div class="logo">
                                        <svg version="1.1" id="visa" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             width="47.834px" height="47.834px" viewBox="0 0 47.834 47.834" style="enable-background:new 0 0 47.834 47.834;">
                                            <g>
                                                <g>
                                                    <path d="M44.688,16.814h-3.004c-0.933,0-1.627,0.254-2.037,1.184l-5.773,13.074h4.083c0,0,0.666-1.758,0.817-2.143
                             c0.447,0,4.414,0.006,4.979,0.006c0.116,0.498,0.474,2.137,0.474,2.137h3.607L44.688,16.814z M39.893,26.01
                             c0.32-0.819,1.549-3.987,1.549-3.987c-0.021,0.039,0.317-0.825,0.518-1.362l0.262,1.23c0,0,0.745,3.406,0.901,4.119H39.893z
                             M34.146,26.404c-0.028,2.963-2.684,4.875-6.771,4.875c-1.743-0.018-3.422-0.361-4.332-0.76l0.547-3.193l0.501,0.228
                             c1.277,0.532,2.104,0.747,3.661,0.747c1.117,0,2.313-0.438,2.325-1.393c0.007-0.625-0.501-1.07-2.016-1.77
                             c-1.476-0.683-3.43-1.827-3.405-3.876c0.021-2.773,2.729-4.708,6.571-4.708c1.506,0,2.713,0.31,3.483,0.599l-0.526,3.092
                             l-0.351-0.165c-0.716-0.288-1.638-0.566-2.91-0.546c-1.522,0-2.228,0.634-2.228,1.227c-0.008,0.668,0.824,1.108,2.184,1.77
                             C33.126,23.546,34.163,24.783,34.146,26.404z M0,16.962l0.05-0.286h6.028c0.813,0.031,1.468,0.29,1.694,1.159l1.311,6.304
                             C7.795,20.842,4.691,18.099,0,16.962z M17.581,16.812l-6.123,14.239l-4.114,0.007L3.862,19.161
                             c2.503,1.602,4.635,4.144,5.386,5.914l0.406,1.469l3.808-9.729L17.581,16.812L17.581,16.812z M19.153,16.8h3.89L20.61,31.066
                             h-3.888L19.153,16.8z"/>
                                                </g>
                                            </g>
                                        </svg>

                                    </div>
                                    <div class="ccv">
                                        <label>CCV</label>
                                        <div>{{payment.securityCode}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <form action="#" id="pay">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="cardNumber">Número de tarjeta:</label>
                                    <input
                                        type="text"
                                        id="cardNumber"
                                        class="form-control"
                                        data-checkout="cardNumber"
                                        @keyup="guessingPaymentMethod($event)"
                                        @change="guessingPaymentMethod($event)"
                                        v-model="payment.cardNumber"
                                        placeholder="4509 9535 6623 3704" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cardholderName">Nombre y Apellido:</label>
                                    <input
                                        type="text"
                                        id="cardholderName"
                                        class="form-control"
                                        data-checkout="cardholderName"
                                        v-model="payment.cardholderName"
                                        placeholder="APRO" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cardExpirationMonth">Mes de vencimiento:</label>
                                    <input
                                        type="text"
                                        id="cardExpirationMonth"
                                        class="form-control"
                                        data-checkout="cardExpirationMonth"
                                        v-model="payment.cardExpirationMonth"
                                        placeholder="12" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cardExpirationYear">Año de vencimiento:</label>
                                    <input
                                        type="text"
                                        id="cardExpirationYear"
                                        class="form-control"
                                        data-checkout="cardExpirationYear"
                                        v-model="payment.cardExpirationYear"
                                        placeholder="2015" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="docType">Tipo de documento:</label>
                                    <select
                                        id="docType"
                                        class="form-control"
                                        data-checkout="docType"
                                        v-model="payment.docType">
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="docNumber">Número de documento:</label>
                                    <input type="text" id="docNumber" class="form-control" data-checkout="docNumber" placeholder="12345678" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="securityCode">Código de seguridad:</label>
                                    <input
                                        type="text"
                                        id="securityCode"
                                        class="form-control"
                                        data-checkout="securityCode"
                                        v-model="payment.securityCode"
                                        @keyup="flip = true"
                                        @change="flip = false"
                                        placeholder="123" />
                                </div>
                            </div>
                            <input class="btn-enviar" type="submit" @click="doPay($event)" value="ENVIAR" />
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Resumen</h4>
                    <div class="box-resumen">
                        <img :src="espacio.portada" class="img-responsive">
                        <div class="box-resumen__body">
                            <span class="wt-m-bot-1">Estado: {{evento.estado}}</span>
                            <span class="wt-m-bot-1">Actividad: {{getCategoria(evento.estilo_espacios_id)}}</span>
                            <span class="wt-m-bot-1">Invitados: {{evento.invitados}}</span>
                            <span class="wt-m-bot-1">Fechas solicitadas</span>
                            <ul>
                                <li v-for="dia in dias" :key="dia.id">
                                    <span v-if="dia.tipo == 'all'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (jornada completa)</span>
                                    <span v-if="dia.tipo == 'morning'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - am)</span>
                                    <span v-if="dia.tipo == 'night'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - pm)</span>
                                </li>
                            </ul>
                            <h4 class="wt-m-top-2">PRECIO</h4>
                            <div class="box-resumen__precios">
                                <div class="wt-space-block wt-m-bot-1">
                                    <span>Total x espacio</span>
                                    <span>${{evento.sub_total}}</span>
                                </div>
                                <div class="wt-space-block wt-m-bot-1">
                                    <span>Comisión Wimet</span>
                                    <span>${{fee}}</span>
                                </div>
                                <div class="wt-space-block">
                                    <strong>Recibirás</strong>
                                    <strong>${{evento.sub_total - fee}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "chat",
        data() {
            return {
                evento: {},
                espacio: {},
                dias: [],
                showLoading: false,
                backgroundEspacio: {},
                fee: 0,
                flip: false,
                payment: {
                    email: this.$store.getters.getUser.email
                }
            }
        },
        mounted() {
            this.initMP();
            this.getEvento();
        },
        ready() {
            this.initMP();
        },
        methods: {
            initMP() {
                Mercadopago.setPublishableKey("APP_USR-0f9211c7-a1f9-45d8-b694-c865f48d5637");
                Mercadopago.getIdentificationTypes();
            },
            getEvento() {
                this.$http.get(`api/evento/${this.$route.params.id}`)
                    .then(res => {
                        this.evento = res.body;
                        this.fee = (parseFloat(this.evento.sub_total) * 5) / 100;
                        this.getDias();
                        this.getEspacio();
                    });
            },
            enviarPropuesta() {},
            getEspacio() {
                this.$http.get(`api/espacio/${this.evento.espacio_id}`)
                .then(res => {
                    this.espacio = res.body;
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
            },
            guessingPaymentMethod(event) {
                let bin = this.getBin();
                if (event.type == "keyup") {
                    if (bin.length >= 6) {
                        Mercadopago.getPaymentMethod({
                            "bin": bin
                        }, this.setPaymentMethodInfo);
                    }
                } else {
                    setTimeout(function() {
                        if (bin.length >= 6) {
                            Mercadopago.getPaymentMethod({
                                "bin": bin
                            }, this.setPaymentMethodInfo);
                        }
                    }, 100);
                }
            },
            getBin() {
                return this.payment.cardNumber.replace(/[ .-]/g, '').slice(0, 6);
            },
            setPaymentMethodInfo(status, res) {
                if (status == 200) {
                    this.payment.paymentMethodId = res[0].id;
                }
            },
            sdkResponseHandler(status, res) {
                if (status != 200 && status != 201) {
                    this.$toastr.error(res, "Ups hubo un error!");
                }else{
                    this.payment.token = res.id;
                    this.payment.user_id = this.$store.getters.getUser.id;
                    this.payment.email = this.$store.getters.getUser.email;
                    this.payment.firstname = this.$store.getters.getUser.firstname;
                    this.payment.lastname = this.$store.getters.getUser.lastname;
                    this.payment.vencimiento = this.$moment().add(5, 'days').format('YYYY-MM-DD hh:mm:ss');
                    this.$http.post(`api/sendpayment`, this.payment)
                    .then(res => {
                        this.$store.commit('setUser', res.body);
                        this.$toastr.success("Fue enviado por email los datos del espacio", "Felicitaciones!");
                    }, err => {
                        this.$toastr.error(err, "Ups hubo un error!");
                    });
                }
            },
            doPay(e) {
                e.preventDefault();
                let form = document.querySelector('#pay');
                Mercadopago.createToken(form, this.sdkResponseHandler);
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
        padding: 0 2em;
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
        margin-top: 2em;
        padding: 2em;
        background-color: #ffffff;
        box-shadow: 0 0 68px 0 rgba(0, 0, 0, 0.1);
        color: #333333;
        &__body {
            padding-right: 3em;
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
    .btn-enviar {
        float: right;
        padding: .5em 2em;
        background: #FC5289;
        color: #fff;
        border: none;
    }
    .img-promos {
        width: 40%;
        float: left;
        display: block;
        height: auto;
    }
</style>