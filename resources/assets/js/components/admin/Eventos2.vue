<template>
    <div>
        <h2>Eventos trello</h2>
        <div class="cardboard">
            <div class="cardboard__item">
                <h4 class="center-align white-text">Consulta</h4>
                <div
                    class="card-panel white"
                    v-for="consulta in consultas.data"
                    :key="consulta.id"
                    @click="showEventoModal(consulta)">
                    <span>{{consulta.titulo_cliente}}</span>
                </div>
            </div>
            <div class="cardboard__item">
                <h4 class="center-align white-text">Seguimientos</h4>
                <div
                    class="card-panel white"
                    v-for="seguimiento in seguimientos.data"
                    :key="seguimiento.id"
                    @click="showEventoModal(seguimiento)">
                    <span>{{seguimiento.titulo_cliente}}</span>
                </div>
            </div>
            <div class="cardboard__item">
                <h4 class="center-align white-text">Presupuesto</h4>
                <div
                    class="card-panel white"
                    v-for="presupuesto in presupuestos.data"
                    :key="presupuesto.id"
                    @click="showEventoModal(presupuesto)">
                    <span>{{presupuesto.titulo_cliente}}</span>
                </div>
            </div>
            <div class="cardboard__item">
                <h4 class="center-align white-text">Reservado</h4>
                <div
                    class="card-panel white"
                    v-for="seguimiento in seguimientos.data"
                    :key="seguimiento.id"
                    @click="showEventoModal(seguimiento)">
                    <span>{{seguimiento.titulo_cliente}}</span>
                </div>
            </div>
            <div class="cardboard__item">
                <h4 class="center-align white-text">Visita</h4>
                <div
                    class="card-panel white"
                    v-for="seguimiento in seguimientos.data"
                    :key="seguimiento.id"
                    @click="showEventoModal(seguimiento)">
                    <span>{{seguimiento.titulo_cliente}}</span>
                </div>
            </div>
        </div>
        <!-- Begin Modal evento -->
        <div v-if="eventoModal" class="eventoModal">
            <div class="eventoModal__content">
                <div class="eventoModal__content__header">
                    <span class="eventoModal__close" @click="closeEventModal($event)">&times;</span>
                    <h4>{{eventSelect.titulo_cliente}}</h4>
                </div>
                <div class="eventoModal__content__body">
                    <ul class="tabs">
                        <li class="tab col s3">
                            <a :class="{active: (showStep == 'resumen')}" href="#" @click="changeStep($event, 'resumen')">Resumen</a>
                        </li>
                        <li class="tab col s3">
                            <a :class="{active: (showStep == 'mensajes')}" href="#" @click="changeStep($event, 'mensajes')">Mensajes</a>
                        </li>
                        <li class="tab col s3">
                            <a :class="{active: (showStep == 'propuesta')}" href="#" @click="changeStep($event, 'propuesta')">Propuesta</a>
                        </li>
                        <li class="tab col s3">
                            <a :class="{active: (showStep == 'notas')}" href="#" @click="changeStep($event, 'notas')">Notas</a>
                        </li>
                    </ul>
                    <ul class="collection with-header" v-show="(showStep == 'resumen')">
                        <li class="collection-header"><h5>Resumen</h5></li>
                        <li class="collection-item">Espacio:
                            <a
                                :href="`/categoria/${eventSelect.estilo_espacios_id}/espacio/${eventSelect.name}`"
                                target="_blank">{{eventSelect.name}}
                            </a>
                        </li>
                        <li class="collection-item">Check-In: <span>{{eventSelect.reserva_desde}}</span></li>
                        <li class="collection-item">Check-Out: <span>{{eventSelect.reserva_hasta}}</span></li>
                        <li class="collection-item">Total horas: <span>{{eventSelect.total_horas}}</span></li>
                        <li class="collection-item">Invitados: <span>{{eventSelect.invitados}}</span></li>
                        <li class="collection-item">Sub Total: $<span>{{eventSelect.sub_total}}</span></li>
                        <li class="collection-item">Estado:
                            <select v-model="eventSelect.estado" @change="updateEvento()">
                                <option value="consulta">Consulta</option>
                                <option value="seguimiento">Seguimiento</option>
                                <option value="visita">visita</option>
                                <option value="presupuesto">Presupuesto</option>
                                <option value="reservado">Reservado</option>
                                <option value="realizado">Realizado</option>
                                <option value="perdido">Perdido</option>
                            </select>
                        </li>
                    </ul>
                    <div class="collection with-header" v-show="(showStep == 'mensajes')">
                        <table class="highlight center responsive-table">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Mensaje</th>
                                <th>Creado</th>
                                <th>Estado</th>
                                <th colspan="2">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(mensaje, key) in mensajes.data" :key="mensaje.id" class="cursor-pointer">
                                <td>{{(mensaje.firstname == "")? '-' : mensaje.firstname}}</td>
                                <td v-if="!(mensaje.id == mensajeSelected.id)">{{mensaje.mensaje}}</td>
                                <td v-if="mensaje.id == mensajeSelected.id">
                                    <input type="text" v-model="mensaje.mensaje">
                                    <a href="#" @click="updateMensaje($event, mensaje, key)"><i class="material-icons">save</i></a>
                                </td>
                                <td>{{$moment(mensaje.created_at).format('DD/MM/YYYY')}}</td>
                                <td>{{(mensaje.status == false)? 'Pendiente' : 'Enviado'}}</td>
                                <td>
                                    <a href="#" @click="selectMensaje($event, mensaje)"><i class="material-icons">edit</i></a>
                                </td>
                                <td><a href="#" @click="enviarMensaje($event, mensaje.id, key)"><i class="material-icons">send</i></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="collection with-header" v-show="(showStep == 'propuesta')">

                    </div>
                    <div class="collection with-header" v-show="(showStep == 'notas')">
                        <textarea v-model="eventSelect.notas" cols="30" rows="10"></textarea>
                        <button
                            @click="updateEvento()"
                            class="waves-effect waves-light amber darken-2 btn right-align">Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal evento -->
    </div>
</template>
<script>
    export default {
        data() {
            return {
                eventoModal: false,
                eventSelect: {},
                consultas: [],
                seguimientos: [],
                presupuestos: [],
                mensajes: [],
                mensajeSelected: {},
                showStep: 'resumen'
            }
        },
        mounted() {
            this.getConsultas();
            this.getSeguimientos();
            this.getPresupuestos();
        },
        methods: {
            getConsultas() {
                this.$http.get('api/evento?statusEvento=consulta')
                .then(res => {
                    this.consultas = (res.body);
                }, err => {
                    console.log(err);
                });
            },
            getSeguimientos() {
                this.$http.get('api/evento?statusEvento=seguimiento')
                .then(res => {
                    this.seguimientos = (res.body);
                }, err => {
                    console.log(err);
                });
            },
            getPresupuestos(){
                this.$http.get('api/evento?statusEvento=presupuesto')
                .then(res => {
                    this.presupuestos = (res.body);
                }, err => {
                    console.log(err);
                });
            },
            showEventoModal(event) {
                this.eventSelect = event;
                this.eventoModal = true;
            },
            closeEventModal(event) {
                event.preventDefault();
                this.showStep = 'resumen';
                this.eventoModal = false;
            },
            updateEvento() {
                this.$http.put(`api/evento/${this.eventSelect.id}`, this.eventSelect)
                .then(res => {
                    this.getConsultas();
                    this.getSeguimientos();
                    this.getPresupuestos();
                    this.eventoModal = false;
                    this.showStep = 'resumen';
                    alert('El evento fue modificado!');
                }, err => {
                    console.log(err);
                });
            },
            changeStep(e, step) {
                e.preventDefault();
                if(step == "mensajes") {
                    this.getmensajes();
                }
                this.showStep = step;
            },
            getmensajes() {
                this.$http.get(`api/mensaje/${this.eventSelect.id}`)
                .then(res => {
                    this.mensajes = res.body;
                    this.showStep = "mensajes";
                }, err => {
                    console.log(err);
                });
            },
            selectMensaje(e, mensaje) {
                e.preventDefault();
                this.mensajeSelected = mensaje;
            },
            updateMensaje(e, mensaje, key) {
                e.preventDefault();
                this.$http.put(`api/mensaje/${mensaje.id}`, mensaje)
                .then(res => {
                    this.mensajes[key] = res.body;
                    this.mensajeSelected = {};
                    alert('El mensaje fue modificado!');
                }, err => {
                    console.log(err);
                });
            },
            enviarMensaje(e, id, key){
                e.preventDefault();
                this.$http.get(`api/mensaje/${id}/send`)
                    .then(res => {
                        this.mensajes[key] = res.body;
                        alert('El mensaje fue enviado!');
                    }, err => {
                        console.log(err);
                    });
            }
        }
    }
</script>
<style lang="sass" scoped>
    .cardboard {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        &__item {
            width: 20%;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #FFFFFF;
            padding: 1em;
            cursor: pointer;
            height: 100vh;
            overflow-y: auto;
            background: #FC5289;
        }
    }
    .eventoModal {
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
        &__content {
            background-color: #fefefe;
            margin: 2% auto;
            border: 1px solid #888;
            width: 85%;
            &__header {
                padding: 2px 16px;
                background-color: #FC5289;
                color: white;
            }
            &__body {padding: 2px 16px;}
        }
        &__close {
            color: #ffffff;
            float: right;
            font-size: 28px;
            font-weight: bold;
            &:hover, &:focus {
                text-decoration: none;
                cursor: pointer;
            }
        }
    }
    select {
        display: block;
    }
    textarea {
        height: 15em;
    }
</style>