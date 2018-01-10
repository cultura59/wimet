<template>
    <div>
        <div class="container-mis-espacios">
            <span class="container-mis-espacios__title">MIS FAVORITOS</span>
        </div>
        <div class="espacios-main">
            <div v-if="$store.getters.getUser.espacios.length > 0" class="row">
                <div class="col-xs-12 col-md-6" v-for="espacio in $store.getters.getUser.espacios">
                    <espacio-search
                        :espacio-id="espacio.id"
                        :category-id="1">
                    </espacio-search>
                </div>
            </div>
            <div v-if="$store.getters.getUser.espacios.length === 0">
                <p class="no-favoritos">No tienes espacios favoritos aún...</p>
            </div>
        </div>
    </div>
</template>

<script>
    import espacioFavorito from '../EspacioSearch.vue';
    export default {
        name: "favorito",
        components: {
            'espacio-search': espacioFavorito
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
    }
    .espacios-main {
        margin-top: 2em;
        padding: 3em 2em;
        background-color: #ffffff;
        box-shadow: 0 0 68px 0 rgba(0, 0, 0, 0.1);
        .no-favoritos {
            height: 150px;
            border-radius: 10px;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }
</style>