<template>
    <div class="wt-m-top-3">
        <h1 v-if="$store.getters.getEspacio.step < 6" class="publica-titulo">¡Lo estás haciendo muy bien!</h1>
        <template v-if="$store.getters.getEspacio.step == 6">
            <h1 class="publica-titulo">¡Felicitaciones {{$store.getters.getUser.firstname}}!</h1>
            <p class="wt-m-top-1">Tu espacio será publicado en Wimet.co una vez aprobado por nuestro equipo.</p>
            <button class="btn-complete" @click="aprobacion()">ENVIAR PARA APROBACIÓN</button>
        </template>
        <div class="row">
            <div class="wt-m-top-2 col-xs-12 col-md-6">
                <div class="box-container">
                    <div>
                        <h3 class="box-container__title">Paso 1: Lo escencial</h3>
                        <span class="box-container_sub-title">Tipo de espacio - Dirección - Teléfono</span>
                    </div>
                    <div class="box-container__btn">
                        <router-link to="/" class="box-container__btn__edit">EDITAR</router-link>
                        <img src="/img/wimet_ic_check_24px_accent.svg">
                    </div>
                </div>
                <div class="box-container">
                    <div>
                        <h3 class="box-container__title">Paso 2: Actividades</h3>
                        <span class="box-container_sub-title">Reuniones - Eventos - Producciones</span>
                    </div>
                    <div class="box-container__btn">
                        <template v-if="$store.getters.getEspacio.step > 1">
                            <router-link :to="`/actividad/${$store.getters.getEspacio.prices[0].categoria.name}`" class="box-container__btn__edit">EDITAR</router-link>
                            <img src="/img/wimet_ic_check_24px_accent.svg">
                        </template>
                        <button v-if="$store.getters.getEspacio.step <= 1" class="btn-complete">
                            <router-link :to="`/actividad/${$store.getters.getEspacio.prices[0].categoria.name}`">COMPLETAR</router-link>
                        </button>
                    </div>
                </div>
                <div class="box-container">
                    <div>
                        <h3 class="box-container__title">Paso 3: Amenities</h3>
                        <span class="box-container_sub-title">Acceso - Amenities - Equipamiento</span>
                    </div>
                    <div class="box-container__btn">
                        <template v-if="$store.getters.getEspacio.step > 2">
                            <router-link to="/amenities" class="box-container__btn__edit">EDITAR</router-link>
                            <img src="/img/wimet_ic_check_24px_accent.svg">
                        </template>
                        <button v-if="$store.getters.getEspacio.step <= 2" class="btn-complete">
                            <router-link to="/amenities">COMPLETAR</router-link>
                        </button>
                    </div>
                </div>
                <div class="box-container">
                    <div>
                        <h3 class="box-container__title">Paso 4: Disponibilidad</h3>
                        <span class="box-container_sub-title">Días de la semana</span>
                    </div>
                    <div class="box-container__btn">
                        <template v-if="$store.getters.getEspacio.step > 3">
                            <router-link to="/disponibilidad" class="box-container__btn__edit">EDITAR</router-link>
                            <img src="/img/wimet_ic_check_24px_accent.svg">
                        </template>
                        <button v-if="$store.getters.getEspacio.step <= 3" class="btn-complete">
                            <router-link to="/disponibilidad">COMPLETAR</router-link>
                        </button>
                    </div>
                </div>
                <div class="box-container">
                    <div>
                        <h3 class="box-container__title">Paso 5: Fotos</h3>
                        <span class="box-container_sub-title">Imágenes en alta calidad</span>
                    </div>
                    <div class="box-container__btn">
                        <template v-if="$store.getters.getEspacio.step > 4">
                            <router-link to="/foto" class="box-container__btn__edit">EDITAR</router-link>
                            <img src="/img/wimet_ic_check_24px_accent.svg">
                        </template>
                        <button v-if="$store.getters.getEspacio.step <= 4" class="btn-complete">
                            <router-link to="/foto">COMPLETAR</router-link>
                        </button>
                    </div>
                </div>
                <div class="box-container">
                    <div>
                        <h3 class="box-container__title">Paso 6: Descripción</h3>
                        <span class="box-container_sub-title">Título - Descripción - Reglamento interno</span>
                    </div>
                    <div class="box-container__btn">
                        <template v-if="$store.getters.getEspacio.step > 5">
                            <router-link to="/descripcion" class="box-container__btn__edit">EDITAR</router-link>
                            <img src="/img/wimet_ic_check_24px_accent.svg">
                        </template>
                        <button v-if="$store.getters.getEspacio.step <= 5" class="btn-complete">
                            <router-link to="/descripcion">COMPLETAR</router-link>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <img src="https://res.cloudinary.com/wimet/image/upload/v1512791614/wimet_basico.svg" class="img-responsive">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "resumen",
        methods: {
            aprobacion() {
                this.$store.getters.getEspacio.step = 7;
                this.$http.put(`api/espacio/${this.$store.getters.getEspacio.id}`, this.$store.getters.getEspacio)
                .then(res => {
                    this.getEspacio(this.$store.getters.getEspacio.id);
                    this.$toastr.success("El espacio fue enviado para aprobar", 'Exito!!!');
                }, err => {
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
                    $toastr.error("Ups...", "Hubo un problema al modificar su espacio, vuelva a intentarlo");
                });
            }
        }
    }
</script>

<style lang="sass" scoped>
    .box-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: solid 1px #979797;
        margin-top: 0.5em;
        padding: 0.5em 0;
        &__title {
             color: #545454;
         }
        &__sub-title {
             font-size: 13px;
             color: #888b8d;
         }
        &__btn {
            display: flex;
            justify-content: space-between;
            height: 23px;
            &__edit {
                font-size: 12px;
                color: #ea516d;
                margin-right: 1em;
            }
            img {
                height: 23px;
            }
        }
    }
    .btn-complete {
        padding: 1em;
        border: none;
        background-color: #fc5289;
        font-size: 12px;
        color: #ffffff;
        a {
            color: #FFFFFF;
            text-decoration: none;
        }
    }
</style>