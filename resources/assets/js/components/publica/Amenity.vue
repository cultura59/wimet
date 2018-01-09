<template>
    <div class="wt-m-top-5">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <h1 class="publica-titulo">Cuéntanos con qué amenities y</h1>
                <h1 class="publica-titulo">caractéristicas cuenta el espacio</h1>
                <div class="row wt-m-top-3">
                    <div class="col-md-6">
                        <h5>ESPACIO</h5>
                        <div v-for="acc in accesos">
                            <input :id="`acceso-${acc.id}`" type="checkbox" :value="acc" style="display: none;" v-model="espacio.access">
                            <label :for="`acceso-${acc.id}`" class="wt-publica-label">
                                <img :src="acc.icon" :alt="acc.nombre">
                                {{acc.nombre}}
                            </label>
                        </div>
                        <h5>EQUIPAMIENTO</h5>
                        <div v-for="equipamiento in amenities">
                            <input
                                v-if="equipamiento.tipo == 'equipamiento'"
                                :id="`ametiny-${equipamiento.id}`"
                                type="checkbox"
                                :value="equipamiento"
                                style="display: none;"
                                v-model="espacio.servicios">
                            <label
                                v-if="equipamiento.tipo == 'equipamiento'"
                                :for="`ametiny-${equipamiento.id}`"
                                class="wt-publica-label">
                                <img :src="equipamiento.icon" :alt="equipamiento.nombre">
                                {{equipamiento.nombre}}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>AMENITIES</h5>
                        <div v-for="amenity in amenities">
                            <input
                                v-if="amenity.tipo == 'amenities'"
                                :id="`ametiny-${amenity.id}`"
                                type="checkbox"
                                :value="amenity"
                                style="display: none;"
                                v-model="espacio.servicios">
                            <label
                                v-if="amenity.tipo == 'amenities'"
                                :for="`ametiny-${amenity.id}`"
                                class="wt-publica-label">
                                <img :src="amenity.icon" :alt="amenity.nombre">
                                {{amenity.nombre}}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="wt-space-block wt-m-top-3">
                    <button class="btn-publica-step-default" @click="back()">
                        <img src="https://res.cloudinary.com/wimet/image/upload/v1512746740/ic_keyboard_backspace_black_24px.svg">
                        <span>ATRÁS</span>
                    </button>
                    <img v-show="!btnSend" src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-pig_oxestq.svg" alt="Cargando ..." height="50px" />
                    <button v-show="btnSend" class="btn-publica-step-primary" @click="updateEspacio()">GUARDAR Y CONTINUAR</button>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <img src="https://res.cloudinary.com/wimet/image/upload/v1512791710/wimet_amenities.svg" class="img-responsive" style="width: 80%; float: right">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "amenity",
        data() {
            return {
                btnSend: true,
                accesos: [],
                amenities: [],
                equipamientos: [],
                espacio: this.$store.getters.getEspacio
            }
        },
        mounted() {
            this.getAccesos();
            this.getAmenities();
        },
        methods: {
            getAccesos() {
                this.$http.get('api/access')
                .then(res => {
                    this.accesos = res.body;
                }, err => {
                    console.log(err);
                });
            },
            getAmenities() {
                this.$http.get('api/servicio')
                .then(res => {
                    this.amenities = res.body;
                }, err => {
                    console.log(err);
                });
            },
            updateEspacio() {
                if(this.espacio.access.length === 0) {
                    this.$toastr.error("Debe seleccionar al menos un acceso", "Accesos requeridos");
                    return;
                }
                if(this.espacio.servicios.length === 0) {
                    this.$toastr.error("Debe seleccionar al menos un amenitie", "Amenities requeridos");
                    return;
                }
                this.btnSend = false;
                this.espacio.step = 4;
                this.$http.put(`api/espacio/${this.espacio.id}`, this.espacio)
                .then(res => {
                    this.getEspacio(res.body.id);
                }, err => {
                    this.btnSend = true;
                });
            },
            getEspacio(id) {
                this.$http.get(`api/espacio/${id}`)
                    .then(res => {
                        this.$store.commit('setEspacio', res.body);
                        this.$router.push({ name: "disponibilidad"});
                    }, err => {
                        this.btnSend = true;
                        this.$toastr.error("Ups...", "Hubo un problema al modificar su espacio, vuelva a intentarlo");
                    });
            },
            back() {
                let index = this.$store.getters.getEspacio.prices[0];
                this.$router.push({ name: 'actividad', params: { name: index.categoria.name }});
            }
        }
    }
</script>

<style scoped>
    h5  {color: #333}
</style>