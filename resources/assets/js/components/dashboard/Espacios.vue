<template>
    <div class="espacios-main">
        <div>
            <a href="#"
               :class="(estado == 1) ? 'espacios-main__links--active' : 'espacios-main__links--default'"
               @click="changeType($event, 1)">PUBLICADOS
            </a>
            <a href="#"
               :class="(estado == 0) ? 'espacios-main__links--active' : 'espacios-main__links--default'"
               @click="changeType($event, 0)">BORRADORES
            </a>
        </div>
        <div class="container-espacios">
            <div v-if="!loadingData">
                <div
                    v-if="espacios.length > 0"
                    class="box-expacio"
                    v-for="espacio in espacios"
                >
                    <div
                        v-if="espacio.images.length > 0"
                        class="image-espacio"
                        :style="`background-image: url(https://res.cloudinary.com/wimet/image/upload/q_60/${espacio.images[0].name});background-size: cover;`">
                    </div>
                    <div
                        v-if="espacio.images.length == 0"
                        class="image-espacio"
                        style="background-image: url(https://res.cloudinary.com/wimet/image/upload/q_auto:low/wimet_inspiring_venue_startup_gqsbqg_eue0iu.jpg);background-size: cover;">
                    </div>
                    <div class="detalle-espacio">
                        <div class="detalle-espacio__title">
                            <h3>{{espacio.name}}</h3>
                            <ul class="list-inline">
                                <li v-for="categoria in espacio.categorias">{{categoria.name}}</li>
                            </ul>
                            <strong v-if="estado == 0" class="pendiente-aprobacion">Pendiente de aprobación...</strong>
                        </div>
                        <div class="wt-center-column">
                            <a :href="`/publicar/espacio/${espacio.id}`" target="_blank">
                                <button class="btn-primary-pig">
                                    {{(estado == 0)? 'FINALIZAR' : 'MODIFICAR'}}
                                </button>
                            </a>
                            <a :href="`/categoria/1/espacio/${espacio.name}`" target="_blank" class="wt-m-top-1">
                                <button class="btn-primary-transparent">
                                    {{(estado == 0)? 'VISTA PREVIA' : 'VER ESPACIO'}}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <p v-if="espacios.length == 0">No posee espacios aún...</p>
            </div>
            <div v-if="loadingData">
                <div class="white-widget grey-bg author-area">
                    <div class="auth-info row">
                        <div class="timeline-wrapper">
                            <div class="timeline-item">
                                <div class="animated-background">
                                    <div class="background-masker header-top"></div>
                                    <div class="background-masker header-left"></div>
                                    <div class="background-masker header-right"></div>
                                    <div class="background-masker header-bottom"></div>
                                    <div class="background-masker subheader-left"></div>
                                    <div class="background-masker subheader-right"></div>
                                    <div class="background-masker subheader-bottom"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                espacios: [],
                estado: 1,
                loadingData: true
            }
        },
        mounted() {
            this.getEspacios();
        },
        methods: {
            getEspacios() {
                this.loadingData = true;
                this.$http.get(`api/espacio?user=${this.$store.getters.getUser.id}&status=${this.estado}`)
                .then(res => {
                    this.espacios = res.body.data;
                    this.loadingData = false;
                }, err => {
                    console.log(err);
                });
            },
            changeType(e, estado) {
                e.preventDefault();
                this.estado = estado;
                this.getEspacios();
            }
        }
    }
</script>
<style lang="sass" scoped>
    .espacios-main {
        padding: 2em 5em;
        width: 85%;
        margin: 0 auto;
        &__links{
            padding: 1em 0 2em 0;
            display: flex;
            justify-content: space-between;
            &--default {
                opacity: 0.87;
                font-size: 16px;
                font-weight: 500;
                letter-spacing: -0.1px;
                text-align: justify;
                    margin-right: 1em;
                color: #191919;
                &:hover, &:focus {
                    transition: none;
                    text-decoration: none;
                    border-bottom: 2px solid #d17f87;
                    padding-bottom: .5em;
                }
            }
            &--active {
                opacity: 0.87;
                font-size: 16px;
                font-weight: 500;
                letter-spacing: -0.1px;
                text-align: justify;
                color: #d17f87;
                text-decoration: none;
                border-bottom: 2px solid #d17f87;
                margin-right: 1em;
                padding-bottom: .5em;
            }
        }
    }
</style>