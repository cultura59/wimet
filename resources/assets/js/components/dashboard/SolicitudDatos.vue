<template>
    <div>
        <router-link to="/mensajes" class="left-icon"><img src="https://res.cloudinary.com/wimet/image/upload/v1515117772/icons/ic_left.svg"> ATRAS</router-link>
        <div class="container-evento">
            <span class="container-evento__title">Solicitud de datos</span>
        </div>
        <div class="evento-main">
            <div v-show="espacio.id == undefined || evento.id == undefined" class="wt-center-center">
                <img src="https://res.cloudinary.com/wimet/image/upload/fotosespacios/logo_wimet.gif" width="50%">
            </div>
            <div v-show="espacio.id != undefined && evento.id != undefined" class="row">
                <div class="col-md-6">
                    <form action="#" id="pay">
                        <div>
                            <label for="email">Email</label>
                            <input
                                id="email"
                                data-checkout="email"
                                v-model="payment.email"
                                type="email"
                                placeholder="your email"/>
                        </div>
                        <div>
                            <label for="cardNumber">Credit card number:</label>
                            <input
                                type="text"
                                id="cardNumber"
                                data-checkout="cardNumber"
                                @keyup="guessingPaymentMethod($event)"
                                @change="guessingPaymentMethod($event)"
                                v-model="payment.cardNumber"
                                placeholder="4509 9535 6623 3704" />
                        </div>
                        <div>
                            <label for="securityCode">Security code:</label>
                            <input
                                type="text"
                                id="securityCode"
                                data-checkout="securityCode"
                                v-model="payment.securityCode"
                                placeholder="123" />
                        </div>
                        <div>
                            <label for="cardExpirationMonth">Expiration month:</label>
                            <input
                                type="text"
                                id="cardExpirationMonth"
                                data-checkout="cardExpirationMonth"
                                v-model="payment.cardExpirationMonth"
                                placeholder="12" />
                        </div>
                        <div>
                            <label for="cardExpirationYear">Expiration year:</label>
                            <input
                                type="text"
                                id="cardExpirationYear"
                                data-checkout="cardExpirationYear"
                                v-model="payment.cardExpirationYear"
                                placeholder="2015" />
                        </div>
                        <div>
                            <label for="cardholderName">Card holder name:</label>
                            <input
                                type="text"
                                id="cardholderName"
                                data-checkout="cardholderName"
                                v-model="payment.cardholderName"
                                placeholder="APRO" />
                        </div>
                        <div>
                            <label for="docType">Document type:</label>
                            <select
                                id="docType"
                                data-checkout="docType"
                                v-model="payment.docType">
                            </select>
                        </div>
                        <div>
                            <label for="docNumber">Document number:</label>
                            <input type="text" id="docNumber" data-checkout="docNumber" placeholder="12345678" />
                        </div>
                        <input type="submit" @click="doPay($event)" value="Enviar datos" />
                    </form>
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
                payment: {
                    email: this.$store.getters.getUser.email,
                    first_name: this.$store.getters.getUser.firstname,
                    last_name: this.$store.getters.getUser.lastname
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
                Mercadopago.setPublishableKey("TEST-f7ea7252-3fc4-4441-9efe-52a91055a149");
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
                    this.backgroundEspacio = {
                        backgroundImage: `url(${this.espacio.images[0].name})`,
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
                    console.log(status);
                    console.log(res);
                    alert("verify filled data");
                }else{
                    this.payment.token = res.id;
                    this.payment.user_id = this.$store.getters.getUser.id;
                    this.payment.vencimiento = this.$moment().add(5, 'days').format('yyyy-mm-dd hh:mm:ss');
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