<template>
	<div>
		<div class="container-center">
			<h3>Disponibilidad</h3>
			<h4 class="wt-m-top-2">Elige los días que tu espacio podría estar disponible.</h4>
			<div class="container-disponibilidad-btn-default">
				<button 
					@click="addDisponibilidad('lunes')" 
					:class="estaDisponible('lunes')">
					Lunes
				</button>
				<button 
					@click="addDisponibilidad('martes')" 
					:class="estaDisponible('martes')">
					Martes
				</button>
				<button 
					@click="addDisponibilidad('miercoles')" 
					:class="estaDisponible('miercoles')">
					Miércoles
				</button>
				<button 
					@click="addDisponibilidad('jueves')" 
					:class="estaDisponible('jueves')">
					Jueves
				</button>
				<button 
					@click="addDisponibilidad('viernes')" 
					:class="estaDisponible('viernes')">
					Viernes
				</button>
				<button 
					@click="addDisponibilidad('sabado')" 
					:class="estaDisponible('sabado')">
					Sábado
				</button>
				<button 
					@click="addDisponibilidad('domingo')" 
					:class="estaDisponible('domingo')">
					Domingo
				</button>
			</div>
			<div class="tipo-disponibilidad-box">
				<div>
					<input type="radio" id="customizado" name="tipo-disponibilidad" style="display: none" v-model="tipoDisponibilidad" value="customizado">
					<label for="customizado" class="wt-publica-label">Especificar horarios</label>
				</div>
				<div>
					<input type="radio" id="todo-el-dia" name="tipo-disponibilidad" style="display: none" v-model="tipoDisponibilidad" value="todo-el-dia">
					<label for="todo-el-dia" class="wt-publica-label wt-m-lf-3">Todo el día</label>
				</div>
				<div>
					<input type="radio" id="no-servicio" name="tipo-disponibilidad" style="display: none" v-model="tipoDisponibilidad" value="no-servicio">
					<label for="no-servicio" class="wt-publica-label wt-m-lf-3">No hay servicio</label>
				</div>
			</div>
			<div v-if="(tipoDisponibilidad == 'customizado')" class="disponibilidad-tiempos">
				<div class="wt-center-column">
					<label for="inicio">Inicio</label>
					<select name="inicio" v-model="inicio" class="wt-dropdown-min">
						<option value="">Seleccionar</option>
						<option v-for="item in horas" :value="item.value">{{item.label}}</option>
					</select>
				</div>
				<div class="wt-center-column">
					<label for="fin">Fin</label>
					<select name="fin" v-model="fin" class="wt-dropdown-min">
						<option value="">Seleccionar</option>
						<option v-for="item in horas" :value="item.value">{{item.label}}</option>
					</select>
				</div>
			</div>
			<button class="btn-primary-pig" @click="agruparDiasHoras()">AGREGAR</button>
			<hr>
			<div class="wt-m-bot-4">
				<div v-for="item in agrupadorDias" class="wt-space-block">
					<span>{{item.dia}}</span>
					<span>{{item.inicio}} a {{item.fin}} hs. <i class="fa fa-trash cursor-pointer" @click="removeDisponibilidad(item)"></i></span>
				</div>
			</div>
		</div>
		<div class="buttons" id="second-buttons">
			<a href="#" @click="backPage($event)" class="btn-volver">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
				<span>ATRÁS</span>
			</a>
			<a class="btn wt-btn-primary" href="#" @click="saveDisponibilidad($event)">CONTINUAR</a>
		</div>
	</div>
</template>

<script>
	import swal from 'sweetalert';
	export default {
		props: [
			'espacioId',
		],
		data() {
			return {
				disponibilidad: [],
        		horas: [
        			{value: '08:00AM', label: '08:00AM'},
        			{value: '8:30AM', label: '08:30AM'},
        			{value: '09:00AM', label: '09:00AM'},
        			{value: '09:30AM', label: '09:30AM'},
        			{value: '10:00AM', label: '10:00AM'},
        			{value: '10:30AM', label: '10:30AM'},
        			{value: '11:00AM', label: '11:00AM'},
        			{value: '11:30AM', label: '11:30AM'},
        			{value: '12:00AM', label: '12:00PM'},
        			{value: '12:30AM', label: '12:30PM'},
        			{value: '01:00PM', label: '01:00PM'},
        			{value: '01:30PM,', label: '01:30PM'},
        			{value: '02:00PM', label: '02:00PM'},
        			{value: '02:30PM', label: '02:30PM'},
        			{value: '03:00PM', label: '03:00PM'},
        			{value: '03:30PM', label: '03:30PM'},
        			{value: '04:00PM', label: '04:00PM'},
        			{value: '04:30PM', label: '04:30PM'},
        			{value: '05:00PM', label: '05:00PM'},
        			{value: '05:30PM', label: '05:30PM'},
        			{value: '06:00PM', label: '06:00PM'},
        			{value: '06:30PM', label: '06:30PM'},
        			{value: '07:00PM', label: '07:00PM'},
        			{value: '07:30PM', label: '07:30PM'},
        			{value: '08:00PM', label: '08:00PM'},
        			{value: '08:30PM', label: '08:30PM'},
        			{value: '09:00PM', label: '09:00PM'},
        			{value: '09:30PM', label: '09:30PM'},
        			{value: '10:00PM', label: '10:00PM'},
        			{value: '10:30PM', label: '10:30PM'},
        			{value: '11:00PM', label: '11:00PM'},
        			{value: '11:30PM', label: '11:30PM'},
        			{value: '12:00AM', label: '12:00AM'},
        			{value: '12:30AM', label: '12:30AM'},
        			{value: '01:00AM', label: '01:00AM'},
        			{value: '01:30AM', label: '01:30PM'},
        			{value: '02:00AM', label: '02:00PM'},
        			{value: '02:30AM', label: '02:30PM'},
        			{value: '03:00AM', label: '03:00AM'},
        			{value: '03:30AM', label: '03:30AM'},
        			{value: '04:00AM', label: '04:00AM'},
        			{value: '04:30AM', label: '04:30AM'},
        			{value: '05:00AM', label: '05:00AM'},
        			{value: '05:30AM', label: '05:30AM'},
        			{value: '06:00AM', label: '06:00AM'},
        			{value: '06:30AM', label: '06:30AM'},
        			{value: '07:00AM', label: '07:00AM'},
        			{value: '07:30AM', label: '07:30AM'}
        		],
				inicio: '',
				fin: '',
				agrupadorDias: [],
				tipoDisponibilidad: 'customizado'
			}
		},
		mounted() {
            this.getDisponibilidades();
        },
        methods: {
            getDisponibilidades() {
            	this.$http.get(`/api/disponibilidad/${this.espacioId}`)
                .then(res => {
                    this.agrupadorDias = res.body;
                });
            },
        	estaDisponible(day) {
        		let aux = this.disponibilidad.indexOf(day);
        		if(aux == -1) {
        			return;
        		}else {
        			return "btn-disponibilidad--active";
        		}
        	},
        	addDisponibilidad(day) {
        		let aux = this.disponibilidad.indexOf(day);
        		if(aux > -1) {
        			this.disponibilidad.splice(aux, 1);
        		}else {
        			let vm = this;
        			this.agrupadorDias.forEach((element) => {
        				if(element.dia == day) {
        					swal('Día ya seleccionado', `El dia ${day} ya posee una configuración.`, 'error');
        					return;
        				}
        			});
        			this.disponibilidad.push(day);
        		}
        	},
        	removeDisponibilidad(item) {
        		let aux = this.agrupadorDias.indexOf(item);
        		if(aux > -1) {
        			this.agrupadorDias.splice(aux, 1);
        		}
        	},
        	agruparDiasHoras() {
        		if(this.tipoDisponibilidad == "todo-el-dia") {
        			this.inicio = '0';
        			this.fin = '24';
        		}else if(this.tipoDisponibilidad == "no-servicio") {
        			this.inicio = '0';
        			this.fin = '0';
        		}
        		
        		let vm = this;
        		if(this.disponibilidad.length < 1 || this.inicio == '' || this.fin == '') {
        			swal('Campos requeridos!', 'Debe seleccionar algún dia y horarios de disponibilidad', 'error');
        			return;
        		}
        		this.disponibilidad.forEach((element) => {
        			vm.agrupadorDias.push({
        				espacio_id: this.espacioId,
	        			dia: element,
	        			inicio: vm.inicio,
	        			fin: vm.fin
	    			});
        		});
    			this.inicio = '';
    			this.fin = '';
    			this.disponibilidad = [];
        	},
            timeFormat(time) {
                let timeformat = time.toString().split('.');
                let res = time % 2;
                if(res > 0) {
                    return `${timeformat[0]}:30`;
                }else {
                    return `${timeformat[0]}:00`;
                }
            },
            saveDisponibilidad(e){
            	e.preventDefault();
            	this.$http.post(`/api/disponibilidad`, this.agrupadorDias)
            	.then(res => {
            		console.log(res);
            		if(res.status == 200) {
            			window.location.href = `/publicar/tercer-paso/espacio/${this.espacioId}/cancelacion`
            		}
            	});
            },
            backPage(e) {
            	e.preventDefault();
            	window.location.href = `/publicar/tercer-paso/espacio/${this.espacioId}/prices`;
            }
        }
    }
</script>

<style lang="sass">
	.container-disponibilidad-btn-default {
		margin: 2em 0;
		button {
			width: 76px;
			height: 40px;
			background-color: #ffffff;
			border: none;
			&:hover {
				color: rgba(226, 56, 90, 1);
				border: solid 1px rgba(226, 56, 90, 1);
				border-radius: 2px;
				transition: none;
			}
		}
		.btn-disponibilidad--active {
			width: 76px;
			height: 40px;
			background-color: rgba(226, 56, 90, 1);
			color: #ffffff;
			border: none;
			border-radius: 2px;
			&:hover {
				background-color: rgba(226, 56, 90, 0.87);
				color: #ffffff;
				transition: none;
			}
		}
	}
	.disponibilidad-tiempos {
		width: 23%;
	    display: flex;
	    justify-content: space-between;
	    margin-bottom: 2em;
	}
	.tipo-disponibilidad-box {
		display: flex;
		margin-bottom: 2em;
	}
</style>