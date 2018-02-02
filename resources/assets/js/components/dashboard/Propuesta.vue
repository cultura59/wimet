<template>
    <div>
        <router-link to="/propuestas" class="left-icon"><img src="https://res.cloudinary.com/wimet/image/upload/v1515117772/icons/ic_left.svg"> ATRAS</router-link>
        <div class="container-propuesta">
            <span class="container-propuesta__title">{{evento.nombre_evento}}</span>
        </div>
        <div class="propuesta-main">
            <div class="row">
                <div class="col-md-6">
                    <img :src="espacio.portada" alt="espacio.nombre" class="img-responsive">
                </div>
                <div class="col-md-4 wt-center-column">
                    <span class="wt-m-bot-1"><strong>Estado:</strong> {{evento.estado}}</span>
                    <span class="wt-m-bot-1"><strong>Actividad:</strong> {{getCategoria(evento.estilo_espacios_id)}}</span>
                    <span class="wt-m-bot-1"><strong>Invitados:</strong> {{evento.invitados}}</span>
                    <strong class="wt-m-bot-1">Fechas solicitadas</strong>
                    <ul>
                        <li v-for="dia in propuesta.dias" :key="dia.id" class="wt-m-lf-3">
                            <span v-if="dia.tipo == 'all'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (jornada completa)</span>
                            <span v-if="dia.tipo == 'morning'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - am)</span>
                            <span v-if="dia.tipo == 'night'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - pm)</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2 wt-center-column" v-show="$store.getters.getUser.id == evento.user_id">
                    <button class="btn-primary-pig">ACEPTAR</button>
                    <button class="btn-primary-pig wt-m-top-1">CANCELAR</button>
                    <button v-if="!modifica" class="btn-primary-pig wt-m-top-1" @click="modifica = true">MODIFICAR</button>
                    <button v-if="modifica" class="btn-primary-pig wt-m-top-1">GUARDAR</button>
                </div>
            </div>
            <h3>Detalles de la propuesta</h3>
            <table class="table">
                <thead>
                <tr>
                    <th class="col-md-6">Descripción</th>
                    <th class="col-md-2 text-center">Importe</th>
                    <th class="col-md-2 text-center">Cantidad</th>
                    <th class="col-md-2 text-center">Total</th>
                </tr>
                </thead>
                <tbody v-show="!modifica">
                    <tr class="active">
                        <td class="col-md-6">Mi espacio</td>
                        <td class="col-md-2 text-center">-</td>
                        <td class="col-md-2 text-center">-</td>
                        <td class="col-md-2 text-center">${{evento.sub_total}}</td>
                    </tr>
                    <tr class="active" v-for="(servicio, index)  in propuesta.servicios">
                        <td class="col-md-6">{{servicio.sdescripcion}}</td>
                        <td class="col-md-2 text-center">${{servicio.simporte}}</td>
                        <td class="col-md-2 text-center">{{servicio.scantidad}}</td>
                        <td class="col-md-2 text-center">${{servicio.stotal}}</td>
                    </tr>
                </tbody>
                <tbody v-show="modifica">
                    <tr class="active">
                        <td class="col-md-4">Mi espacio</td>
                        <td class="col-md-2 text-center">-</td>
                        <td class="col-md-2 text-center">-</td>
                        <td v-show="modifica" class="col-md-2 text-center">
                            <input type="text" v-model="evento.sub_total" @change="changeSubTotal()">
                        </td>
                        <td class="col-md-2 text-center">-</td>
                    </tr>
                    <tr class="active" v-for="(servicio, index)  in propuesta.servicios" :key="servicio.id">
                        <td class="col-md-4"><input type="text" v-model="servicio.sdescripcion"></td>
                        <td class="col-md-2 text-center"><input type="text" v-model="servicio.simporte"></td>
                        <td class="col-md-2 text-center"><input type="text" v-model="servicio.scantidad"></td>
                        <td class="col-md-2 text-center"><input type="text" v-model="servicio.stotal"></td>
                        <td class="col-md-2">
                            <a href="#" class="pull-right" @click="deleteServicio($event, index)">
                                <img src="https://res.cloudinary.com/wimet/image/upload/icons/icon_remove_img_black.svg" class="btn-remove-img">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="box-detalle-total">
                <span><strong>Total</strong> ${{totalPago}}</span>
            </div>
            <h3 class="wt-m-top-4">Historial de Pagos por espacio</h3>
            <table class="table wt-m-top-2">
                <thead>
                <tr>
                    <th>Descripción</th>
                    <th class="text-center">%</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Vencimiento</th>
                    <th class="text-center">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr class="active" v-for="pago in propuesta.pagos">
                    <td>{{pago.pdescripcion}}</td>
                    <td class="text-center">-</td>
                    <td class="text-center">{{pago.pestado}}</td>
                    <td class="text-center">{{$moment(pago.pvencimiento).format("DD/MM/YYYY")}}</td>
                    <td class="text-center">$ {{pago.ptotal}}</td>
                </tr>
                </tbody>
            </table>
            <div v-if="evento.condiciones !== undefined">
                <h3 class="wt-m-top-4">Condiciones de contratación</h3>
                <div v-html="evento.condiciones"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "propuesta",
        data() {
            return {
                propuesta: {},
                espacio: {},
                evento: {},
                totalPago: 0,
                modifica: false
            }
        },
        mounted() {
            this.getPropuesta();
        },
        methods: {
            getPropuesta() {
                this.$http.get(`api/propuesta/${this.$route.params.id}`)
                .then(res => {
                    this.propuesta = res.body;
                    this.evento = res.body.evento;
                    this.espacio = res.body.espacio;
                    this.lastDay = this.$moment(this.propuesta.dias[this.propuesta.dias.length - 1].fecha).subtract(3, 'days').format("YYYY-MM-DD");
                    this.getTotal();
                }, err => {
                    console.log(err);
                });
            },
            getCategoria(id) {
                switch(id) {
                    case 1:
                        return 'REUNIÓN';
                    case 2:
                        return 'EVENTO';
                    case 3:
                        return 'PRODUCCIÓN';
                    case 4:
                        return 'RETAIL';
                }
            },
            getTotal() {
                for(let i = 0; i < this.propuesta.pagos.length; i++) {
                    this.totalPago = this.totalPago + parseInt(this.propuesta.pagos[i].ptotal);
                }
            },
            changeSubTotal() {
                this.propuesta.pagos = [];
                this.propuesta.pagos.push({pdescripcion: 'Reserva', espacio_id: this.evento.espacio_id, ptotal: (this.evento.sub_total / 2), pvencimiento: this.$moment().add(5, 'days').format("YYYY-MM-DD"), pestado: 'Pendiente'});
                this.propuesta.pagos.push({pdescripcion: 'Saldo', espacio_id: this.evento.espacio_id, ptotal: (this.evento.sub_total / 2), pvencimiento: this.lastDay, pestado: 'Pendiente'});
            },
            agregarServicio() {
                this.newServicio.stotal = (this.newServicio.simporte * this.newServicio.scantidad);
                this.total_servicios = this.total_servicios + this.newServicio.stotal;
                this.propuestas.servicios.push(this.newServicio);
                this.newServicio = {sdescripcion: '', simporte: 0, scantidad: 0, stotal: 0};
                this.modalServicios = false;
            },
            deleteServicio(e, id) {
                e.preventDefault();
                this.$http.delete(`api/propuestaservicios/${this.propuesta.servicios[id].id}`)
                .then(res => {
                    this.propuesta.total = this.propuesta.total - this.propuesta.servicios[id].stotal;
                    this.propuesta.servicios.splice(id, 1);
                }, err => {
                    this.$toastr.error(err, "Ups, hubo un problema");
                });
            }
        }
    }
</script>

<style lang="sass" scoped>
    h3, h4, strong {color: #333}
    .left-icon {
        position: absolute;
        left: 3em;
        top: 1em;
        text-decoration: none;
        color: #333333;
    }
    .container-propuesta {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 0 2em;
        margin-top: 3em;
        align-items: flex-end;
        &__title {
            font-family: Avenir;
            font-size: 16px;
            font-weight: bold;
            color: #333333;
        }
    }
    .propuesta-main {
        margin-top: 2em;
        padding: 2em;
        background-color: #ffffff;
        box-shadow: 0 0 68px 0 rgba(0, 0, 0, 0.1);
        color: #333333;
        td { border-top: 1px solid #fff !important}
        .row-lg { min-width: 15em;}
        .box-servicios {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 0 2em;
            &__btn {
                border: 1px solid #333;
                padding: .5em 2em;
            }
            &__total {
                font-weight: bold;
                font-size: 16px;
                margin-right: 6em;
            }
        }
        .box-detalle-total {
            display: flex;
            justify-content: flex-end;
            margin-right: 2em;
        }
    }
</style>