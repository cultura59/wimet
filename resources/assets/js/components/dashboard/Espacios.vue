<template>
    <div>
        <div class="container-mis-espacios">
            <span class="container-mis-espacios__title">MIS ESPACIOS</span>
            <a href="#" @click="newEspacio($event)" class="container-mis-espacios__btn">NUEVO ESPACIO</a>
        </div>
        <div class="espacios-main">
            <div>
                <div v-if="!loadingData">
                    <div
                        v-if="espacios.length > 0"
                        class="box-expacio"
                        v-for="espacio in espacios"
                    >
                        <img v-if="espacio.status == true" class="tag" src="img/tag_publicado.svg">
                        <img v-if="espacio.step == 7" class="tag" src="img/tag_revision.svg">
                        <img v-if="espacio.status == false && espacio.step != 7" class="tag" src="img/tag_incompleto.svg">
                        <div
                            v-if="espacio.images.length > 0"
                            class="image-espacio"
                            :style="`background-image: url(${espacio.portada});background-size: cover;`">
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
                                <a v-if="espacio.status == false" href="#" @click="getEspacio($event, espacio)">
                                    <button class="espacios-main__btn">EDITAR</button>
                                </a>
                                <a :href="`/categoria/1/espacio/${espacio.staticname}`" target="_blank" class="wt-m-top-1">
                                    <button class="espacios-main__btn">VISTA PREVIA</button>
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
                this.$http.get(`api/espacio?user=${this.$store.getters.getUser.id}`)
                .then(res => {
                    this.espacios = res.body.data;
                    this.loadingData = false;
                }, err => {
                    console.log(err);
                });
            },
            getEspacio(e, espacio) {
                e.preventDefault();
                this.loadingData = true;
                this.$store.commit('setEspacio', espacio);
                location.href = '/publica/espacio#/resumen';
            },
            newEspacio(e) {
                e.preventDefault();
                this.$store.commit('setEspacio', {});
                location.href = '/publica/espacio';
            }
        }
    }
</script>
<style lang="sass" scoped>
    .container-mis-espacios {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 0 2em;
        margin-top: 4em;
        align-items: flex-end;
        &__title {
            font-family: Ubuntu;
            font-size: 16px;
            font-weight: bold;
            color: #333333;
        }
        &__btn {
            border-radius: 2px;
            background-color: #fc5289;
            border: none;
            color: #fff;
            padding: .5em 2em;
            text-decoration: none;
        }
    }
    .espacios-main {
        margin-top: 2em;
        padding: 3em 2em;
        background-color: #ffffff;
        box-shadow: 0 0 68px 0 rgba(0, 0, 0, 0.1);
        .tag {
            width: 90px;
            position: absolute;
            top: 1em;
            left: -1em;
        }
        h3 {
            opacity: 0.87;
            font-family: NotoSerif;
            font-size: 16px;
            font-weight: bold;
            font-style: italic;
            letter-spacing: -0.1px;
            text-align: justify;
            color: #212121;
        }
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
        &__btn {
            font-family: Ubuntu;
            font-size: 12px;
            width: 140px;
            padding: 1em;
            text-align: center;
            color: #333333;
            border-radius: 1px;
            border: none;
            background-color: #ffffff;
            box-shadow: 0 2px 14px 0 rgba(0, 0, 0, 0.1);
        }
    }
</style>