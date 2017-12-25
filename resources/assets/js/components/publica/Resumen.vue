<template>
    <div class="wt-m-top-3">
        <h1 class="publica-titulo">¡Lo estás haciendo muy bien!</h1>
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
                        <router-link :to="`/actividad/${$store.getters.getEspacio.prices[0].categoria.name}`" class="box-container__btn__edit">EDITAR</router-link>
                        <img src="/img/wimet_ic_check_24px_accent.svg">
                    </div>
                </div>
                <div class="box-container">
                    <div>
                        <h3 class="box-container__title">Paso 3: Amenities</h3>
                        <span class="box-container_sub-title">Acceso - Amenities - Equipamiento</span>
                    </div>
                    <div class="box-container__btn">
                        <router-link to="/amenities" class="box-container__btn__edit">EDITAR</router-link>
                        <img src="/img/wimet_ic_check_24px_accent.svg">
                    </div>
                </div>
                <div class="box-container">
                    <div>
                        <h3 class="box-container__title">Paso 4: Disponibilidad</h3>
                        <span class="box-container_sub-title">Días de la semana</span>
                    </div>
                    <div class="box-container__btn">
                        <router-link to="/disponibilidad" class="box-container__btn__edit">EDITAR</router-link>
                        <img src="/img/wimet_ic_check_24px_accent.svg">
                    </div>
                </div>
                <div class="box-container">
                    <div>
                        <h3 class="box-container__title">Paso 5: Fotos</h3>
                        <span class="box-container_sub-title">Imágenes en alta calidad</span>
                    </div>
                    <div class="box-container__btn">
                        <router-link to="/foto" class="box-container__btn__edit">EDITAR</router-link>
                        <img src="/img/wimet_ic_check_24px_accent.svg">
                    </div>
                </div>
                <div class="box-container">
                    <div>
                        <h3 class="box-container__title">Paso 6: Descripción</h3>
                        <span class="box-container_sub-title">Título - Descripción - Reglamento interno</span>
                    </div>
                    <div class="box-container__btn">
                        <router-link to="/descripcion" class="box-container__btn__edit">EDITAR</router-link>
                        <img src="/img/wimet_ic_check_24px_accent.svg">
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
        name: "resumen"
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
</style>