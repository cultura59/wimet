<template>
    <div>
        <div class="container-filters">
            <div class="dropdown">
                <span class="dropbtn" @click="btnCategoria = !btnCategoria">{{selectUbicacion}} <img src="/img/ic_keyboard_arrow_down_black_24px.svg"></span>
                <div class="dropdown-content" v-if="btnCategoria">
                    <a href="#" @click="changeUbicacion($event, 'CABA')">CABA</a>
                    <a href="#" @click="changeUbicacion($event, 'Buenos Aires')">Gran Buenos Aires</a>
                </div>
            </div>
            <div class="dropdown">
                <span class="dropbtn" @click="btnAsistente = !btnAsistente">{{showCategoria(categoriaId)}} <img src="/img/ic_keyboard_arrow_down_black_24px.svg"></span>
                <div class="dropdown-content" v-if="btnAsistente">
                    <a
                        href="#"
                        v-for="categoria in categorias"
                        :key="categoria.id"
                        @click="changeCategoria($event, categoria.id)">{{categoria.name}}
                    </a>
                </div>
            </div>
            <div class="dropdown-modal">
                <span class="dropbtn" @click="btnPrice = !btnPrice">PRECIO/HORA <img src="/img/ic_keyboard_arrow_down_black_24px.svg"></span>
                <div class="dropdown-modal-content__range" v-if="btnPrice">
                    <p class="text-center">${{priceFrom}} - ${{priceTo}}</p>
                    <vue-slider
                        @callback="callbackbPrice"
                        :value="[priceFrom, priceTo]"
                        :min="0"
                        :max="20000"
                        :width="'100%'"
                        :tooltip="false"
                        :event-type="auto"
                        :process-style="processStyle"
                        :slider-style="processStyle"
                        :real-time="true">
                    </vue-slider>
                    <div class="dropdown-content__range__acciones">
                        <span class="cursor-pointer" @click="btnPrice = !btnPrice">CANCELAR</span>
                        <button @click="changePrice($event)" class="aceptar">APLICAR</button>
                    </div>
                </div>
            </div>
            <div class="dropdown-modal">
                <span class="dropbtn" @click="btnQuanty = !btnQuanty">ASISTENTES <img src="/img/ic_keyboard_arrow_down_black_24px.svg"></span>
                <div class="dropdown-modal-content__range" v-if="btnQuanty">
                    <p class="text-center">{{quantyFrom}} - {{quantyTo}} asistentes</p>
                    <vue-slider
                            @callback="callbackbQuanty"
                            :value="[quantyFrom, quantyTo]"
                            :min="0"
                            :max="10000"
                            :width="'100%'"
                            :tooltip="false"
                            :event-type="auto"
                            :process-style="processStyle"
                            :slider-style="processStyle"
                            :real-time="true">
                    </vue-slider>
                    <div class="dropdown-content__range__acciones">
                        <span class="cursor-pointer" @click="btnQuanty = !btnQuanty">CANCELAR</span>
                        <button @click="changeQuanty($event)" class="aceptar">APLICAR</button>
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <span class="dropbtn">MÁS FILTROS <img src="/img/ic_keyboard_arrow_down_black_24px.svg"></span>
                <div class="dropdown-content__modal">
                </div>
            </div>
        </div>
        <div class="search-data">
            <div class="row" :class="{'box-opaco': opacacidad}">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" v-for="(espacio, key) in espacios.data" :key="espacio.id">
                    <espacio-search
                        :espacio-id="espacio.id"
                        :category-id="categoriaId">
                    </espacio-search>
                </div>
            </div>
            <div class="pagination-search">
                <a href="#" @click="prevPage($event)">&laquo;</a>
                <a href="#"
                    v-for="n in espacios.last_page"
                    :class="{active: (n==espacios.current_page)}"
                    @click="changePage($event, n)"
                >{{n}}</a>
                <a href="#" @click="prevPage($event)">&raquo;</a>
            </div>
        </div>
    </div>
</template>
<script>
    import vueSlider from 'vue-slider-component';
    export default {
        components: {
            vueSlider
        },
        data() {
            return {
                url: 'api/searchespacios?',
                categorias: [
                    {id: 1, name: 'REUNIÓN'},
                    {id: 2, name: 'EVENTO'},
                    {id: 3, name: 'PRODUCCIÓN'},
                    {id: 4, name: 'POP-UPS'}
                ],
                categoriaId: this.getParameterByName('categoria'),
                selectUbicacion: (this.getParameterByName('ubicacion') == '') ? 'Ubicación' : this.getParameterByName('ubicacion'),
                espacios: '',
                priceFrom: 100,
                priceTo: 10000,
                quantyFrom: 0,
                quantyTo: 1000,
                slideWith: '100%',
                btnCategoria: false,
                btnAsistente: false,
                btnPrice: false,
                btnQuanty: false,
                processStyle: {
                    "backgroundColor": "#fc5289"
                },
                opacacidad: false
            }
        },
        mounted() {
            this.getEspacios();
        },
        methods: {
            getEspacios() {
                if(this.getParameterByName('ubicacion') !== '') {
                    this.url += `ubicacion=${this.getParameterByName('ubicacion')}&`;
                }
                if(this.getParameterByName('categoria') !== '') {
                    this.url += `categoria=${this.getParameterByName('categoria')}&`;

                }
                if(this.getParameterByName('quanty') !== '') {
                    this.url += `quanty=${this.getParameterByName('quanty')}&`;
                }
                if(this.getParameterByName('price') !== '') {
                    this.url += `price=${this.getParameterByName('price')}`;
                }
                this.$http.get(this.url)
                .then(res => {
                   this.espacios = res.body;
                }, err => {
                    console.log(err);
                });
            },
            getParameterByName(name) {
                let url = window.location.href;
                name = name.replace(/[\[\]]/g, "\\$&");
                let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"), results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, " "));
            },
            changeUbicacion(e, value){
                e.preventDefault();
                this.opacacidad = true;
                this.btnCategoria = false;
                this.selectUbicacion = value;
                this.updateQueryStringParameter('ubicacion', value);
            },
            changeCategoria(e, value){
                e.preventDefault();
                this.opacacidad = true;
                this.btnAsistente = false;
                this.categoriaId = value;
                this.updateQueryStringParameter('categoria', value);
            },
            callbackbPrice(val) {
                this.priceFrom = val[0];
                this.priceTo = val[1];
            },
            changePrice(e){
                e.preventDefault();
                this.opacacidad = true;
                let price = `${this.priceFrom}-${this.priceTo}`;
                this.updateQueryStringParameter('price', price);
                this.btnPrice = false;
            },
            callbackbQuanty(val) {
                this.quantyFrom = val[0];
                this.quantyTo = val[1];
            },
            changeQuanty(e){
                e.preventDefault();
                this.opacacidad = true;
                let quanty = `${this.quantyFrom}-${this.quantyTo}`;
                this.updateQueryStringParameter('quanty', quanty);
                this.btnQuanty = false;
            },
            updateQueryStringParameter(param, value) {
                let re = new RegExp("[\\?&]" + param + "=([^&#]*)"), match = re.exec(this.url), delimiter, newString;
                if (match === null) {
                    // append new param
                    let hasQuestionMark = /\?/.test(this.url);
                    delimiter = hasQuestionMark ? "&" : "?";
                    this.url = this.url + delimiter + param + "=" + value;
                } else {
                    delimiter = match[0].charAt(0);
                    this.url = this.url.replace(re, delimiter + param + "=" + value);
                }
                this.$http.get(this.url)
                .then(res => {
                    this.espacios = res.body;
                    this.opacacidad = false;
                }, err => {
                    console.log(err);
                    this.opacacidad = false;
                });
            },
            showCategoria(id) {
                for(let i = 0; i < this.categorias.length; i++) {
                    if(this.categorias[i].id == id) {
                        return this.categorias[i].name;
                    }
                }
                return 'Qué estas planificando?';
            },
            prevPage(e) {
                e.preventDefault();
                this.opacacidad = true;
                this.$http.get(this.espacios.prev_page_url)
                .then(res => {
                    this.espacios = res.body;
                    this.opacacidad = false;
                }, err => {
                    console.log(err);
                    this.opacacidad = false;
                });
            },
            nextPage(e) {
                e.preventDefault();
                this.opacacidad = true;
                this.$http.get(this.espacios.next_page_url)
                    .then(res => {
                        this.espacios = res.body;
                        this.opacacidad = false;
                    }, err => {
                        console.log(err);
                        this.opacacidad = false;
                    });
            },
            changePage(e, page) {
                e.preventDefault();
                this.opacacidad = true;
                this.updateQueryStringParameter('page', page);
            }
        }
    }
</script>
<style lang="sass" scoped>
    .container-filters {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 2em;
        background-color: #ffffff;
        box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.14);
        border: solid 1px #dadada;
        &__chield {
                cursor: pointer;
                &:hover {
                    border-bottom: 2px solid #d8d8d8;
            }
        }
    }
    .search-data {
        padding: 0 2em;
    }
    .dropbtn {
        cursor: pointer;
    }
    .dropdown {
        position: relative;
        display: inline-block;
        &-content {
            position: absolute;
            min-width: 160px;border-radius: 2px;
            background-color: #ffffff;
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.25);
            margin-top: 1rem;
            z-index: 1;
            a {
                color: #545454;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                &:hover {background-color: #f1f1f1}
            }
        }
        &:hover .dropdown-content {
            display: block;
        }
        &-content__range {
            display: flex;
            padding: 1em;
            width: 18em;
            flex-direction: column;
            position: absolute;
            min-width: 160px;
            border-radius: 2px;
            background-color: #ffffff;
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.25);
            border: solid 1px #dadada;
            z-index: 1;
            &__acciones {
                display: flex;
                justify-content: space-around;
                align-items: baseline;
                margin-top: 1em;
                .aceptar {
                    border-radius: 2px;
                    background-color: #fc5289;
                    border: none;
                    color: white;
                    padding: 0.5em 1em;
                }
            }
        }
    }
    .dropdown-modal {
        position: relative;
        display: flex;
        justify-content: center;
        &-content {
            display: none;
            position: absolute;
            min-width: 160px;border-radius: 2px;
            background-color: #ffffff;
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.25);
            z-index: 1;
            a {
                color: #545454;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                &:hover {background-color: #f1f1f1}
            }
        }
        &:hover .dropdown-content {
            display: block;
        }
        &-content__range {
            display: flex;
            padding: 1em;
            width: 18em;
            flex-direction: column;
            position: absolute;
            min-width: 160px;
            border-radius: 2px;
            background-color: #ffffff;
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.25);
            border: solid 1px #dadada;
            z-index: 1;
            margin-top: 3em;
            &__acciones {
                display: flex;
                justify-content: space-around;
                align-items: baseline;
                margin-top: 1em;
                .aceptar {
                    border-radius: 2px;
                    background-color: #fc5289;
                    border: none;
                    color: white;
                    padding: 0.5em 1em;
                }
            }
        }
    }
    .box-opaco {opacity: 0.4;}
    .pagination-search {
        display: flex;
        padding-left: 0;
        margin: 22px 0;
        border-radius: 4px;
        margin-top: 1em;
        justify-content: center;
        a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            &:hover:not(.active) {background-color: #ddd;}
        }
        .active {
            background-color: #fc5289;
            color: white;
        }
    }
</style>