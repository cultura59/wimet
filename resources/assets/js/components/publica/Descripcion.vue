<template>
    <div class="wt-m-top-3">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <h1 class="publica-titulo">A un paso de convertirte</h1>
                <h1 class="publica-titulo">en anfitrión</h1>
                <div class="row wt-m-top-3">
                    <div class="col-xs-12 col-md-3">
                        <label class="label-publica">TÍTULO</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <input class="input-publica" type="text" placeholder="Ej.: Galería artística y cultural en Palermo">
                    </div>
                </div>
                <div class="row wt-m-top-3">
                    <div class="col-xs-12 col-md-3">
                        <label class="label-publica">DESCRIPCIÓN</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <textarea rows="10" class="input-publica"></textarea>
                    </div>
                </div>
                <div class="row wt-m-top-3">
                    <div class="col-xs-12 col-md-3">
                        <label class="label-publica">REGLAMENTO INTERNO</label>
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <textarea rows="10" class="input-publica"></textarea>
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
                <img src="https://res.cloudinary.com/wimet/image/upload/v1512841394/wimet_descripcion.svg" class="img-responsive">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "descripcion"
    }
</script>

<style scoped>

</style>