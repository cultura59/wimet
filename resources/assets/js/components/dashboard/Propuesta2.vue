<template>
	<div>
		<router-link :to="`/mensaje/${propuesta.evento.id}`" class="left-icon"><img src="https://res.cloudinary.com/wimet/image/upload/v1515117772/icons/ic_left.svg"> ATRAS</router-link>
		<div class="container-propuesta">
			<span class="container-propuesta__title">PROPUESTA</span>
		</div>
		<div class="propuesta-main">
			<div class="row">
				<div class="col-md-8">
					<div>
						<h4>Presupuesto</h4>
						<table class="table">
							<thead>
								<tr>
									<th class="col-md-6">Descripción</th>
									<th class="col-md-2 text-center">Importe</th>
									<th class="col-md-2 text-center">Cantidad</th>
									<th class="col-md-2 text-center">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr class="active">
									<td class="col-md-6">Mi espacio</td>
									<td colspan="2"></td>
									<td class="col-md-2">
										<input type="text" placeholder="$ 10000" class="pull-right text-center" v-model="propuesta.sub_total" @change="changeSubTotal()">
									</td>
								</tr>
								<tr class="active" v-for="(servicio, index) in propuesta.servicios">
									<td class="col-md-6">{{servicio.sdescripcion}}</td>
									<td class="col-md-2 text-center">${{servicio.simporte}}</td>
									<td class="col-md-2 text-center">{{servicio.scantidad}}</td>
									<td class="col-md-2 text-center">${{servicio.stotal}}
										<a href="#" class="pull-right" @click="deleteServicio($event, index)">
											<img src="https://res.cloudinary.com/wimet/image/upload/icons/icon_remove_img_black.svg" class="btn-remove-img">
										</a>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="box-servicios">
							<div>
								<button class="box-servicios__btn" @click="modalServicios = true">Agregar servicio</button>
							</div>
							<div>
								<span class="box-servicios__total">Total</span>
								<span>$ {{propuesta.total}}</span>
							</div>
						</div>
					</div>
					<div>
						<h4 class="wt-m-top-4">Historial de Pagos por espacio</h4>
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
									<td class="text-center">{{pago.pvencimiento}}</td>
									<td class="text-center">$ {{pago.ptotal}}</td>
								</tr>
							</tbody>
						</table>
						<div class="wt-space-block">
							<button class="btn-transparent-black" @click="modalTerminos = true">Condiciones de  contratación</button>
							<div>
								<button class="btn-transparent-black" @click="modalVistaPrevia = true">Vista previa</button>
								<button class="send-propuesta" @click="crearPropuesta()">ENVIAR</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<h4>Resumen</h4>
					<div class="box-resumen">
						<img :src="propuesta.espacio.portada" class="img-responsive">
						<div class="box-resumen__body">
							<span class="wt-m-bot-1">Estado: {{propuesta.estado}}</span>
							<span class="wt-m-bot-1">Actividad: {{getCategoria(propuesta.evento.estilo_espacios_id)}}</span>
							<span class="wt-m-bot-1">Invitados: {{propuesta.evento.invitados}}</span>
							<span class="wt-m-bot-1">Fechas solicitadas</span>
							<ul>
								<li v-for="dia in propuesta.dias" :key="dia.id">
									<span v-if="dia.tipo == 'all'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (jornada completa)</span>
									<span v-if="dia.tipo == 'morning'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - am)</span>
									<span v-if="dia.tipo == 'night'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - pm)</span>
								</li>
							</ul>
							<h4 class="wt-m-top-2">PRECIO</h4>
							<div class="box-resumen__precios">
								<div class="wt-space-block wt-m-bot-1">
									<span>Total x espacio</span>
									<span>${{propuesta.sub_total}}</span>
								</div>
								<div class="wt-space-block wt-m-bot-1">
									<span>Comisión Wimet</span>
									<span>${{fee}}</span>
								</div>
								<div class="wt-space-block">
									<strong>Recibirás</strong>
									<strong>${{propuesta.sub_total - fee}}</strong>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div v-show="modalServicios" class="modalServicios">
			<div class="modalServicios__content">
				<span class="close" @click="modalServicios = false">&times;</span>
				<div class="row wt-m-top-3">
					<div class="wt-center-column col-md-6">
						<label for="descripcion">Descripción</label>
						<input type="text" placeholder="Servicio" v-model="newServicio.sdescripcion">
					</div>
					<div class="modalServicios__content__box col-md-2">
						<label for="importe">Importe</label>
						<input type="text" placeholder="$ 1000" v-model="newServicio.simporte">
					</div>
					<div class="modalServicios__content__box col-md-2">
						<label for="cantidad">Cantidad</label>
						<input type="text" placeholder="10" v-model="newServicio.scantidad">
					</div>
					<div class="modalServicios__content__box col-md-2">
						<label for="total">Total</label>
						<span>${{(newServicio.simporte * newServicio.scantidad)}}</span>
					</div>
				</div>
				<button class="modalServicios__content__btn" @click="agregarServicio()">AGREGAR</button>
			</div>
		</div>
		<div v-show="modalTerminos" class="modalServicios">
			<div class="modalServicios__content">
				<div class="wt-space-block">
					<strong class="title">CONDICIONES DE CONTRATACIÓN</strong>
					<span class="close" @click="modalTerminos = false">&times;</span>
				</div>
				<div class="wt-m-top-3">
					<div class="wt-center-column">
						<label for="descripcion">Descripción</label>
						<textarea v-model="propuesta.evento.condiciones" cols="30" rows="10"></textarea>
					</div>
				</div>
				<button class="modalServicios__content__btn" @click="modalTerminos = false">GUARDAR</button>
			</div>
		</div>
		<div v-show="modalVistaPrevia" class="modalServicios">
			<div class="modalServicios__content">
				<div class="wt-space-block">
					<strong class="title">PRESUPUESTO</strong>
					<div>
						<button class="send-propuesta" @click="crearPropuesta()">ENVIAR</button>
						<span class="close" @click="modalVistaPrevia = false">&times;</span>
					</div>
				</div>
				<div class="wt-m-top-3">
					<div class="row">
						<div class="col-md-6">
							<img :src="propuesta.espacio.portada" alt="espacio.nombre" class="img-responsive">
						</div>
						<div class="col-md-6 wt-center-column">
							<span class="wt-m-bot-1"><strong>Estado:</strong> {{propuesta.evento.nombre_evento}}</span>
							<span class="wt-m-bot-1"><strong>Actividad:</strong> {{getCategoria(propuesta.evento.estilo_espacios_id)}}</span>
							<span class="wt-m-bot-1"><strong>Invitados:</strong> {{propuesta.evento.invitados}}</span>
							<strong class="wt-m-bot-1">Fechas solicitadas</strong>
							<ul>
								<li v-for="dia in propuesta.dias" :key="dia.id" class="wt-m-lf-3">
									<span v-if="dia.tipo == 'all'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (jornada completa)</span>
									<span v-if="dia.tipo == 'morning'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - am)</span>
									<span v-if="dia.tipo == 'night'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - pm)</span>
								</li>
							</ul>
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
						<tbody>
						<tr class="active">
							<td class="col-md-6">Mi espacio</td>
							<td class="col-md-2 text-center">-</td>
							<td class="col-md-2 text-center">-</td>
							<td class="col-md-2 text-center">{{propuesta.sub_total}}</td>
						</tr>
						<tr class="active" v-for="(servicio, index)  in propuesta.servicios">
							<td class="col-md-6">{{servicio.sdescripcion}}</td>
							<td class="col-md-2 text-center">${{servicio.simporte}}</td>
							<td class="col-md-2 text-center">{{servicio.scantidad}}</td>
							<td class="col-md-2 text-center">${{servicio.stotal}}</td>
						</tr>
						</tbody>
					</table>
					<div class="box-detalle-total">
						<span><strong>Total</strong> ${{propuesta.total}}</span>
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
					<div v-if="propuesta.evento.condiciones !== undefined">
						<h3 class="wt-m-top-4">Condiciones de contratación</h3>
						<div v-html="propuesta.evento.condiciones"></div>
					</div>
				</div>
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
				newServicio: {
                    sdescripcion: '',
					simporte: 0,
					scantidad: 0,
					stotal: 0
				},
                showLoading: false,
                fee: 0,
				date: '',
                lastDay: '',
				total_servicios: 0,
                modalServicios: false,
                modalTerminos: false,
                modalVistaPrevia: false
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
                        this.lastDay = this.$moment(this.propuesta.dias[this.propuesta.dias.length - 1].fecha).subtract(3, 'days').format("YYYY-MM-DD");
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
			changeSubTotal() {
                this.propuesta.total = 0;
                this.propuesta.servicios.forEach((val) => {
                    this.propuesta.total = this.propuesta.total + val.stotal;
                });
                this.propuesta.total = parseInt(this.propuesta.total) + parseInt(this.propuesta.sub_total);
                this.propuesta.pagos = [];
                this.propuesta.pagos.push({pdescripcion: 'Reserva', espacio_id: this.propuesta.evento.espacio_id, ptotal: (this.propuesta.total / 2), pvencimiento: this.$moment().add(5, 'days').format("YYYY-MM-DD"), pestado: 'Pendiente'});
                this.propuesta.pagos.push({pdescripcion: 'Saldo', espacio_id: this.propuesta.evento.espacio_id, ptotal: (this.propuesta.total / 2), pvencimiento: this.lastDay, pestado: 'Pendiente'});
			},
            agregarServicio() {
                this.newServicio.stotal = (this.newServicio.simporte * this.newServicio.scantidad);
                this.propuesta.total = parseInt(this.propuesta.total) + this.newServicio.stotal;
                this.propuesta.servicios.push(this.newServicio);
                this.newServicio = {sdescripcion: '', simporte: 0, scantidad: 0, stotal: 0};
                this.propuesta.pagos = [];
                this.propuesta.pagos.push({pdescripcion: 'Reserva', espacio_id: this.propuesta.evento.espacio_id, ptotal: (this.propuesta.total / 2), pvencimiento: this.$moment().add(5, 'days').format("YYYY-MM-DD"), pestado: 'Pendiente'});
                this.propuesta.pagos.push({pdescripcion: 'Saldo', espacio_id: this.propuesta.evento.espacio_id, ptotal: (this.propuesta.total / 2), pvencimiento: this.lastDay, pestado: 'Pendiente'});
                this.modalServicios = false;
			},
			deleteServicio(e, index) {
                e.preventDefault();
                this.propuesta.total = this.propuesta.total - this.propuesta.servicios[index].stotal;
                this.propuesta.servicios.splice(index, 1);
			},
			crearPropuesta() {
                let propuesta = this.evento;
                propuesta.evento_id = this.evento.id;
                delete propuesta['id'];
                propuesta.total = this.evento.total;
                propuesta.servicios = this.servicios;
                propuesta.pagos = this.pagos;
                propuesta.dias = this.dias;
                this.$http.post('api/propuesta', propuesta)
				.then(res => {
                    this.$router.push({name: 'Mensaje', params: { eventoId: this.$route.params.id }});
				}, err => {
                    this.$toastr.error("Propuesta no enviada!", "Hubo un error al intentar enviar la propuesta, intente nuevamente");
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
	}
	.send-propuesta {
		border-radius: 1px;
		background-color: #fc5289;
		color: #fff;
		padding: .5em 3em;
		border: none;
		margin-top: 2em;
	}
	.btn-transparent-black {
		border-radius: 1px;
		background-color: transparent;
		padding: .5em 3em;
		border: 1px solid #333;
		margin-top: 2em;
	}
	.modalServicios {
		position: fixed;
		z-index: 1;
		padding-top: 100px;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0,0,0);
		background-color: rgba(0,0,0,0.4);
		&__content {
			.title {color: #333; font-size: 18px}
			background-color: #fefefe;
			margin: auto;
			padding: 1em 3em;
			border: 1px solid #888;
			width: 60%;
			height: auto;
			label { color: #333}
			textarea {
				padding:1em;
			}
			&__box {
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
				input {
					width: 100%;
				}
			}
			&__btn {
				border-radius: 1px;
				background-color: #fc5289;
				color: #fff;
				padding: .5em 3em;
				border: none;
				margin-top: 2em;
			}
		}
	}
	.box-detalle-total {
		display: flex;
		justify-content: flex-end;
		margin-right: 2em;
	}
</style>