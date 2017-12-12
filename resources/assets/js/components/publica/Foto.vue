<template>
    <div class="wt-m-top-3">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <h1 class="publica-titulo">{{$store.getters.getUser.firstname}} es hora de elegir</h1>
                <h1 class="publica-titulo">tus mejores fotos</h1>
                <form>
                    <input type="file" id="box-images" style="display: none;">
                    <label id="fake-input" for="box-images" class="box-images">
                        <img class="box-images__image" src="https://res.cloudinary.com/wimet/image/upload/v1512822338/icon-nube.svg">
                        <span class="box-images__text">haga clic para cargar o arrastra tu foto de portada aquí</span>
                    </label>
                </form>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="img-box-preview-large"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-box-preview wt-m-top-1"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-box-preview wt-m-top-1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="img-box-preview"></div>
                        <div class="img-box-preview wt-m-top-1 wt-m-bot-1"></div>
                        <div class="img-box-preview"></div>
                    </div>
                </div>
                <div class="wt-space-block wt-m-top-3">
                    <button class="btn-publica-step-default">
                        <img src="https://res.cloudinary.com/wimet/image/upload/v1512746740/ic_keyboard_backspace_black_24px.svg">
                        <span>ATRÁS</span>
                    </button>
                    <button class="btn-publica-step-primary" @click="saveEspacio()">GUARDAR Y CONTINUAR</button>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <img src="https://res.cloudinary.com/wimet/image/upload/v1512821482/wimet_fotos.svg" class="img-responsive">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "foto",
        mounted(){
            let target = document.getElementById("fake-input");
            let formData = new FormData();
            // Action dragover
            target.addEventListener("dragover", (event) => {
                event.preventDefault();
            }, false);
            // Action dragdrop
            target.addEventListener("drop", (event) => {
                event.preventDefault();
                let files = event.dataTransfer.files;
                for (let i = 0; i < files.length; i++) {
                    console.log("Filename: " + files[i].name);
                    console.log("Type: " + files[i].type);
                    console.log("Size: " + files[i].size + " bytes");

                    formData.append('type', 'file');
                    formData.append('image', files[i]);

                    this.saveImage(formData);
                }
            }, false);
        },
        methods: {
            saveImage(form) {
                fetch('https://api.imgur.com/3/upload.json', {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${this.$auth.getToken()}`
                    },
                    body: form
                })
                .then(processStatus)
                .then(parseJson);
                console.log(parseJson);
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
        border: solid 1px #979797
    }
    .img-box-preview-large {
        width: 100%;
        height: 190px;
        border: solid 1px #979797
    }
</style>