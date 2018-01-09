<template>
    <div class="wt-m-top-3">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <h1 class="publica-titulo">{{$store.getters.getUser.firstname}} es hora de elegir</h1>
                <h1 class="publica-titulo">tus mejores fotos</h1>
                <form v-show="$store.getters.getEspacio.portada == '' || $store.getters.getEspacio.portada == null" class="wt-m-top-3">
                    <input type="file" id="box-images" style="display: none;" name="portada">
                    <label id="fake-input" for="box-images" class="box-images">
                        <img class="box-images__image" src="https://res.cloudinary.com/wimet/image/upload/v1512822338/icon-nube.svg">
                        <span class="box-images__text">haga clic para cargar o arrastra tu foto de portada aquí</span>
                    </label>
                </form>
                <div v-show="$store.getters.getEspacio.portada !== '' && $store.getters.getEspacio.portada !== null" class="row wt-m-top-3">
                    <div class="col-md-12">
                        <div class="img-box-preview-large" :style="imgPortada">
                            <img src="https://res.cloudinary.com/wimet/image/upload/icons/icon_remove_img.svg" class="btn-remove-img" @click="deletePortada()">
                        </div>
                    </div>
                    <div v-for="n in 9" class="col-md-4 wt-m-top-3">
                        <template v-if="!findeImage(n)">
                            <div class="img-box-preview">
                                <input type="file" :id="`img_${n}`" style="display: none" @change="saveImage(n)">
                                <label :for="`img_${n}`"><img src="https://res.cloudinary.com/wimet/image/upload/v1515007800/icons/icon_add_img.svg" class="btn-add-img"></label>
                                <span>{{n}}</span>
                            </div>
                        </template>
                        <template v-if="findeImage(n)">
                            <div class="img-box-preview wt-m-top-1" :style="`position: relative; background-size: cover; background-image: url(${returnImage(n)})`">
                                <img src="https://res.cloudinary.com/wimet/image/upload/icons/icon_remove_img.svg" class="btn-remove-img" @click="deleteImagen(n)">
                            </div>
                        </template>
                    </div>
                </div>
                <div class="wt-space-block wt-m-top-3" @click="back()">
                    <button class="btn-publica-step-default">
                        <img src="https://res.cloudinary.com/wimet/image/upload/v1512746740/ic_keyboard_backspace_black_24px.svg">
                        <span>ATRÁS</span>
                    </button>
                    <button class="btn-publica-step-primary" @click="saveEspacio()">GUARDAR Y CONTINUAR</button>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <img src="https://res.cloudinary.com/wimet/image/upload/v1512821482/wimet_fotos.svg" class="img-responsive" style="width: 80%; float: right">
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "foto",
        data() {
            return {
                imgPortada: {}
            }
        },
        mounted(){
            this.init();
        },
        created() {
            if(this.$store.getters.getEspacio.portada !== '' || this.$store.getters.getEspacio.portada !== undefined)
            {
                this.imgPortada = {
                    'background-image': `url(${this.$store.getters.getEspacio.portada})`,
                    'background-size': 'cover'
                }
            }
        },
        methods: {
            init() {
                let target = document.getElementById("fake-input");
                let formData = new FormData();
                // Action dragover
                target.addEventListener("dragover", (event) => {
                    event.preventDefault();
                }, false);
                // Action dragdrop
                target.addEventListener("drop", (event) => {
                    event.preventDefault();
                    let file = event.dataTransfer.files[0];
                    //Check the file type
                    if (!file.type.match('image.*')) {
                        this.$toastr.error(`El archivo debe ser una imagen`, 'Ups hubo un error');
                        return;
                    }
                    //Check the file type
                    if (file.size >= 2000000) {
                        this.$toastr.error(`El archivo debe pesar menos de 2MB`, 'Ups hubo un error');
                        return;
                    }
                    // Add the file to the request.
                    formData.append('type', 'file');
                    formData.append('portada', file);
                    this.savePortada(formData);
                }, false);
            },
            savePortada(form) {
                this.$toastr.info('Aguarde unos segundos', 'Cargando imagen...');
                fetch(`/api/saveportada/${this.$store.getters.getEspacio.id}`, {
                    method: 'post',
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${this.$auth.getToken()}`
                    },
                    body: form
                })
                .then((res) => {
                    this.$toastr.success(`El archivo fue cargado correctamente`, 'Portada cargada');
                    this.getEspacio();
                });
            },
            saveImage(num) {
                let formData = new FormData();
                let image = document.getElementById(`img_${num}`);
                let file = image.files[0];
                //Check the file type
                if (!file.type.match('image.*')) {
                    this.$toastr.error(`El archivo debe ser una imagen`, 'Ups hubo un error');
                    return;
                }
                //Check the file type
                if (file.size >= 2000000) {
                    this.$toastr.error(`El archivo debe pesar menos de 2MB`, 'Ups hubo un error');
                    return;
                }
                // Add the file to the request.
                formData.append('file', file);
                formData.append('imgorder', num);

                this.$toastr.info('Aguarde unos segundos', 'Cargando imagen...');
                fetch(`/api/saveimage/${this.$store.getters.getEspacio.id}`, {
                    method: 'post',
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${this.$auth.getToken()}`
                    },
                    body: formData
                })
                .then((res) => {
                    this.$toastr.success(`El archivo fue cargado correctamente`, 'Imagen cargada');
                    this.getEspacio();
                });
            },
            getEspacio() {
                this.$http.get(`api/espacio/${this.$store.getters.getEspacio.id}`)
                .then(res => {
                    this.imgPortada = {
                        'background-image': `url(${res.body.portada})`,
                        'background-size': 'cover'
                    };
                    this.$store.commit('setEspacio', res.body);
                }, err => {
                    this.$toastr.error(err, 'Ups hubo un error');
                });
            },
            deletePortada() {
                this.$toastr.info('Aguarde unos segundos', 'Borrando imagen...');
                this.$http.delete(`api/deleteportada/${this.$store.getters.getEspacio.id}`)
                .then(res => {
                    let espacio = this.$store.getters.getEspacio;
                    espacio.portada = "";
                    this.$store.commit('setEspacio', espacio);
                }, err => {
                    this.$toastr.error(err, 'Ups hubo un error');
                });
            },
            deleteImagen(id) {
                this.$toastr.info('Aguarde unos segundos', 'Borrando imagen...');
                for(let i = 0;i < this.$store.getters.getEspacio.images.length; i++) {
                    if (this.$store.getters.getEspacio.images[i].imgorder === id) {
                        this.$http.delete(`api/image/${this.$store.getters.getEspacio.images[i].id}`)
                        .then(res => {
                            this.getEspacio();
                        }, err => {
                            this.$toastr.error(err, 'Ups hubo un error');
                        });
                    }
                }
            },
            findeImage(num) {
                for(let i = 0;i < this.$store.getters.getEspacio.images.length; i++) {
                    if(this.$store.getters.getEspacio.images[i].imgorder === num) {
                        return true;
                    }
                }
                return false;
            },
            returnImage(num) {
                for(let i = 0;i < this.$store.getters.getEspacio.images.length; i++) {
                    if(this.$store.getters.getEspacio.images[i].imgorder === num) {
                        return this.$store.getters.getEspacio.images[i].name;
                    }
                }
            },
            saveEspacio() {
                this.$router.push({ name: 'descripcion'});
            },
            back() {
                this.$router.push({ name: "disponibilidad"});
            }
        }
    }
</script>
<style lang="sass" scoped>
    .box-images {
        width: 100%;
        height: 288px;
        border: solid 1px #979797;
        margin-top: 3em;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        &__image {
            width: 74px;
            height: 49px;
        }
        &__text {
            font-size: 12px;
            color: #666;
        }
    }
    .img-box-preview {
        width: 100%;
        height: 91px;
        background: #f8f8f8;
        box-shadow: 2px 2px 10px 0px #e6e6e6;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
        padding: 1em;
    }
    .img-box-preview-large {
        width: 100%;
        height: 230px;
        position: relative;
        box-shadow: 2px 2px 10px 0px #e6e6e6;
    }
    .btn-add-img {
        cursor: pointer;
    }
    .btn-remove-img {
        position: absolute;
        height: 25px;
        right: 0;
        background: #666;
        cursor: pointer;
    }
</style>