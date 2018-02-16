<template>
    <div class="width-full">
        <div class="section-main__chield-1">
            <div class="container-filters">
                <div class="dropdown">
                    <span class="dropbtn wt-mayuscula" @click="setDropdown('btnCategoria')">{{selectUbicacion}} <img src="/img/ic_keyboard_arrow_down_black_24px.svg"></span>
                    <div class="dropdown-content" v-if="selectDropdown == 'btnCategoria'">
                        <a href="#" @click="changeUbicacion($event, 'CABA')">Ciudad de Buenos Aires</a>
                        <a href="#" @click="changeUbicacion($event, 'Buenos Aires')">Gran Buenos Aires</a>
                        <a href="#" @click="changeUbicacion($event, 'Región Metropolitana')">Santiago de Chile</a>
                    </div>
                </div>
                <div class="dropdown">
                    <span class="dropbtn wt-mayuscula" @click="setDropdown('btnAsistente')">{{showCategoria(categoriaId)}} <img src="/img/ic_keyboard_arrow_down_black_24px.svg"></span>
                    <div class="dropdown-content" v-if="selectDropdown == 'btnAsistente'">
                        <a
                            href="#"
                            class="wt-mayuscula"
                            v-for="categoria in categorias"
                            :key="categoria.id"
                            @click="changeCategoria($event, categoria.id)">{{categoria.name}}
                        </a>
                    </div>
                </div>
                <div class="dropdown-modal">
                    <span class="dropbtn" @click="setDropdown('btnPrice')">PRECIO<img src="/img/ic_keyboard_arrow_down_black_24px.svg"></span>
                    <div class="dropdown-modal-content__range" v-if="selectDropdown == 'btnPrice'">
                        <p class="text-center" v-if="">${{priceFrom}} - ${{priceTo}}+</p>
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
                            <span class="cursor-pointer" @click="selectDropdown = ''">CANCELAR</span>
                            <button @click="changePrice($event)" class="aceptar">APLICAR</button>
                        </div>
                    </div>
                </div>
                <div class="dropdown-modal">
                    <span class="dropbtn" @click="setDropdown('btnQuanty')">ASISTENTES <img src="/img/ic_keyboard_arrow_down_black_24px.svg"></span>
                    <div class="dropdown-modal-content__range" v-if="selectDropdown == 'btnQuanty'">
                        <p class="text-center">{{quantyFrom}} - {{quantyTo}}+ asistentes</p>
                        <vue-slider
                            @callback="callbackbQuanty"
                            :value="[quantyFrom, quantyTo]"
                            :min="0"
                            :max="100"
                            :width="'100%'"
                            :tooltip="false"
                            :event-type="auto"
                            :process-style="processStyle"
                            :slider-style="processStyle"
                            :real-time="true">
                        </vue-slider>
                        <div class="dropdown-content__range__acciones">
                            <span class="cursor-pointer" @click="selectDropdown = ''">CANCELAR</span>
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
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-4" v-for="(espacio, key) in espacios.data" :key="espacio.id">
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
            <div class="btn-filtros" @click="modalFilter = !modalFilter">
                <span>Filtros</span>
                <i class="material-icons">filter_list</i>
            </div>
            <div v-if="modalFilter" class="modal-filtros">
                <!-- Modal content -->
                <div class="modal-filtros__content">
                    <span class="close" @click="modalFilter = !modalFilter">&times;</span>
                    <div class="container-select">
                        <label>Seleccione ubicación</label>
                        <select v-model="selectUbicacion" class="select-filtro">
                            <option value="Ubicación">Ubicación</option>
                            <option value="CABA">CABA</option>
                            <option value="Buenos Aires">Gran Buenos Aires</option>
                        </select>
                    </div>
                    <div class="container-select">
                        <label>Seleccione tipo actividad</label>
                        <select v-model="categoriaId" class="select-filtro">
                            <option v-for="categoria in categorias" :value="categoria.id">{{categoria.name}}</option>
                        </select>
                    </div>
                    <div class="container-select">
                        <label>Seleccione rango de precio</label>
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
                        <p class="text-center">${{priceFrom}} - ${{priceTo}}</p>
                    </div>
                    <div class="container-select">
                        <label>Seleccione rango de asistentes</label>
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
                        <p class="text-center">{{quantyFrom}} - {{quantyTo}} asistentes</p>
                    </div>
                    <div class="container-select">
                        <button class="btn-buscar-filtros" @click="buscarEspacio()">Buscar espacios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-main__chield-2">
            <template v-if="showMap">
                <google-maps
                    name="search-filters"
                    icon="location"
                    zoom="12"
                    gwith="100%"
                    gheight="100%"
                    :gespacios="espacios.data"
                >
                </google-maps>
            </template>
            <template v-if="!showMap">
                <div class="preloading-map"></div>
            </template>
        </div>
    </div>
</template>
<script>
    import vueSlider from 'vue-slider-component';
    import GoogleMaps from '../GoogleMaps.vue';
    export default {
        components: {
            vueSlider,
            'google-maps': GoogleMaps
        },
        data() {
            return {
                url: 'api/searchespacios?',
                categoriaId: this.getParameterByName('categoria'),
                selectUbicacion: (this.getParameterByName('ubicacion') == '') ? 'ubicacion' : this.getParameterByName('ubicacion'),
                espacios: [],
                categorias: [],
                priceFrom: 0,
                priceTo: 20000,
                quantyFrom: 0,
                quantyTo: 100,
                slideWith: '100%',
                btnCategoria: false,
                btnAsistente: false,
                btnPrice: false,
                btnQuanty: false,
                processStyle: {
                    "backgroundColor": "#fc5289"
                },
                opacacidad: false,
                modalFilter: false,
                showMap: false,
                selectDropdown: ''
            }
        },
        mounted() {
            this.getEspacios();
            this.getCategories();
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
                   this.showMap = true;
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
                this.selectDropdown = '';
                this.selectUbicacion = value;
                this.updateQueryStringParameter('ubicacion', value);
            },
            changeCategoria(e, value){
                e.preventDefault();
                this.opacacidad = true;
                this.selectDropdown = "";
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
                this.selectDropdown = "";
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
                this.selectDropdown = "";
            },
            updateQueryStringParameter(param, value) {
                this.showMap = false;
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
                    this.showMap = true;
                }, err => {
                    console.log(err);
                    this.opacacidad = false;
                    this.showMap = true;
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
                this.showMap = false;
                this.opacacidad = true;
                this.$http.get(this.espacios.prev_page_url)
                .then(res => {
                    this.espacios = res.body;
                    this.opacacidad = false;
                    this.showMap = true;
                }, err => {
                    console.log(err);
                    this.opacacidad = false;
                    this.showMap = true;
                });
            },
            nextPage(e) {
                e.preventDefault();
                this.showMap = false;
                this.opacacidad = true;
                this.$http.get(this.espacios.next_page_url)
                    .then(res => {
                        this.espacios = res.body;
                        this.opacacidad = false;
                        this.showMap = true;
                    }, err => {
                        console.log(err);
                        this.opacacidad = false;
                        this.showMap = true;
                    });
            },
            changePage(e, page) {
                e.preventDefault();
                this.opacacidad = true;
                this.updateQueryStringParameter('page', page);
            },
            buscarEspacio() {
                this.opacacidad = true;
                this.showMap = false;
                let price = `${this.priceFrom}-${this.priceTo}`;
                let quanty = `${this.quantyFrom}-${this.quantyTo}`;
                this.url = `api/searchespacios?ubicacion=${this.selectUbicacion}&categoria=${this.categoriaId}&price=${price}&quanty=${quanty}`;
                this.$http.get(this.url)
                .then(res => {
                    this.espacios = res.body;
                    this.opacacidad = false;
                    this.modalFilter = false;
                    this.showMap = true;
                }, err => {
                    console.log(err);
                    this.opacacidad = false;
                    this.showMap = true;
                });
            },
            setDropdown(val) {
                this.selectDropdown = val;
            },
            getCategories() {
                this.$http.get(`/api/categoria`)
                .then(res => {
                    this.categorias = res.body;
                }, err => {
                    console.log(err);
                });
            }
        }
    }
</script>
<style lang="sass" scoped>
    .width-full {
        width: 100%;
    }
    .preloading-map {
        width: 100%;
        height: 650px;
        background: linear-gradient(270deg, #f8f8f8, #666666);
        background-size: 400% 400%;
        -webkit-animation: AnimationName 1s ease infinite;
        -moz-animation: AnimationName 1s ease infinite;
        animation: AnimationName 1s ease infinite;

        @-webkit-keyframes AnimationName {
            0%{background-position:18% 0%}
            50%{background-position:83% 100%}
            100%{background-position:18% 0%}
        }
        @-moz-keyframes AnimationName {
            0%{background-position:18% 0%}
            50%{background-position:83% 100%}
            100%{background-position:18% 0%}
        }
        @keyframes AnimationName {
            0%{background-position:18% 0%}
            50%{background-position:83% 100%}
            100%{background-position:18% 0%}
        }

    }
    .container-filters {
        @media (max-width: 767px) {
            display: none;
        }
        @media (min-width: 768px) {
            display: flex;
        }
        justify-content: space-between;
        align-items: center;
        padding: 1em 2em;
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
            margin-top: 1.2rem;
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
    .btn-filtros {
        @media (max-width: 767px) {
            display: flex;
        }
            @media (min-width: 768px) {
            display: none;
        }
        left: 0px !important;
        right: 0px !important;
        bottom: 3em;
        position: fixed !important;
        opacity: 1 !important;
        text-align: center !important;
        color: #fff;
        background: #fc5289;
        border-radius: 80px !important;
        margin: 0 8em;
        padding: .5em 0;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    .modal-filtros {
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
        &__content {
            background-color: #fefefe;
            margin: 20% auto;
            padding: 1em;
            border: 1px solid #888;
            width: 90%;
            .container-select {
                display: flex;
                flex-direction: column;
                margin-top: 2em;
                .select-filtro {
                    padding: 1em;
                    border: 1px solid #dadada;
                    width: 100%;
                }
                .btn-buscar-filtros {
                    color: #fff;
                    background: #fc5289;
                    border: none;
                    padding: 0.5em;
                }
            }
        }
    }
    .ico-box {
        width: 1em;
    }
</style>