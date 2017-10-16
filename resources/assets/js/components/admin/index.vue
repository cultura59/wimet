<template>
    <div>
        <h2>Dashboard</h2>
        <div class="row">
            <!-- Card espacios publicados -->
            <div class="col md 3">
                <div class="info-box">
                    <span class="info-box__icon teal darken-1">
                        <i class="medium material-icons">done_all</i>
                    </span>
                    <div class="info-box__content">
                        <span class="info-box__content__text">Espacios publicados</span>
                        <span class="info-box__content__number">{{publicados}}</span>
                    </div>
                </div>
            </div>
            <!-- Card espacios pendiente aprobacion -->
            <div class="col md 3">
                <div class="info-box">
                    <span class="info-box__icon yellow darken-3">
                        <i class="medium material-icons">done</i>
                    </span>
                    <div class="info-box__content">
                        <span class="info-box__content__text">Pendientes aprobación</span>
                        <span class="info-box__content__number">{{pendientes}}</span>
                    </div>
                </div>
            </div>
            <!-- Card espacios paso 3 -->
            <div class="col md 3">
                <div class="info-box">
                    <span class="info-box__icon light-blue darken-4">
                        <i class="medium material-icons">check_box</i>
                    </span>
                    <div class="info-box__content">
                        <span class="info-box__content__text">Borradores paso 3</span>
                        <span class="info-box__content__number">{{tercerpaso}}</span>
                    </div>
                </div>
            </div>
            <!-- Card espacios paso 2 -->
            <div class="col md 3">
                <div class="info-box">
                    <span class="info-box__icon light-blue darken-1">
                        <i class="medium material-icons">check_box_outline_blank</i>
                    </span>
                    <div class="info-box__content">
                        <span class="info-box__content__text">Borradores paso 2</span>
                        <span class="info-box__content__number">{{segundopaso}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col m6">
                <h4>Últimos eventos</h4>
                <table class="striped centered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Espacio</th>
                            <th>Creado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="evento in eventos" :key="evento.id">
                            <td>{{(evento.titulo_cliente == '' ? '-' : evento.titulo_cliente)}}</td>
                            <td>{{evento.name}}</td>
                            <td>{{evento.created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col m6">
                <h4>Últimos mensajes</h4>
                <table class="striped centered">
                    <thead>
                        <tr>
                        <th>Nombre</th>
                        <th>Mensaje</th>
                        <th>Estado</th>
                        <th>Creado</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="mensaje in mensajes" :key="mensaje.id">
                            <td>{{mensaje.firstname}}</td>
                            <td>{{mensaje.mensaje}}</td>
                            <td>{{(mensaje.status == 1)? 'Enviado' : 'Pendiente'}}</td>
                            <td>{{mensaje.created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                publicados: 0,
                pendientes: 0,
                tercerpaso: 0,
                segundopaso: 0,
                eventos: '',
                mensajes: ''
            }
        },
        mounted() {
            this.getInfo();
        },
        methods: {
            getInfo() {
                this.$http.get('admin/getinfo')
                .then(res => {
                    this.publicados = res.body.publicados;
                    this.pendientes = res.body.pendientes;
                    this.tercerpaso = res.body.tercerpaso;
                    this.segundopaso = res.body.segundopaso;
                    this.eventos = res.body.eventos;
                    this.mensajes = res.body.mensajes;
                }, err => {
                    console.log(err);
                })
            }
        }
    }
</script>
<style lang="sass" scoped>
    .info-box {
        display: flex;
        min-height: 90px;
        background: #fff;
        width: 100%;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        border-radius: 2px;
        margin-bottom: 1em;
        &__icon {
            border-top-left-radius: 2px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 2px;
            height: 90px;
            width: 90px;display: flex;
            justify-content: center;
            align-items: center;
            font-size: 45px;
            line-height: 90px;
            background: rgba(0, 0, 0, 0.2);
            color: #fff;
        }
        &__content {
            padding: 1em;
            display: flex;
            flex-direction: column;
            min-width: 155px;
            &__test {
                text-transform: uppercase;
                font-size: 14px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            &__number {
                font-weight: bold;
                font-size: 18px;
            }
        }
    }
</style>