<template>
	<div>
		<router-link to="/propuestas" class="left-icon"><img src="https://res.cloudinary.com/wimet/image/upload/v1515117772/icons/ic_left.svg"> ATRAS</router-link>
		<div class="container-propuesta">
			<span class="container-propuesta__title">NUEVA PROPUESTA</span>
		</div>
		<div class="propuesta-main">
			<div class="row">
				<div class="col-md-8">
					<div>
						<h4>Detalle del evento</h4>
						<div class="row wt-m-top-2">
							<div class="col-md-6 form-group">
								<label>Nombre evento</label>
								<input type="text" placeholder="Ingrese nombre del evento" v-model="evento.nombre">
							</div>
							<div class="col-md-6 form-group">
								<label>Espacio</label>
								<select v-model="espacioSelected">
									<option :value="{}">Seleccione espacio</option>
									<option v-for="espacio in espacios" :value="espacio">{{espacio.name}}</option>
								</select>
							</div>
							<div class="col-md-6 form-group">
								<label>Cantidad de invitados</label>
								<input type="text" placeholder="Ingrese cantidad de asistentes" v-model="evento.invitados">
							</div>
							<div class="col-md-6 form-group">
								<label>Tipo de actividad</label>
								<select v-model="categoriaSelected">
									<option :value="{}">Seleccione actividad</option>
									<option v-for="cat in categorias" :value="cat">{{cat.name}}</option>
								</select>
							</div>
						</div>
						<h4 class="wt-m-top-2">Datos cliente</h4>
						<div class="row">
							<div class="col-md-6 form-group">
								<label>Nombre organizador</label>
								<input type="text" placeholder="Ingrese nombre del cliente" v-model="user.firstname">
							</div>
							<div class="col-md-6 form-group">
								<label>Apellido organizador</label>
								<input type="text" placeholder="Ingrese apellido del cliente" v-model="user.lastname">
							</div>
							<div class="col-md-6 form-group">
								<label>Email organizador</label>
								<input type="text" placeholder="Ingrese email del cliente" v-model="user.email">
							</div>
							<div class="col-md-6 form-group">
								<label>Teléfono organizador</label>
								<input type="text" placeholder="Ingrese teléfono del cliente" v-model="user.phone">
							</div>
						</div>
						<h4 class="wt-m-top-2">Presupuesto</h4>
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
									<td class="col-md-2">-</td>
									<td class="col-md-2">-</td>
									<td class="col-md-2">
										<input type="text" placeholder="$ 10000" class="pull-right text-center" v-model="evento.sub_total" @change="changeSubTotal()">
									</td>
								</tr>
								<tr class="active" v-for="(servicio, index)  in servicios">
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
								<span>$ {{total_servicios}}</span>
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
								<tr class="active" v-for="pago in pagos">
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
					<h4>Fechas del evento</h4>
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
						<textarea v-model="evento.condiciones" cols="30" rows="10"></textarea>
					</div>
				</div>
				<button class="modalServicios__content__btn" @click="modalTerminos = false">AGREGAR</button>
			</div>
		</div>
		<div v-show="modalVistaPrevia" class="modalServicios">
			<div class="modalServicios__content">
				<div class="wt-space-block">
					<strong class="title">PRESUPUESTO</strong>
					<div>
						<button class="send-propuesta" @click="crearPropuesta()">GUARDAR</button>
						<span class="close" @click="modalVistaPrevia = false">&times;</span>
					</div>
				</div>
				<div class="wt-m-top-3">
					<div class="row">
						<div class="col-md-6">
							<img :src="espacioSelected.portada" alt="espacio.nombre" class="img-responsive">
						</div>
						<div class="col-md-6 wt-center-column">
							<span class="wt-m-bot-1"><strong>Estado:</strong> Propuesta</span>
							<span class="wt-m-bot-1"><strong>Actividad:</strong> {{categoriaSelected.name}}</span>
							<span class="wt-m-bot-1"><strong>Invitados:</strong> {{evento.invitados}}</span>
							<strong class="wt-m-bot-1">Fechas solicitadas</strong>
							<ul>
								<li v-for="dia in selected" :key="dia.id" class="wt-m-lf-3">
									<span v-if="dia.workingDay == 'all'">{{$moment(dia.date).locale('es').format("D MMM YYYY")}} (jornada completa)</span>
									<span v-if="dia.workingDay == 'morning'">{{$moment(dia.date).locale('es').format("D MMM YYYY")}} (media jornada - am)</span>
									<span v-if="dia.workingDay == 'night'">{{$moment(dia.date).locale('es').format("D MMM YYYY")}} (media jornada - pm)</span>
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
							<td class="col-md-2 text-center">{{evento.sub_total}}</td>
						</tr>
						<tr class="active" v-for="(servicio, index)  in servicios">
							<td class="col-md-6">{{servicio.sdescripcion}}</td>
							<td class="col-md-2 text-center">${{servicio.simporte}}</td>
							<td class="col-md-2 text-center">{{servicio.scantidad}}</td>
							<td class="col-md-2 text-center">${{servicio.stotal}}</td>
						</tr>
						</tbody>
					</table>
					<div class="box-detalle-total">
						<span><strong>Total</strong> ${{total_servicios}}</span>
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
						<tr class="active" v-for="pago in pagos">
							<td>{{pago.pdescripcion}}</td>
							<td class="text-center">-</td>
							<td class="text-center">{{pago.pestado}}</td>
							<td class="text-center">{{pago.pvencimiento}}</td>
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
		</div>
	</div>
</template>

<script>
	export default {
        name: "propuesta-custom",
		data() {
			return {
			    user: {},
				evento: {},
				pagos: [],
				servicios: [],
				newServicio: {
                    sdescripcion: '',
					simporte: 0,
					scantidad: 0,
					stotal: 0
				},
                espacios: [],
				espacioSelected: {},
				categorias: [],
				categoriaSelected: {},
                selected: this.$store.getters.getCategoriesSelected,
                dias: [],
                showLoading: false,
                fee: 1800,
				date: '',
                lastDay: '',
				total_servicios: 0,
                modalServicios: false,
                modalTerminos: false,
                modalVistaPrevia: false,
                month: '',
                weeks: []
			}
		},
        created() {
            this.getEspacios();
            this.getCategorias();
            this.startCalendar();
        },
        methods: {
            getEspacios() {
                this.$http.get(`api/espacio?user=${this.$store.getters.getUser.id}&status=1`)
				.then(res => {
					this.espacios = res.body.data;
				}, err => {
					console.log(err);
				});
            },
            getCategorias() {
                this.$http.get(`api/categoria`)
                    .then(res => {
                        this.categorias = res.body;
                    }, err => {
                        console.log(err);
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
                        date: date,
                        workingDay: this.inArray(date)
                    });
                    date = date.clone();
                    date.add(1, "d");
                }
                return days;
            },
            toggleDays(day) {
                if(this.selected.length == 0) {
                    day.workingDay = 'all';
                    this.selected.push(day);
                    this.$store.commit('setCategoriesSelected', this.selected);
                }else {
                    let notExist = true;
                    for (let i = 0; i < this.selected.length; i++) {
                        if (day.date.format('YYYY-MM-DD') == this.$moment(this.selected[i].date).format('YYYY-MM-DD')) {
                            notExist = false;
                            switch (day.workingDay) {
                                case 'all':
                                    day.workingDay = 'morning';
                                    this.selected[i] = day;
                                    break;
                                case 'morning':
                                    day.workingDay = 'night';
                                    this.selected[i] = day;
                                    break;
                                case 'night':
                                    day.workingDay = 'none';
                                    this.selected.splice(i, 1);
                                    break;
                            }
                            this.$store.commit('setCategoriesSelected', this.selected);
                        }
                    }
                    if(notExist) {
                        day.workingDay = 'all';
                        this.selected.push(day);
                        this.$store.commit('setCategoriesSelected', this.selected);
                    }
                }
            },
            toggleDays(day) {
                if(this.selected.length == 0) {
                    day.workingDay = 'all';
                    this.selected.push(day);
                    this.$store.commit('setCategoriesSelected', this.selected);
                }else {
                    let notExist = true;
                    for (let i = 0; i < this.selected.length; i++) {
                        if (day.date.format('YYYY-MM-DD') == this.$moment(this.selected[i].date).format('YYYY-MM-DD')) {
                            notExist = false;
                            switch (day.workingDay) {
                                case 'all':
                                    day.workingDay = 'morning';
                                    this.selected[i] = day;
                                    break;
                                case 'morning':
                                    day.workingDay = 'night';
                                    this.selected[i] = day;
                                    break;
                                case 'night':
                                    day.workingDay = 'none';
                                    this.selected.splice(i, 1);
                                    break;
                            }
                            this.$store.commit('setCategoriesSelected', this.selected);
                        }
                    }
                    if(notExist) {
                        day.workingDay = 'all';
                        this.selected.push(day);
                        this.$store.commit('setCategoriesSelected', this.selected);
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
            removeTime(date) {
                return date.day(0).hour(0).minute(0).second(0).millisecond(0);
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
            inArray(val) {
                if(val.month() !== this.month.month()) {
                    return 'removeDay';
                }
                for(let i = 0; i < this.selected.length; i++) {
                    if(val.format('YYYY-MM-DD') == this.$moment(this.selected[i].date).format('YYYY-MM-DD')) {
                        return this.selected[i].workingDay;
                    }
                }
                return 'none';
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
                this.pagos = [];
                this.pagos.push({
					pdescripcion: 'Reserva',
					espacio_id: this.evento.espacio_id,
					ptotal: (this.evento.sub_total / 2),
					pvencimiento: this.$moment().add(5, 'days').format("YYYY-MM-DD"),
					pestado: 'Pendiente'
                });
                this.pagos.push({
					pdescripcion: 'Saldo',
					espacio_id: this.evento.espacio_id,
					ptotal: (this.evento.sub_total / 2),
					pvencimiento: this.lastDay,
					pestado: 'Pendiente'
                });
				this.total_servicios = this.evento.sub_total;
			},
            agregarServicio() {
                this.newServicio.stotal = (this.newServicio.simporte * this.newServicio.scantidad);
                this.total_servicios = parseInt(this.total_servicios) + parseInt(this.newServicio.stotal);
                this.servicios.push(this.newServicio);
                this.newServicio = {sdescripcion: '', simporte: 0, scantidad: 0, stotal: 0};
                this.modalServicios = false;
			},
			deleteServicio(e, index) {
                e.preventDefault();
                this.total_servicios = this.total_servicios - this.servicios[index].stotal;
                this.servicios.splice(index, 1);
			},
			crearPropuesta() {
                let data = {};
                data.user = this.user;
                data.duenio = this.$store.getters.getUser.id;
                data.categoriaSelected = this.categoriaSelected;
                data.espacioSelected = this.espacioSelected;
                data.evento = this.evento;
                data.pagos = this.pagos;
				data.total_servicios = this.total_servicios;
                data.fee = this.fee;
                data.dias = this.selected;
                data.servicios = this.servicios;
                this.$http.post('api/custom', data)
				.then(res => {
                    this.$router.push({name: 'Propuestas'});
				}, err => {
                    this.$toastr.error("Propuesta no enviada!", "Hubo un error al intentar enviar la propuesta, intente nuevamente");
				});
            }
        }
	}
</script>

<style lang="sass" scoped>
	h3, h4, strong {color: #333}
	input, select {
		display: block;
		width: 100%;
		height: 36px;
		padding: 6px 12px;
		font-size: 14px;
		color: #333;
		border: 1px solid #dadada;
		border-radius: 1px;
		background-color: #fff;
		-webkit-appearance: none;
		-webkit-border-radius: 2px;
	}
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