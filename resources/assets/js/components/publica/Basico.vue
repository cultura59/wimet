<template>
    <div class="wt-m-top-5">
        <h1 class="publica-titulo">¡Hola {{$store.getters.getUser.firstname}}!</h1>
        <h1 class="publica-titulo">Comencemos por lo esencial…</h1>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label>TIPO DE ESPACIO</label>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <select v-model="characteristicSelected">
                            <option value="">Seleccione actividad</option>
                            <option v-for="characteristic in characteristics">{{characteristic.nombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label class="col-xs-12 col-md-6">TIPO(S) DE USO PERMITIDO(S)</label>
                    <div class="col-xs-12 col-md-6 container-categories">
                        <div
                            v-for="cat in categories"
                            class="container-categories__box"
                            :class="{'container-categories__box--active': inArray(cat, categorySelect)}"
                            @click="selectCategory(cat)">
                            <img :src="cat.icon" :alt="cat.name">
                            <span>{{cat.name}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-xs-12 col-md-6">DIRECCIÓN</label>
                    <div class="col-xs-12 col-md-6">
                        <vue-google-autocomplete
                                ref="address"
                                id="map"
                                classname="form-control"
                                placeholder="El Salvador 5218, Buenos Aires"
                                v-on:placechanged="getAddressData"
                        >
                        </vue-google-autocomplete>
                        <div></div>
                    </div>
                </div>
                <div>
                <label>TELÉLFONO</label>
                <input type="text" placeholder="+54 11 5555-5555">
            </div>
            </div>
            <div class="col-md-6"></div>
        </div>
    </div>
</template>
<script>
    import VueGoogleAutocomplete from 'vue-google-autocomplete'
    export default {
        components: { VueGoogleAutocomplete },
        data() {
            return {
                characteristics: [],
                characteristicSelected: '',
                categories: [],
                categorySelect: [],
                address: ''
            }
        },
        mounted() {
            this.$refs.address.focus();
            this.getCharacteristics();
            this.getCategories();
        },
        methods: {
            getCharacteristics() {
                this.$http.get('api/caracteristica')
                .then(res => {
                    this.characteristics = res.body;
                }, err => {
                    console.log(err);
                });
            },
            getCategories() {
                this.$http.get('api/categoria')
                .then(res => {
                    this.categories = res.body;
                }, err => {
                    console.log(err);
                });
            },
            selectCategory(cat) {
                let index = this.categorySelect.indexOf(cat);
                if(index > -1) {
                    this.categorySelect.splice(index, 1);
                }else {
                    this.categorySelect.push(cat);
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
                this.address = addressData;
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
            min-width: 80px;
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
</style>