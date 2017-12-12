<template>
    <div class="wt-m-top-3">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <h1 class="publica-titulo">Cuéntanos con qué amenities y</h1>
                <h1 class="publica-titulo">caractéristicas cuenta el espacio</h1>
                <div class="row">
                    <div class="col-md-6">
                        <h3>ESPACIO</h3>
                        <div v-for="acc in accesos">
                            <input :id="`acceso-${acc.id}`" type="checkbox" :value="acc.id" style="display: none;" v-model="espacio.access">
                            <label :for="`acceso-${acc.id}`" class="wt-publica-label">{{acc.nombre}}</label>
                        </div>
                        <h3>EQUIPAMIENTO</h3>
                        <div v-for="equipamiento in equipamientos">
                            <input :id="`equipamiento-${equipamiento.id}`" type="checkbox" :value="equipamiento.id" style="display: none;">
                            <label :for="`equipamiento-${equipamiento.id}`" class="wt-publica-label">{{equipamiento.nombre}}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>AMENITIES</h3>
                        <div v-for="amenity in amenities">
                            <input :id="`ametiny-${amenity.id}`" type="checkbox" :value="amenity.id" style="display: none;" v-model="espacio.servicios">
                            <label :for="`ametiny-${amenity.id}`" class="wt-publica-label">{{amenity.nombre}}</label>
                        </div>
                    </div>
                </div>
                <div class="wt-space-block wt-m-top-3">
                    <button class="btn-publica-step-default">
                        <img src="https://res.cloudinary.com/wimet/image/upload/v1512746740/ic_keyboard_backspace_black_24px.svg">
                        <span>ATRÁS</span>
                    </button>
                    <img v-show="!btnSend" src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-pig_oxestq.svg" alt="Cargando ..." height="50px" />
                    <button v-show="btnSend" class="btn-publica-step-primary" @click="updateEspacio()">GUARDAR Y CONTINUAR</button>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <img src="https://res.cloudinary.com/wimet/image/upload/v1512791710/wimet_amenities.svg" class="img-responsive">
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
            this.getEquipamientos();
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
                this.$http.get('api/accessibilities')
                .then(res => {
                    this.equipamientos = res.body;
                }, err => {
                    console.log(err);
                });
            },
            getEquipamientos() {
                this.$http.get('api/servicio')
                .then(res => {
                    this.amenities = res.body;
                }, err => {
                    console.log(err);
                });
            },
            updateEspacio() {
                this.btnSend = false;
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
                        setInterval(() => {
                            this.$router.push('/disponibilidad');
                        }, 3000);
                    }, err => {
                        this.btnSend = true;
                        $toastr.error("Ups...", "Hubo un problema al modificar su espacio, vuelva a intentarlo");
                    });
            }
        }
    }
</script>

<style scoped>

</style>