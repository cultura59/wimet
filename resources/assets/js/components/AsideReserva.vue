<template>
	<aside class="box-reserva">
		<header class="box-reserva__header">
			<p class="box-reserva__header__desde">Desde</p>
			<div class="box-reserva__header__price">
				<p class="price">$ {{price}}.- ARS</p>
				<p class="minhours">por hora (mínimo {{minhours}} hr.)</p>
			</div>
		</header>
		<section class="box-reserva__body">
			<div class="wt-space-block">
				<div class="wt-center-column">
					<label for="activity">Tipo actividad</label>
					<select class="wt-dropdown" v-model="category" @change="changeCategory()">
						<option v-for="cat in categories" v-bind:value="cat.id">{{cat.name}}</option>
					</select>
				</div>
				<div class="wt-center-column">
					<label for="people">Invitados</label>
					<select name="people" id="people" class="wt-dropdown" v-model="people">
						<option value="">Seleccionar</option>
						<option value="0-10">0 - 10</option>
						<option value="11-20">11 - 20</option>
						<option value="21-30">21 - 30</option>
						<option value="31-40">31 - 40</option>
						<option value="41-50">41 - 50</option>
						<option value="51-60">51 - 60</option>
						<option value="61-70">61 - 70</option>
						<option value="71-80">71 - 80</option>
						<option value="81-90">81 - 90</option>
						<option value="91-100">91 - 100</option>
						<option value="100+">100 +</option>
					</select>
				</div>
			</div>
			<div class="wt-space-block wt-m-top-2">
				<div class="wt-center-column">
					<label for="fecha">Fecha</label>
					<input type="date" id="fecha" v-model="fecha" class="wt-dropdown"/>
				</div>
				<div class="wt-center-column">
					<label for="inicio">Inicio</label>
					<select id="inicio" v-model="inicio" class="wt-dropdown-min">
						<option value="">Seleccionar</option>
						<option v-for="item in horas2" v-bind:value="item.value">{{item.label}}</option>
					</select>
				</div>
				<div class="wt-center-column">
					<label for="fin">Fin</label>
					<select id="fin" v-model="fin" class="wt-dropdown-min" @change="addDate()">
						<option value="">Seleccionar</option>
						<option v-for="item in horas2" v-bind:value="item.value">{{item.label}}</option>
					</select>
				</div>
			</div>
			<div class="wt-m-top-2">
				<span class="agregar-fecha">Agregar fecha</span>
				<ul>
					<li class="list-dates" v-for="item in totalFechas">
						<span>{{item.fecha}} desde {{item.inicio}}hs hasta {{item.fin}}hs</span>
					</li>
				</ul>
			</div>
			<div class="wt-m-top-2">
				<strong>PRECIO</strong>
				<div class="wt-space-block wt-m-top-1">
					<span>Espacio (por {{totalHoras}}hs)</span>
					<span>$ {{subTotal}}</span>
				</div>
				<div class="wt-space-block wt-m-top-1">
					<span>Fee de procesamiento</span>
					<span>$ {{fee}}</span>
				</div>
				<div class="wt-space-block wt-m-top-1">
					<span>Precio estimado</span>
					<span>$ {{total}}</span>
				</div>
			</div>
			<button class="wt-btn-aqua wt-m-top-2" @click="reservar()">SOLICITUD DE RESERVA</button>
			<div v-if="messageError" class="messageError">
				<p>El mínimo de horas es {{minhours}}</p>
			</div>
		</section>
	</aside>
</template>
<script>
    export default {
    	props: [
    		'espacioId',
            'price',
            'minhours',
            'categoryId'
        ],
        data() {
        	return {
        		messageError: false,
        		people: '',
        		category: this.categoryId,
        		categories: [],
        		horas: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24],
        		horas2: [
        			{value: 8, label: '8'},
        			{value: 8.5, label: '8:30'},
        			{value: 9, label: '9'},
        			{value: 9.5, label: '9:30'},
        			{value: 10, label: '10'},
        			{value: 10.5, label: '10:30'},
        			{value: 11, label: '11'},
        			{value: 11.5, label: '11:30'},
        			{value: 12, label: '12'},
        			{value: 12.5, label: '12:30'},
        			{value: 13, label: '13'},
        			{value: 13.5, label: '13:30'},
        			{value: 14, label: '14'},
        			{value: 14.5, label: '14:30'},
        			{value: 15, label: '15'},
        			{value: 15.5, label: '15:30'},
        			{value: 16, label: '16'},
        			{value: 16.5, label: '16:30'},
        			{value: 17, label: '17'},
        			{value: 17.5, label: '17:30'},
        			{value: 18, label: '18'},
        			{value: 18.5, label: '18:30'},
        			{value: 19, label: '19'},
        			{value: 19.5, label: '19:30'},
        			{value: 20, label: '20'},
        			{value: 20.5, label: '20:30'},
        			{value: 21, label: '21'},
        			{value: 21.5, label: '21:30'},
        			{value: 22, label: '22'},
        			{value: 22.5, label: '22:30'},
        			{value: 23, label: '23'},
        			{value: 23.5, label: '23:30'},
        			{value: 24, label: '24'},
        			{value: 24.5, label: '24:30'},
        			{value: 1, label: '1'},
        			{value: 1.5, label: '1:30'},
        			{value: 2, label: '2'},
        			{value: 2.5, label: '2:30'},
        			{value: 3, label: '3'},
        			{value: 3.5, label: '3:30'},
        			{value: 4, label: '4'},
        			{value: 4.5, label: '4:30'},
        			{value: 5, label: '5'},
        			{value: 5.5, label: '5:30'},
        			{value: 6, label: '6'},
        			{value: 6.5, label: '6:30'},
        			{value: 7, label: '7'},
        			{value: 7.5, label: '7:30'}
        		],
        		fecha: '',
        		inicio: '',
        		fin: '',
        		fee: '-',
        		totalHoras: 1,
        		totalFechas: [],
        		subTotal: this.price,
        		total: '-'
        	}
        },
        mounted() {
            this.getCategories();
            this.calFee();
        },
        methods: {
        	getCategories() {
        		this.$http.get(`/api/categoria`)
                .then(res => {
                    this.categories = res.body;
                }, err => {
                    console.log(err);
                });
        	},
            changeCategory() {
                window.location = `/categoria/${this.category}/espacio/${this.espacioId}`;
            },
        	calFee() {
        		this.fee = (this.subTotal * 5)/100;
        	},
        	addDate() {
        		this.totalFechas = [{
        			'fecha': this.fecha,
        			'inicio': this.timeFormat(this.inicio),
        			'fin': this.timeFormat(this.fin)
        		}];
        		this.totalHoras = this.isPar((this.fin - this.inicio));
        		this.subTotal = (this.totalHoras * this.price);
        		this.calFee();
        		this.total = this.subTotal + this.fee;
        	},
        	reservar() {
        		if(this.totalHoras < this.minhours) {
        			this.messageError = true;
        		}else {
        			sessionStorage.setItem('espacioId', this.espacioId);
        			sessionStorage.setItem('price', this.price);
        			sessionStorage.setItem('people', this.people);
        			sessionStorage.setItem('category', this.category);
        			sessionStorage.setItem('totalFechas', JSON.stringify(this.totalFechas));
        			sessionStorage.setItem('totalHoras', this.totalHoras);
        			sessionStorage.setItem('fee', this.fee);
        			sessionStorage.setItem('subTotal', this.subTotal);
        			sessionStorage.setItem('total', this.total);
        			window.location = `/espacio/${this.espacioId}/reserva`;
        		}
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
            isPar(time) {
                let res = time % 1;
                if(res != 0) {
                    return time + 0.5;
                }else {
                    return time;
                }
            }
        }
    }
</script>