<template>
    <div class="wt-m-top-5 wt-m-bot-5">
        <div v-if="showBox" class="row">
            <div class="col-xs-12 col-md-6">
                <h1 class="publica-titulo">Establece las condiciones</h1>
                <h1 class="publica-titulo">para {{$route.params.name}}</h1>
                <div class="publica-box">
                    <div class="publica-box__left">
                        <label class="label-publica">CAPACIDAD</label>
                    </div>
                    <div class="publica-box__rigth">
                        <input class="input-publica" type="text" placeholder="Máximo de asistentes" v-model="$store.getters.getEspacio.prices[indexCat].cantidad_personas">
                    </div>
                </div>
                <div class="publica-box">
                    <div class="publica-box__left">
                        <label class="label-publica">PRECIO</label>
                    </div>
                    <div class="publica-box__rigth">
                        <div class="publica-price">
                            <div class="publica-price__box">
                                <input
                                    class="publica-price__box__input"
                                    type="text"
                                    placeholder="$1000"
                                    v-model="$store.getters.getEspacio.prices[indexCat].daily"
                                    @change="calMediaJornada()">
                                <label class="label-publica">por día</label>
                            </div>
                            <div class="publica-price__box">
                                <input
                                    class="publica-price__box__input"
                                    type="text" placeholder="$6000"
                                    v-model="$store.getters.getEspacio.prices[indexCat].price">
                                <label class="label-publica">por 1/2 día</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="publica-box">
                    <div class="publica-box__left">
                        <label class="label-publica">DEPÓSITO DE SEGURIDAD</label>
                    </div>
                    <div class="publica-box__rigth">
                        <input
                            class="input-publica"
                            type="text"
                            placeholder="$6000"
                            v-model="$store.getters.getEspacio.prices[indexCat].securitydeposit">
                    </div>
                </div>
                <div class="publica-box">
                    <div class="publica-box__left">
                        <label class="label-publica">POLÍTICA DE CANCELACIÓN </label>
                    </div>
                    <div class="publica-box__rigth">
                        <div class="publica-cacellation">
                            <div
                                class="publica-cacellation__box"
                                :class="{'publica-cacellation__box--active': $store.getters.getEspacio.prices[indexCat].cancellationflexibility == 'flexible'}"
                                @click="selectFlexibility('flexible')">
                                <span class="publica-cacellation__box__title">FLEXIBLE</span>
                                <span>Reembolso completo hasta 15 días antes del evento, excepto los gastos de procesamiento.</span>
                            </div>
                            <div
                                class="publica-cacellation__box"
                                :class="{'publica-cacellation__box--active': $store.getters.getEspacio.prices[indexCat].cancellationflexibility == 'moderado'}"
                                @click="selectFlexibility('moderado')">
                                <span class="publica-cacellation__box__title">MODERADA</span>
                                <span>Reembolso completo hasta 30 días antes del evento, excepto los gastos de procesamiento.</span>
                            </div>
                            <div
                                class="publica-cacellation__box"
                                :class="{'publica-cacellation__box--active': $store.getters.getEspacio.prices[indexCat].cancellationflexibility == 'estricto'}"
                                @click="selectFlexibility('estricto')">
                                <span class="publica-cacellation__box__title">ESTRICTA</span>
                                <span>50% de reembolso hasta 30 días antes del evento, excepto gastos de procesamiento.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="publica-box">
                    <input id="all" type="checkbox" v-model="all" style="display: none;">
                    <label for="all" class="wt-publica-label">Establecer misma capacidad, precios y condiciones para todas las categorías.</label>
                </div>
                <div class="wt-space-block wt-m-top-3" @click="back()">
                    <button class="btn-publica-step-default">
                        <img src="https://res.cloudinary.com/wimet/image/upload/v1512746740/ic_keyboard_backspace_black_24px.svg">
                        <span>ATRÁS</span>
                    </button>
                    <img v-show="!btnSend" src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-pig_oxestq.svg" alt="Cargando ..." height="50px" />
                    <button v-show="btnSend" class="btn-publica-step-primary" @click="savePrice()">GUARDAR Y CONTINUAR</button>
                </div>
            </div>
            <div class="col-md-6">
                <img v-show="this.$route.params.name == 'Reunion'" src="https://res.cloudinary.com/wimet/image/upload/v1514297897/fotosespacios/wimet_reunion.svg" class="img-responsive" style="width: 80%; float: right">
                <img v-show="this.$route.params.name == 'Evento'" src="https://res.cloudinary.com/wimet/image/upload/v1514297897/fotosespacios/wimet_evento.svg" class="img-responsive" style="width: 80%; float: right">
                <img v-show="this.$route.params.name == 'Produccion'" src="https://res.cloudinary.com/wimet/image/upload/v1514297897/fotosespacios/wimet_produccion.svg" class="img-responsive" style="width: 80%; float: right">
                <img v-show="this.$route.params.name == 'Retail'" src="https://res.cloudinary.com/wimet/image/upload/v1514297897/fotosespacios/wimet_retail.svg" class="img-responsive" style="width: 80%; float: right">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "actividad",
        data() {
            return {
                btnSend: true,
                espacio: this.$store.getters.getEspacio,
                price: {},
                all: true,
                indexCat: '',
                showBox: false
            }
        },
        mounted() {
            this.getIndexCategory();
        },
        watch: {
            '$route' (to, from) {
                if(to.params.name !== this.$store.getters.getEspacio.prices[this.indexCat].categoria.name) {
                    this.getIndexCategory();
                }
            }
        },
        methods: {
            getIndexCategory() {
                for(let i=0; i<this.$store.getters.getEspacio.prices.length; i++) {
                    if(this.$store.getters.getEspacio.prices[i].categoria.name == this.$route.params.name) {
                        this.indexCat = i;
                        this.showBox = true;
                        return;
                    }
                }
            },
            selectFlexibility(val){
                this.$store.getters.getEspacio.prices[this.indexCat].cancellationflexibility = val;
            },
            calMediaJornada() {
                this.$store.getters.getEspacio.prices[this.indexCat].price = (this.$store.getters.getEspacio.prices[this.indexCat].daily * 50)/100;
            },
            savePrice() {
                this.btnSend = false;
                if(this.all) {
                    let arr = this.$store.getters.getEspacio.prices;
                    this.saveFunctionPrice(arr);
                }else {
                    this.$http.put(`api/price/${this.$store.getters.getEspacio.prices[this.indexCat].id}`, this.$store.getters.getEspacio.prices[this.indexCat])
                    .then(res => {
                        if((this.indexCat+1) < this.$store.getters.getEspacio.prices.length) {
                            let index = this.$store.getters.getEspacio.prices[this.indexCat+1];
                            this.$router.push({ name: 'actividad', params: { name: index.categoria.name }});
                            this.indexCat = this.indexCat + 1;
                            this.btnSend = true;
                        }else {
                            this.$router.push({ name: "amenities"});
                        }
                    }, err => {
                        this.btnSend = true;
                        console.log(err);
                    });
                }
            },
            saveFunctionPrice(arr) {
                let item = arr.shift();
                this.$http.put(`api/price/${item.id}`, this.$store.getters.getEspacio.prices[this.indexCat])
                .then(res => {
                    if(arr.length > 1) {
                        this.saveFunctionPrice(arr);
                    }else {
                        this.getEspacio(this.$store.getters.getEspacio.id);
                    }
                }, err => {
                    this.btnSend = true;
                    console.log(err);
                });
            },
            getEspacio(id) {
                this.$http.get(`api/espacio/${id}`)
                    .then(res => {
                        this.$store.commit('setEspacio', res.body);
                        this.$router.push({ name: "amenities"});
                    }, err => {
                        this.btnSend = true;
                        $toastr.error("Ups...", "Hubo un problema al crear su espacio, vuelva a intentarlo");
                    });
            },
            back() {
                this.$router.push({ name: "basico"});
            }
        }
    }
</script>

<style lang="sass" scoped>
    .publica-price {
        width: 100%;
        display: flex;
        &__box {
            width: 50%;
            display: flex;
            align-items: baseline;
            &__input {
                width: 80px;
                margin-right: 1em;
                padding: .5em;
                border: solid 1px #dadada;
            }
        }
    }
    .publica-cacellation {
        display: flex;
        flex-direction: column;
        border: 1px solid #dadada;
        font-size: 12px;
        &__box {
            padding: 1em;
            display: flex;
            flex-direction: column;
            border-bottom: 1px solid #f8f8f8;
            cursor: pointer;
            &__title {
                color: #212121;
                font-weight: bold;
            }
            &--active {
                background-color: #f8f8f8;
            }
        }
    }

    .hover-menssage {
        position: absolute;
        right: -8em;
        padding: 1em;
        border-radius: 1px;
        border: 1px solid #dadada;
        box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.25);
    }
</style>