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
									<td class="col-md-2 text-center">-</td>
									<td class="col-md-2 text-center">-</td>
									<td v-show="!modifica" class="col-md-2 text-center">$ {{propuesta.sub_total}}</td>
									<td v-show="modifica" class="col-md-2 text-center">
										<input type="text" placeholder="$ 10000" class="pull-right text-center" v-model="propuesta.sub_total" @change="changeSubTotal()">
									</td>
								</tr>
								<tr class="active" v-for="(servicio, index) in propuesta.servicios">
									<td class="col-md-6">{{servicio.sdescripcion}}</td>
									<td class="col-md-2 text-center">${{servicio.simporte}}</td>
									<td class="col-md-2 text-center">{{servicio.scantidad}}</td>
									<td class="col-md-2 text-center">${{servicio.stotal}}
										<a v-if="propuesta.user_id == $store.getters.getUser.id" href="#" class="pull-right" @click="deleteServicio($event, index)">
											<img src="https://res.cloudinary.com/wimet/image/upload/icons/icon_remove_img_black.svg" class="btn-remove-img">
										</a>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="box-servicios">
							<div>
								<button v-if="propuesta.user_id == $store.getters.getUser.id" class="box-servicios__btn" @click="modalServicios = true">Agregar servicio</button>
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
						<div v-if="propuesta.estado == 'enviada'" class="wt-space-block">
							<template v-if="propuesta.user_id === $store.getters.getUser.id && propuesta.aprueba_duenio == false">
								<button v-show="modifica" class="btn-transparent-black" @click="modifica = true">GUARDAR</button>
								<button v-show="!modifica" class="btn-transparent-black" @click="modifica = true">MODIFICAR</button>
								<div>
									<button class="send-propuesta" @click="cancelarPropuesta()">RECHAZAR</button>
									<button class="send-propuesta" @click="pagoPropuesta()">ACEPTAR</button>
								</div>
							</template>
							<template v-if="propuesta.user_id !== $store.getters.getUser.id">
								<button class="btn-transparent-black" @click="cancelarPropuesta()">RECHAZAR</button>
								<button class="send-propuesta" @click="pagoPropuesta()">ACEPTAR</button>
							</template>
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
							<span v-show="!modifica" class="wt-m-bot-1">Invitados: {{propuesta.evento.invitados}}</span>
							<span v-show="modifica" class="wt-m-bot-1">Invitados: <input type="text" v-model="propuesta.evento.invitados"></span>
							<span class="wt-m-bot-1">Fechas solicitadas</span>
							<template v-if="!modifica">
								<ul>
									<li v-for="dia in propuesta.dias" :key="dia.id">
										<span v-if="dia.tipo == 'all'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (jornada completa)</span>
										<span v-if="dia.tipo == 'morning'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - am)</span>
										<span v-if="dia.tipo == 'night'">{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}} (media jornada - pm)</span>
									</li>
								</ul>
							</template>
							<template v-if="modifica">
								<div class="box-resumen">
									<div class="select__mount">
										<span  @click="previous()" class="cursor-pointer"><</span>
										<span>{{month.format('MMMM YYYY').toUpperCase()}}</span>
										<span @click="next()" class="cursor-pointer">></span>
									</div>
									<table class="calendar-table">
										<thead>
										<tr>
											<th>DOM</th>
											<th>LUN</th>
											<th>MAR</th>
											<th>MIE</th>
											<th>JUE</th>
											<th>VIE</th>
											<th>SAB</th>
										</tr>
										</thead>
										<tbody>
										<tr v-for="week in weeks">
											<td
												v-for="day in week.days"
												:key="day.number"
												:class="getClass(day)"
												@click="toggleDays(day)"
											>
												<span>{{day.number}}</span>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</template>
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
                modalVistaPrevia: false,
				modifica: false,
                month: '',
                weeks: [],
                selected: ''
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
                        this.startCalendar();
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
                this.newServicio.propuesta_id = this.propuesta.id;
                this.$http.post(`api/propuestaservicios`, this.newServicio)
                    .then(res => {
                        this.propuesta.total = parseInt(this.propuesta.total) + this.newServicio.stotal;
                        this.propuesta.servicios.push(res.body);
                        this.newServicio = {sdescripcion: '', simporte: 0, scantidad: 0, stotal: 0};
                        this.propuesta.pagos = [];
                        this.propuesta.pagos.push({pdescripcion: 'Reserva', espacio_id: this.propuesta.evento.espacio_id, ptotal: (this.propuesta.total / 2), pvencimiento: this.$moment().add(5, 'days').format("YYYY-MM-DD"), pestado: 'Pendiente'});
                        this.propuesta.pagos.push({pdescripcion: 'Saldo', espacio_id: this.propuesta.evento.espacio_id, ptotal: (this.propuesta.total / 2), pvencimiento: this.lastDay, pestado: 'Pendiente'});
                        this.modalServicios = false;
                    }, err => {
                        this.$toastr.error(err, "Ups, hubo un problema");
                    });
			},
			deleteServicio(e, id) {
                e.preventDefault();
                this.$http.delete(`api/propuestaservicios/${this.propuesta.servicios[id].id}`)
				.then(res => {
					this.propuesta.total = this.propuesta.total - this.propuesta.servicios[id].stotal;
					this.propuesta.servicios.splice(index, 1);
				}, err => {
					this.$toastr.error(err, "Ups, hubo un problema");
				});
            },
            startCalendar() {
                this.$moment.locale('es', {
                    months : "Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre".split("_")
                });
                // Inicializo
                let start = this.$moment();
                this.month = this.$moment();
                start.date(1);
                this.removeTime(start.day(0));
                this.buildMonth(start, this.month);
            },
            removeTime(date) {
                return date.day(0).hour(0).minute(0).second(0).millisecond(0);
            },
            buildMonth(start, month) {
                this.weeks = [];
                let done = false,
                    date = start.clone(),
                    monthIndex = date.month(),
                    count = 0;
                while (!done) {
                    this.weeks.push({ days: this.buildWeek(date.clone(), month) });
                    date.add(1, "w");
                    done = count++ > 2 && monthIndex !== date.month();
                    monthIndex = date.month();
                }
            },
            buildWeek(date, month) {
                let days = [];
                for (let i = 0; i < 7; i++) {
                    days.push({
                        name: date.format("dd").substring(0, 1),
                        number: date.date(),
                        isCurrentMonth: date.month() === this.$moment().month(),
                        isToday: date.format('YYYY-MM-DD') === this.$moment().format('YYYY-MM-DD'),
                        isAvailable: this.isAvailable(date),
                        fecha: date,
                        tipo: this.inArray(date)
                    });
                    date = date.clone();
                    date.add(1, "d");
                }
                return days;
            },
            inArray(val) {
                if(val.month() !== this.month.month()) {
                    return 'removeDay';
                }
                for(let i = 0; i < this.propuesta.dias.length; i++) {
                    if(val.format('YYYY-MM-DD') == this.$moment(this.propuesta.dias[i].fecha).format('YYYY-MM-DD')) {
                        return this.propuesta.dias[i].tipo;
                    }
                }
                return 'none';
            },
            toggleDays(day) {
                if(this.propuesta.dias.length == 0) {
                    day.workingDay = 'all';
                    this.propuesta.dias.push(day);
                }else {
                    let notExist = true;
                    for (let i = 0; i < this.propuesta.dias.length; i++) {
                        if (day.date.format('YYYY-MM-DD') == this.$moment(this.propuesta.dias[i].fecha).format('YYYY-MM-DD')) {
                            notExist = false;
                            switch (day.tipo) {
                                case 'all':
                                    day.tipo = 'morning';
                                    this.propuesta.dias[i] = day;
                                    break;
                                case 'morning':
                                    day.tipo = 'night';
                                    this.propuesta.dias[i] = day;
                                    break;
                                case 'night':
                                    day.tipo = 'none';
                                    this.propuesta.dias.splice(i, 1);
                                    break;
                            }
                        }
                    }
                    if(notExist) {
                        day.tipo = 'all';
                        this.propuesta.dias.push(day);
                    }
                }
            },
            isAvailable(date) {
                if(date > this.selected) {
                    return true;
                }else {
                    return false;
                }
            },
            getClass(day) {
                return this.inArray(day.date);
            },
            previous() {
                let next = this.month.clone();
                // Limpio el mes
                this.removeTime(next.month(next.month() - 1).date(1));
                // Lo rearmo con los nuevos días
                this.month.month(this.month.month() - 1);
                this.buildMonth(next, this.month);
            },
            next() {
                let next = this.month.clone();
                // Limpio el mes
                this.removeTime(next.month(next.month() + 1).date(1));
                // Lo rearmo con los nuevos días
                this.month.month(this.month.month() + 1);
                this.buildMonth(next, this.month);
            },
            cancelarPropuesta() {
                this.propuesta.estado = "rechazada";
                this.$http.put(`api/propuesta/${this.propuesta.id}`, this.propuesta)
				.then( res => {
                    this.$router.push({name: 'Mensaje', params: { id: this.propuesta.evento_id }});
				}, err => {
                    this.$toastr.error(err, "Hubo un error al intentar cancelar la propuesta");
				});
			},
            pagoPropuesta() {
                this.$router.push({name: 'pagopropuesta', params: { id: this.propuesta.id }});
                if(this.propuesta.user_id === this.$store.getters.getUser.id) {
                    this.propuesta.aprueba_duenio = true;
                    this.$http.put(`api/propuesta/${this.propuesta.id}`, this.propuesta)
					.then(res => {
                        this.$toastr.success("La propuesta fue aprobada, falta la aprobación del cliente", "Propuesta aprobada");
						this.$router.push({name: 'Mensaje', params: {id: this.propuesta.evento_id}});
					}, err => {
						this.$toastr.error(err, "Hubo un error al intentar aprobar la propuesta");
					});
                }
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
	.select__mount {
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 12px;
		color: #212121;
		margin: 2em;
	}
	.calendar-table {
		transition: none;
		font-family: Avenir;
		font-size: 10px;
		text-align: center;
		color: #212121;
		margin: 2em;
		th, td {
			width: 50px;
			height: 40px;
			text-align: center;
		}
		td {
			transition: none;
			background-color: #eeeeee;
			border: 1px solid #fff;
			cursor: pointer;
			position: relative;
			&:hover {background-color: rgba(238, 238, 238, 0.5)}
			span {
				position: absolute;
				top: .5em;
				left: .5em;
			}
		}
		.removeDay {
			background-color: #fff;
			color: #fff;
			border: 1px solid #fff;
			cursor: none;
		}
		.all {
			transition: none;
			background-color: #fc5289;
			color: #fff;
			border: 1px solid #fff;
			cursor: pointer;
			&:hover {background-color: rgba(252, 82, 137, 0.8)};
		}
		.morning {
			transition: none;
			background: linear-gradient(to bottom, #fc5289 50%, #eeeeee 50%, #eeeeee 99%);
			color: #fff;
			border: 1px solid #fff;
			cursor: pointer;
		}
		.night {
			transition: none;
			background: linear-gradient(to bottom, #eeeeee 0%, #eeeeee 50%, #fc5289 50%, #fc5289 100%);
			border: 1px solid #fff;
			cursor: pointer;
		}
	}
</style>