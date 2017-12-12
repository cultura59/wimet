<template>
    <div class="wt-m-top-3">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <h1 class="publica-titulo">Establece las condiciones</h1>
                <h1 class="publica-titulo">para {{$route.params.name}}</h1>
                <div class="publica-box">
                    <div class="publica-box__left">
                        <label class="label-publica">CAPACIDAD</label>
                    </div>
                    <div class="publica-box__rigth">
                        <input class="input-publica" type="text" placeholder="Capacidad del espacio" v-model="price.cantidad_personas">
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
                                    v-model="price.daily"
                                    @change="calMediaJornada()">
                                <label class="label-publica">por día</label>
                            </div>
                            <div class="publica-price__box">
                                <input class="publica-price__box__input" type="text" placeholder="$6000" v-model="price.price">
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
                        <input class="input-publica" type="text" placeholder="$6000" v-model="price.securitydeposit">
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
                                :class="{'publica-cacellation__box--active': price.cancellationflexibility == 'flexible'}"
                                @click="selectFlexibility('flexible')">
                                <span class="publica-cacellation__box__title">FLEXIBLE</span>
                                <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
                            </div>
                            <div
                                class="publica-cacellation__box"
                                :class="{'publica-cacellation__box--active': price.cancellationflexibility == 'moderado'}"
                                @click="selectFlexibility('moderado')">
                                <span class="publica-cacellation__box__title">MODERADA</span>
                                <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
                            </div>
                            <div
                                class="publica-cacellation__box"
                                :class="{'publica-cacellation__box--active': price.cancellationflexibility == 'estricto'}"
                                @click="selectFlexibility('estricto')">
                                <span class="publica-cacellation__box__title">ESTRICTA</span>
                                <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="publica-box">
                    <input id="all" type="checkbox" v-model="all" style="display: none;">
                    <label for="all" class="wt-publica-label">Establecer misma capacidad, precios y condiciones para todas las categorías.</label>
                </div>
                <div class="wt-space-block wt-m-top-3">
                    <button class="btn-publica-step-default">
                        <img src="https://res.cloudinary.com/wimet/image/upload/v1512746740/ic_keyboard_backspace_black_24px.svg">
                        <span>ATRÁS</span>
                    </button>
                    <img v-show="!btnSend" src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-pig_oxestq.svg" alt="Cargando ..." height="50px" />
                    <button v-show="btnSend" class="btn-publica-step-primary" @click="savePrice()">GUARDAR Y CONTINUAR</button>
                </div>
            </div>
            <div class="col-md-6">
                <img src="/img/wimet_amenities.svg" class="img-responsive">
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
                indexCat: ''
            }
        },
        mounted() {
            this.getIndexCategory();
        },
        methods: {
            getIndexCategory() {
                let arr = this.$store.getters.getEspacio.prices;
                for(let i=0; i<arr.length; i++) {
                    if(arr[i].categoria_id == this.$store.getters.getCategorySelected.id) {
                        this.price = arr[i];
                        this.indexCat = i;
                        return;
                    }
                }
            },
            selectFlexibility(val){
                this.price.cancellationflexibility = val;
            },
            calMediaJornada() {
                this.price.price = (this.price.daily * 60)/100;
            },
            savePrice() {
                this.btnSend = false;
                if(this.all) {
                    for (let i = 0; i < this.$store.getters.getEspacio.prices.length; i++) {
                        this.$http.put(`api/price/${this.$store.getters.getEspacio.prices[i].id}`, this.price)
                        .then(res => {
                            let espacio = this.$store.getters.getEspacio;
                            espacio.prices[i] = res.body;
                            this.$store.commit('setEspacio', espacio);
                        }, err => {
                            this.btnSend = true;
                            console.log(err);
                        });
                    }
                    this.$router.push("/amenities");
                }else {
                    this.$http.put(`api/price/${this.price.id}`, this.price)
                    .then(res => {
                        let espacio = this.$store.getters.getEspacio;
                        espacio.prices[this.indexCat] = res.body;
                        this.$store.commit('setEspacio', espacio);
                        if(this.indexCat < this.$store.getters.getEspacio.prices.length) {
                            let index = this.$store.getters.getEspacio.categorias[this.indexCat+1];
                            this.$store.commit('setCategorySelected', index);
                            this.$router.push(`/actividad/${index.name}`);
                            this.btnSend = true;
                        }else {
                            this.$store.commit('setCategorySelected', {});
                            this.$router.push("/amenities");
                        }
                    }, err => {
                        this.btnSend = true;
                        console.log(err);
                    });
                }
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
        &__box {
            padding: 1em;
            display: flex;
            flex-direction: column;
            border-bottom: 1px solid #dadada;
            cursor: pointer;
            &__title {
                color: #212121;
                font-weight: bold;
            }
            &--active {
                background-color: #dadada;
            }
        }
    }
</style>