<template>
	<aside id="aside-reserva" class="box-reserva-mobile">
		<header class="box-reserva__header">
			<p class="box-reserva__header__desde">Desde</p>
			<div class="box-reserva__header__price">
				<p class="price">$ {{price}}.- ARS</p>
				<p class="minhours">por hora (mínimo {{minhours}} hr.)</p>
			</div>
		</header>
		<section class="box-reserva-mobile__body">
			<div class="box-contenedor">
				<div class="box-contenedor__chield">
					<label for="activity">Tipo actividad</label>
					<select class="wt-dropdown" v-model="category" @change="changeCategory()">
						<option v-for="cat in categories" v-bind:value="cat.id">{{cat.name}}</option>
					</select>
				</div>
				<div class="box-contenedor__chield">
					<label for="people">Invitados</label>
	                <input type="text" class="wt-dropdown" v-model="people" :placeholder="`Máximo ${espacio.quanty} persónas.`">
				</div>
			</div>
			<div class="box-contenedor wt-m-top-2">
				<div class="box-contenedor__chield">
					<label for="inicio">Inicio</label>
					<input type="text" id="inicio" class="wt-dropdown" placeholder="Check-In" />
				</div>
				<div class="box-contenedor__chield">
					<label for="fin">Fin</label>
	                <input type="text" id="fin" class="wt-dropdown" placeholder="Check-Out" />
				</div>
	        </div>
	        <div>
	            <div class="wt-m-top-2">
	                <strong>PRECIO</strong>
					<div class="box-contenedor">
						<span>Espacio (por {{totalHoras}}hs)</span>
						<span>$ {{subTotal}}</span>
					</div>
					<div class="box-contenedor">
						<span>Fee de procesamiento</span>
						<span>$ {{fee}}</span>
					</div>
					<div class="box-contenedor">
						<span>Precio estimado</span>
						<span class="precio-estimado">$ {{total}}</span>
					</div>
	                <div class="iva-no-incluido">
	                    <span>IVA no incluido</span>
	                </div>
	            </div>
			</div>
			<div class="wt-center-column wt-m-top-2">
				<label for="title">Título del evento</label>
				<input v-model="title" id="title" placeholder="Ej.: Workshop Google for entrepreneurs" class="wt-dropdown">
			</div>
			<div class="wt-center-column wt-m-top-2">
				<label for="mensaje">Mensaje</label>
                <textarea v-model="mensaje" id="mensaje" class="box-reserva-mobile__body__textarea-lg" rows="7" placeholder="Preséntate, describe la actividad que estas planificando y cuéntale cómo utilizarás el espacio. Necesitarás servicios de catering, técnica o producción? 
Ej: Hola, mi nombre es Paco y quiero organizar un Workshop para 30 personas. Vamos a necesitar mesas y un servicio de Coffee Break. Puede incluirlo en la propuesta? Puedo llevar mi propio catering?"></textarea>
			</div>
	        <div v-if="(messageError != '')" class="messageError">
	            <p>{{messageError}}</p>
	            <i class="fa fa-times cursor-pointer" aria-hidden="true" @click="closeMsg()"></i>
	        </div>
	        <div v-if="user != ''">
	            <button v-show="btnSend" class="btn-reserva wt-m-top-2" @click="sendReserva()">CONTACTAR AL ANFITRIÓN</button>
				<button v-show="!btnSend" class="btn-reserva wt-m-top-2">
					<img src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-white.svg" alt="Cargando ..." height="50px" />
				</button>
				<!--button class="btn-reserva-transparent wt-m-top-1">QUIERO VISITAR EL ESPACIO</button-->
	        </div>
	        <div v-if="user == ''">
	            <button class="btn-reserva wt-m-top-2"><a href="/login">CONTACTAR AL ANFITRIÓN</a></button>
	            <!--button class="btn-reserva-transparent wt-m-top-1"><a href="/login">QUIERO VISITAR EL ESPACIO</a></button-->
	        </div>
		</section>
	</aside>
</template>
<script>
    import swal from 'sweetalert';
	export default {
	    props: [
            'espacioId',
            'avatarUrl',
            'nombreAnfitrion',
            'price',
            'minhours',
            'categoryId',
        ],
        data() {
            return {
                authenticated: this.$auth.isAuthenticated(),
                user: null,
        		messageError: '',
        		people: '',
        		category: this.categoryId,
        		categories: [],
                espacio: '',
        		inicio: '',
                fin: '',
        		totalHoras: 1,
                fee: '-',
        		subTotal: this.price,
        		total: '-',
                modalReserva: false,
                modalFechas: false,
                title: '',
                mensaje: '',
                btnSend: true
        	}
        },
        mounted() {
            this.getUserAuthenticated();
            this.getCategories();
        },
        created() {
            this.checkFechas();
        },
        methods: {
        	getCategories() {
        		this.$http.get(`/api/espacio/${this.espacioId}`)
                .then(res => {
                    this.espacio = res.body;
                    this.categories = this.espacio.categorias;
                }, err => {
                    console.log(err);
                });
        	},
            changeCategory() {
                window.location = `/categoria/${this.category}/espacio/${this.espacioId}`;
            },
            closeMsg() {
                this.messageError = '';
            },
            sendReserva() {
        	    console.log(this.category);
                if(this.people == "") {
                    this.messageError = `Debe ingresar cantidad de invitados`;
                    setInterval(function () {
                		this.messageError = '';
                    }.bind(this), 4000);
                    return;
                }
                if(this.people > this.espacio.quanty) {
                    this.messageError = `La cantidad de invitados máxima es ${this.espacio.quanty}`;
                    setInterval(function () {
                		this.messageError = '';
                    }.bind(this), 4000);
                    return;
                }
                let inicio = this.$moment(this.inicio);
                let fin = this.$moment(this.fin);
                let totalHoras = this.checkDiffDates(fin, inicio);

                if(this.title == "") {
                    this.messageError = `Debe ingresarle un nombre a su evento`;
                    setInterval(function () {
                        this.messageError = '';
                    }.bind(this), 4000);
                    return;
                }
                if(this.inicio == "" && this.fin == "") {
                    this.messageError = `Debe ingresar una fecha de inicio y fin`;
                    setInterval(function () {
                        this.messageError = '';
                    }.bind(this), 4000);
                    return;
                }
                this.loadingConsulta = false;
                this.btnSend = false;
                let body = {
                    'title': this.title,
                    'clientId': this.user.id,
                    'espacioId': this.espacioId,
                    'category': this.category,
                    'invitados': this.people,
                    'price': this.price,
                    'totalHoras': this.totalHoras,
                    'reserva_desde': this.inicio,
                    'reserva_hasta': this.fin,
                    'mensaje': this.mensaje,
                    'fee': this.fee,
                    'subTotal': this.subTotal,
                    'total': this.total
                }
                localStorage.removeItem("consultaInicio");
                localStorage.removeItem("consultaFin");
                this.$http.post(`api/sendreserva`, body)
                .then(res => {
                    window.location.href = `/thankyou/${this.user.id}`;
                }, err => {
                	this.btnSend = true;
                    console.log(err);
                    swal(err.message);
                });
            },
            getUserAuthenticated() {
                if(this.$auth.isAuthenticated()) {
                    this.user = this.$auth.getUser();
                }
            },
            checkFechas() {
                setInterval(function () {
                    let inicio = 0;
                    let fin = 0;
                    if(localStorage.getItem("consultaInicio") !== null && localStorage.getItem("consultaFin") !== null)
                    {
                        inicio = this.$moment(localStorage.getItem("consultaInicio"));
                        fin = this.$moment(localStorage.getItem("consultaFin"));
                        
                        let totalHoras = this.checkDiffDates(fin, inicio);

                        this.inicio = inicio.format("DD/MM/YYYY HH:mm a");
                        this.fin = fin.format("DD/MM/YYYY HH:mm a");

                        document.getElementById("inicio"). value = this.inicio;
                        document.getElementById("fin"). value = this.fin;

                        if(totalHoras.minute() > 0) {
                            totalHoras.add(30, 'minutes');
                        }
                        this.totalHoras = (this.checkDiffDates(fin, inicio)).hours();
                        this.subTotal = totalHoras.hours() * this.price;
                        this.fee = (this.subTotal * 5)/100;
                        this.total = this.subTotal + this.fee;
                    }
                }.bind(this), 4000); 
            },
            checkDiffDates(end, start) {
                let fin = this.$moment(end);
                let inicio = this.$moment(start);
                return this.$moment.utc(fin.diff(inicio));
            }
        }
	}
</script>