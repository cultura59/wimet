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
			<div>
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
        			{value: 8, label: '8:00'},
        			{value: 8.5, label: '8:30'},
        			{value: 9, label: '9:00'},
        			{value: 9.5, label: '9:30'},
        			{value: 10, label: '10:00'},
        			{value: 10.5, label: '10:30'},
        			{value: 11, label: '11:00'},
        			{value: 11.5, label: '11:30'},
        			{value: 12, label: '12:00'},
        			{value: 12.5, label: '12:30'},
        			{value: 13, label: '13:00'},
        			{value: 13.5, label: '13:30'},
        			{value: 14, label: '14:00'},
        			{value: 14.5, label: '14:30'},
        			{value: 15, label: '15:00'},
        			{value: 15.5, label: '15:30'},
        			{value: 16, label: '16:00'},
        			{value: 16.5, label: '16:30'},
        			{value: 17, label: '17:00'},
        			{value: 17.5, label: '17:30'},
        			{value: 18, label: '18:00'},
        			{value: 18.5, label: '18:30'},
        			{value: 19, label: '19:00'},
        			{value: 19.5, label: '19:30'},
        			{value: 20, label: '20:00'},
        			{value: 20.5, label: '20:30'},
        			{value: 21, label: '21:00'},
        			{value: 21.5, label: '21:30'},
        			{value: 22, label: '22:00'},
        			{value: 22.5, label: '22:30'},
        			{value: 23, label: '23:00'},
        			{value: 23.5, label: '23:30'},
        			{value: 24, label: '24:00'},
        			{value: 24.5, label: '24:30'},
        			{value: 1, label: '1:00'},
        			{value: 1.5, label: '1:30'},
        			{value: 2, label: '2:00'},
        			{value: 2.5, label: '2:30'},
        			{value: 3, label: '3:00'},
        			{value: 3.5, label: '3:30'},
        			{value: 4, label: '4:00'},
        			{value: 4.5, label: '4:30'},
        			{value: 5, label: '5:00'},
        			{value: 5.5, label: '5:30'},
        			{value: 6, label: '6:00'},
        			{value: 6.5, label: '6:30'},
        			{value: 7, label: '7:00'},
        			{value: 7.5, label: '7:30'}
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