<template>
    <div class="wt-m-top-3">
        <h1 class="publica-titulo">¡Hola {{$store.getters.getUser.firstname}}!</h1>
        <h1 class="publica-titulo">Comencemos por lo esencial…</h1>
        <div v-if="estiloespacio.length > 0 && categories.length > 0" class="row">
            <div class="col-xs-12 col-md-6">
                <div class="row wt-m-top-3">
                    <div class="col-xs-12 col-md-3">
                        <label class="label-publica">TIPO DE ESPACIO</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <select v-model="espacio.estilos" class="input-publica">
                            <option value="">Seleccione actividad</option>
                            <option v-for="characteristic in estiloespacio" :value="characteristic.id">{{characteristic.nombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row wt-m-top-3">
                    <div class="col-xs-12 col-md-3">
                        <label class="label-publica">TIPO(S) DE USO PERMITIDO(S)</label>
                    </div>
                    <div class="col-xs-12 col-md-9 container-categories">
                        <div
                            v-for="cat in $store.getters.getCategories"
                            class="container-categories__box"
                            :class="{'container-categories__box--active': inArray(cat.id, espacio.categorias)}"
                            @click="selectCategory(cat)">
                            <img :src="cat.icon" :alt="cat.name">
                            <span>{{cat.name}}</span>
                        </div>
                    </div>
                </div>
                <div class="row wt-m-top-3">
                    <div class="col-xs-12 col-md-3">
                        <label class="label-publica">DIRECCIÓN</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <vue-google-autocomplete
                            ref="address"
                            id="publica-map"
                            classname="input-publica"
                            placeholder="El Salvador 5218, Buenos Aires"
                            v-on:placechanged="getAddressData">
                        </vue-google-autocomplete>
                        <template v-if="!showMapa">
                            <div class="preview-mapa wt-m-top-3"></div>
                        </template>
                        <template v-if="showMapa">
                            <mapa-publica
                                class="wt-m-top-3"
                                name="publica-mapa"
                                icon="location"
                                zoom="8"
                                gwith="100%"
                                gheight="145px"
                                :gespacios="address"
                            >
                            </mapa-publica>
                        </template>
                    </div>
                </div>
                <div class="row wt-m-top-3">
                    <div class="col-xs-12 col-md-3">
                        <label class="label-publica">TELÉLFONO</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <input class="input-publica" type="text" placeholder="+54 11 5555-5555">
                    </div>
                </div>
                <div class="wt-space-block wt-m-top-3">
                    <button class="btn-publica-step-default">
                        <img src="https://res.cloudinary.com/wimet/image/upload/v1512746740/ic_keyboard_backspace_black_24px.svg">
                        <span>ATRÁS</span>
                    </button>
                    <img v-show="!btnSend" src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-pig_oxestq.svg" alt="Cargando ..." height="50px" />
                    <button v-show="btnSend" class="btn-publica-step-primary" @click="saveEspacio()">GUARDAR Y CONTINUAR</button>
                </div>
            </div>
            <div class="col-md-6">
                <img src="https://res.cloudinary.com/wimet/image/upload/v1512791614/wimet_basico.svg" class="img-responsive">
            </div>
        </div>
    </div>
</template>
<script>
    import VueGoogleAutocomplete from 'vue-google-autocomplete';
    import MapaPublica from '../GoogleMaps.vue';
    export default {
        name: 'basico',
        components: {
            VueGoogleAutocomplete,
            'mapa-publica': MapaPublica
        },
        data() {
            return {
                espacio: (this.$store.getters.getEspacio.id != undefined)?this.$store.getters.getEspacio:{categorias: []},
                estiloespacio: [],
                categories: [],
                showMapa: false,
                address: [],
                btnSend: true
            }
        },
        mounted() {
            this.getEstiloespacio();
            this.getCategories();
        },
        methods: {
            getEstiloespacio() {
                this.$http.get('api/estiloespacio')
                .then(res => {
                    this.estiloespacio = res.body;
                }, err => {
                    console.log(err);
                });
            },
            getCategories() {
                this.$http.get('api/categoria')
                .then(res => {
                    this.categories = res.body;
                    this.$store.commit('setCategories', res.body);
                }, err => {
                    console.log(err);
                });
            },
            selectCategory(cat) {
                let index = this.espacio.categorias.indexOf(cat.id);
                if(index > -1) {
                    this.espacio.categorias.splice(index, 1);
                }else {
                    this.espacio.categorias.push(cat.id);
                }
            },
            inArray(item, arr) {
                let index = arr.indexOf(item);
                if(index > -1) {
                    return true;
                }else {
                    return false;
                }
            },
            getAddressData(addressData, placeResultData, id) {
                this.address.push({
                    lat: addressData.latitude,
                    long: addressData.longitude
                });
                this.espacio.lat = addressData.latitude;
                this.espacio.long = addressData.longitude;
                this.espacio.country = addressData.country;
                this.espacio.city = addressData.administrative_area_level_1;
                this.espacio.adress = `${addressData.route} ${addressData.street_number}`;
                this.showMapa = true;
            },
            saveEspacio() {
                this.btnSend = false;
                this.espacio.name = `wiemt-${Date.now()}`;
                this.espacio.description = '';
                this.espacio.estilos = [this.espacio.estilos];
                this.espacio.step = 1;
                this.espacio.user_id = this.$store.getters.getUser.id;
                this.$http.post('api/espacio', this.espacio)
                .then(res => {
                    this.getEspacio(res.body.id);
                }, err => {
                    this.btnSend = true;
                    console.log(err);
                });
            },
            getEspacio(id) {
                this.$http.get(`api/espacio/${id}`)
                .then(res => {
                    this.$store.commit('setEspacio', res.body);
                    setInterval(() => {
                        this.$store.commit('setCategorySelected', res.body.categorias[0]);
                        this.$router.push(`/actividad/${res.body.categorias[0].name}`);
                    }, 3000);
                }, err => {
                    this.btnSend = true;
                    $toastr.error("Ups...", "Hubo un problema al crear su espacio, vuelva a intentarlo");
                });
            }
        }
    }
</script>
<style lang="sass" scoped>
    .container-categories {
        display: flex;
        justify-content: center;
        align-items: center;
        &__box {
            transition: none;
            display: flex;
            min-height: 80px;
            width: 25%;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: solid 1px #dadada;
            padding: 1em;
            cursor: pointer;
            font-size: 10px;
            color: #212121;
            &--active {
                background-color: #f8f8f8;
            }
        }
    }
    .preview-mapa {
        width: 100%;
        height: 145px;
        border: solid 1px #dadada;
    }
</style>