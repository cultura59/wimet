<template>
    <div>
        <div class="container-mis-espacios">
            <span class="container-mis-espacios__title">MIS ESPACIOS</span>
            <a href="#" @click="newEspacio($event)" class="container-mis-espacios__btn">NUEVO ESPACIO</a>
        </div>
        <div class="espacios-main">
            <div v-if="$store.getters.getUser.isAdmin === 1" class="container-admin">
                <div>
                    <label>Total:</label>
                    <span>{{espacios.total}}</span>
                </div>
                <div>
                    <label>Estado</label>
                    <select v-model="filEstado" @change="getEspacioBycheck()">
                        <option value="">Todos</option>
                        <option value="0">No publicado</option>
                        <option value="1">Publicado</option>
                    </select>
                </div>
                <div>
                    <label>Paso de publicación</label>
                    <select v-model="filStep" @change="getEspacioByStep()">
                        <option value="">Todos</option>
                        <option value="1">Datos básicos</option>
                        <option value="2">Actividades</option>
                        <option value="3">Amenities</option>
                        <option value="4">Disponibilidad</option>
                        <option value="5">Fotos</option>
                        <option value="6">Descripción</option>
                        <option value="7">Pendiente aprobación</option>
                    </select>
                </div>
            </div>
            <div>
                <div v-if="!loadingData">
                    <div
                        v-if="espacios.data.length > 0"
                        class="box-expacio"
                        v-for="espacio in espacios.data"
                    >
                        <img v-if="espacio.status == true" class="tag" src="https://res.cloudinary.com/wimet/image/upload/tag_publicado.svg">
                        <img v-if="espacio.step == 7" class="tag" src="https://res.cloudinary.com/wimet/image/upload/tag_revision.svg">
                        <img v-if="espacio.status == false && espacio.step != 7" class="tag" src="https://res.cloudinary.com/wimet/image/upload/tag_incompleto.svg">
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
                    <p v-if="espacios.data.length == 0">No posee espacios aún...</p>
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
            <div class="wt-center-around wt-m-top-3">
                <div>
                    <span v-if="espacios.prev_page_url !== null" @click="getPagination(true)" class="pointer">Atrás</span>
                </div>
                <div>
                    <span v-if="espacios.next_page_url !== null" @click="getPagination(false)" class="pointer">Siguiente</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "Espacios",
        data() {
            return {
                espacios: [],
                estado: 1,
                loadingData: true,
                filEstado: "",
                filStep: ""
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
                    this.espacios = res.body;
                    this.loadingData = false;
                }, err => {
                    this.loadingData = false;
                    this.$toastr.error(err, "Ups hubo un error!!!");
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
            },
            getPagination(val) {
                this.loadingData = true;
                let url;
                if(val) {
                    url = this.espacios.prev_page_url;
                }else {
                    url = this.espacios.next_page_url;
                }
                this.$http.get(url)
                .then(res => {
                    this.espacios = res.body;
                    this.loadingData = false;
                }, err => {
                    this.loadingData = false;
                    this.$toastr.error(err, "Ups hubo un error!!!");
                });
            },
            getEspacioBycheck() {
                if(this.filEstado == "") {
                    this.getEspacios();
                }
                this.loadingData = true;
                this.$http.get(`api/espacio?user=${this.$store.getters.getUser.id}&status=${this.filEstado}`)
                .then(res => {
                    this.espacios = res.body;
                    this.loadingData = false;
                }, err => {
                    this.loadingData = false;
                    this.$toastr.error(err, "Ups hubo un error!!!");
                });
            },
            getEspacioByStep() {
                if(this.filStep == "") {
                    this.getEspacios();
                }
                this.loadingData = true;
                this.$http.get(`api/espacio?user=${this.$store.getters.getUser.id}&step=${this.filStep}&status=0`)
                    .then(res => {
                        this.espacios = res.body;
                        this.loadingData = false;
                    }, err => {
                        this.loadingData = false;
                        this.$toastr.error(err, "Ups hubo un error!!!");
                    });
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
            font-family: Avenir;
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
            font-family: Avenir;
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
    .pointer {
        cursor: pointer;
        color: #FC5289;
    }
    .container-admin {
        display: flex;
        justify-content: space-around;
        margin-bottom: 2em;
    }
</style>