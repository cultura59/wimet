<template>
    <div>
        <div class="container-dashboard">
            <span class="container-dashboard__title">DASHBOARD</span>
        </div>
        <div class="dashboard-main">
            <h1>¡Hola {{$store.getters.getUser.firstname}}, bienvenido!</h1>
            <div class="row wt-m-top-3">
                <div class="col-md-9">
                    <div class="box-content">
                        <span class="box-content__title">Mis espacios</span>
                        <button class="box-content__btn" @click="publica()">PUBLICA TU ESPACIO</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="avatar">
                        <img :src="$store.getters.getUser.imagesource" :alt="$store.getters.getUser.firstname" style="width: 70px; border-radius: 50%">
                        <span class="avatar__name">{{$store.getters.getUser.firstname}}</span>
                        <span class="avatar__fechas">Se unión: {{$moment($store.getters.getUser.created_at).locale('es').format("D MMM YYYY")}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "dashboard",
        methods: {
            publica() {
                window.location = "/publica/espacio";
            }
        }
    }
</script>

<style lang="sass" scoped>
    .container-dashboard {
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
            margin-bottom: 1em;
        }
    }
    .dashboard-main {
        padding: 3em 2em;
        background-color: #ffffff;
        box-shadow: 0 0 68px 0 rgba(0, 0, 0, 0.1);
        h1 {
            font-weight: bold;
            color: #000000;
        }
        .box-content {
            padding: 1em;
            background-color: #f0f0f0;
            display: flex;
            justify-content: space-between;
            &__title {
                font-size: 16px;
                font-weight: bold;
                color: #212121;
            }
            &__btn {
                font-size: 12px;
                background-color: #fc5289;
                border: solid 2px #fc5289;
                padding: 1em;
                color: #fff;
                border-radius: 2px;
                min-width: 100px;
            }
        }
        .avatar {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            &__name {
                color: #fb5288;
                font-size: 14px;
                font-weight: bold;
                margin: 1em 0;
            }
            &__fechas {
                font-size: 10px;
                color: #212121;
            }
        }
    }
</style>