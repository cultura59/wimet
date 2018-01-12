<template>
    <div class="wt-m-top-5 wt-m-bot-5">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <h1 class="publica-titulo">A un paso de convertirte</h1>
                <h1 class="publica-titulo">en anfitrión</h1>
                <div class="row wt-m-top-3">
                    <div class="col-xs-12 col-md-3">
                        <label class="label-publica">TÍTULO</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <input
                            class="input-publica"
                            type="text"
                            placeholder="Ej.: Galería artística y cultural en Palermo"
                            v-model="$store.getters.getEspacio.name">
                    </div>
                </div>
                <div class="row wt-m-top-3">
                    <div class="col-xs-12 col-md-3">
                        <label class="label-publica">DESCRIPCIÓN</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <textarea rows="10" class="input-publica" v-model="$store.getters.getEspacio.description" :placeholder="descripcionHolder"></textarea>
                    </div>
                </div>
                <div class="row wt-m-top-3">
                    <div class="col-xs-12 col-md-3">
                        <label class="label-publica">REGLAMENTO INTERNO</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <textarea rows="10" class="input-publica" v-model="$store.getters.getEspacio.rule" :placeholder="reglamentoHolder""></textarea>
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
                <img src="https://res.cloudinary.com/wimet/image/upload/v1512841394/wimet_descripcion.svg" class="img-responsive">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "descripcion",
        data() {
            return {
                btnSend: true,
                descripcionHolder: `Trata de describir tu espacio tal como te gustaría leer una descripción de un lugar que no conoces.
- Características principales
- Qué usos están permitidos
- Que áreas de tu espacio pueden utilizar
- Que ambientes tienen restricción de acceso
- Variaciones de precio de acuerdo a día de la semana / temporada
- Precios especiales por reservas de varias.`,
                reglamentoHolder: `- Los horarios acordados deben ser respetados.
- No se permiten menores de 18 años.
- Está prohibida la venta de alcohol
- No se permiten fiestas o música fuerte.
- No pueden ingresar Caterings externos.
- Solo está permitido fumar en el exterior.
- Ocúpese de respetar y de no dañar el espacio, el mobiliario y el equipamiento. Cualquier pérdida o daño podría suponer una deducción sobre el depósito de seguridad.
- Avisar al anfitrión si surgen cambios de acuerdo a lo pactado.`
            }
        },
        methods: {
            updateEspacio() {
                if(this.$store.getters.getEspacio.description == undefined || this.$store.getters.getEspacio.description == "") {
                    this.$toastr.error("Debe ingresar una descripción de su espacio", "Descripción requerida");
                    return;
                }
                if(this.$store.getters.getEspacio.rule == undefined || this.$store.getters.getEspacio.rule == "") {
                    this.$toastr.error("Debe ingresar las reglas de su espacio", "Reglas requeridas");
                    return;
                }
                this.btnSend = false;
                this.$store.getters.getEspacio.step = 6;
                this.$http.put(`api/espacio/${this.$store.getters.getEspacio.id}`, this.$store.getters.getEspacio)
                .then(res => {
                    this.getEspacio(this.$store.getters.getEspacio.id);
                }, err => {
                    this.btnSend = true;
                    this.$toastr.error(err, 'Ups hubo un error');
                });
            },
            getEspacio(id) {
                this.$http.get(`api/espacio/${id}`)
                .then(res => {
                    this.$store.commit('setEspacio', res.body);
                    this.$router.push({ name: "resumen"});
                }, err => {
                    this.btnSend = true;
                    this.$toastr.error("Ups...", "Hubo un problema al modificar su espacio, vuelva a intentarlo");
                });
            },
            back() {
                this.$router.push({ name: "foto"});
            }
        }
    }
</script>

<style scoped>

</style>