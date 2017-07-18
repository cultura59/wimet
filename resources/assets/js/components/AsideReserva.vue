<template>
    <div>
    	<aside id="aside-reserva" class="box-reserva">
    		<header class="box-reserva__header">
    			<p class="box-reserva__header__desde">Desde</p>
    			<div class="box-reserva__header__price">
    				<p class="price">$ {{price}}.- ARS</p>
    				<p class="minhours">por hora (mínimo {{minhours}} hr.)</p>
    			</div>
    		</header>
    		<section class="box-reserva__body">
                <div v-if="(messageError != '')" class="messageError">
                    <p>{{messageError}}</p>
                    <i class="fa fa-times cursor-pointer" aria-hidden="true" @click="closeMsg()"></i>
                </div>
    			<div class="wt-space-block">
    				<div class="wt-center-column">
    					<label for="activity">Tipo actividad</label>
    					<select class="wt-dropdown" v-model="category" @change="changeCategory()">
    						<option v-for="cat in categories" v-bind:value="cat.id">{{cat.name}}</option>
    					</select>
    				</div>
    				<div class="wt-center-column">
    					<label for="people">Invitados</label>
                        <input type="text" class="wt-dropdown" v-model="people" :placeholder="`Máximo ${espacio.quanty} persónas.`">
    				</div>
    			</div>
    			<div class="wt-space-block wt-m-top-2">
    				<div class="wt-center-column">
    					<label for="fecha">Fecha</label>
    					<input type="date" id="fecha" v-model="fecha" class="wt-dropdown" @change="checkfechas()"/>
    				</div>
    				<div class="wt-center-column">
    					<label for="inicio">Inicio</label>
    					<select id="inicio" v-model="inicio" class="wt-dropdown-min">
    						<option value="">Seleccionar</option>
    						<option v-for="item in horas" v-bind:value="item.value">{{item.label}}</option>
    					</select>
    				</div>
    				<div class="wt-center-column">
    					<label for="fin">Fin</label>
    					<select id="fin" v-model="fin" class="wt-dropdown-min" @change="addDate()">
    						<option value="">Seleccionar</option>
    						<option v-for="item in horas" v-bind:value="item.value">{{item.label}}</option>
    					</select>
    				</div>
                </div>
                <div v-if="showDatos">
                    <div class="wt-m-top-2">
                        <span class="agregar-fecha" @click="openModalFechas()">Agregar fecha</span>
                        <ul>
                            <li class="list-dates" v-for="item in totalFechas">
                                <span>{{item.fecha}} desde {{item.inicio}}hs hasta {{item.fin}}hs</span>
                                <span class="cursor-pointer text-danger" @click="removeDate(item)">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </span>
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
        					<span class="precio-estimado">$ {{total}}</span>
        				</div>
                        <div class="iva-no-incluido">
                            <span>IVA no incluido</span>
                        </div>
                    </div>
    			</div>
                <div v-if="user != ''">
                    <button class="btn-reserva wt-m-top-2" @click="openModal()">CONTACTAR AL ANFITRIÓN</button>
        			<!--button class="btn-reserva-transparent wt-m-top-1">QUIERO VISITAR EL ESPACIO</button-->
                </div>
                <div v-if="user == ''">
                    <button class="btn-reserva wt-m-top-2"><a href="/login">CONTACTAR AL ANFITRIÓN</a></button>
                    <!--button class="btn-reserva-transparent wt-m-top-1"><a href="/login">QUIERO VISITAR EL ESPACIO</a></button-->
                </div>
    		</section>
    	</aside>

        <div v-if="modalReserva" class="modal-reserva">
            <div class="modal-reserva__content">
                <div class="modal-reserva__left">
                    <div class="container-img">
                        <img class="container-img__imagen" v-bind:src="avatarUrl" alt="Wimet consulta" />
                        <span class="container-img__nombre">{{nombreAnfitrion}}</span>
                    </div>
                    <div class="wt-m-top-2">
                        <strong>Fechas</strong>
                        <ul class="wt-m-top-2">
                            <li class="list-dates" v-for="item in totalFechas">
                                <span>{{item.fecha}} desde {{item.inicio}}hs hasta {{item.fin}}hs</span>
                            </li>
                        </ul>
                    </div>
                    <div class="wt-m-top-2">
                        <strong>Precio</strong>
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
                            <span class="precio-estimado">$ {{total}}</span>
                        </div>
                        <div class="iva-no-incluido">
                            <span>IVA no incluido</span>
                        </div>
                    </div>
                </div>
                <div class="modal-reserva__right">
                    <div>
                        <h4>¡Contacta al anfitrión!</h4>
                        <span class="close-reserva" @click="closeModal()">&times;</span>
                    </div>
                    <div class="form-contact">
                        <div class="form-contact__textarea">
                            <label for="title">Título del evento</label>
                            <input v-model="title" id="title" class="textarea-lg" placeholder="Ej.: Workshop Google for entrepreneurs" />
                        </div>
                    </div>
                    <div class="form-contact">
                        <div class="form-contact__textarea">
                            <label for="mensaje">Mensaje</label>
                            <textarea v-model="mensaje" id="mensaje" class="textarea-lg" rows="7" placeholder="Preséntate, describe la actividad que estas planificando y cuéntale cómo utilizarás el espacio. Necesitarás servicios de catering, técnica o producción? 

Ej: Hola, mi nombre es Paco y quiero organizar un Workshop para 30 personas. Vamos a necesitar mesas y un servicio de Coffee Break. Puede incluirlo en la propuesta? Puedo llevar mi propio catering?"></textarea>
                            <span class="wt-m-top-2">Nota: Recuerda que esta fuera de nuestros T&C enviar información personal (teléfono, email, etc.).</span>
                        </div>
                    </div>
                    <div class="form-contact">
                        <div class="form-contact__button">
                            <img v-if="!btnSend" src="/img/default.gif" alt="Cargando ..." height="50px" />
                            <button v-if="btnSend" class="btn-primary-pig" @click="sendReserva()">Enviar</button>
                        </div>
                    </div>
                </div>                
            </div>
        </div>

        <div v-if="modalFechas" class="modal-reserva">
            <div class="modal-reserva__content-fechas">
                <div class="wt-m-top-1 wt-m-bot-1">
                    <div class="wt-space-block">
                        <h3>Lista de fechas</h3>
                        <span class="close-reserva" @click="closeModalFechas()">&times;</span>
                    </div>
                    <div class="wt-center-column wt-m-top-1">
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" v-model="fecha" class="wt-dropdown-fechas"/>
                    </div>
                    <div class="wt-center-column wt-m-top-1">
                        <label for="inicio">Inicio</label>
                        <select id="inicio" v-model="inicio" class="wt-dropdown-fechas">
                            <option value="">Seleccionar</option>
                            <option v-for="item in horas" v-bind:value="item.value">{{item.label}}</option>
                        </select>
                    </div>
                    <div class="wt-center-column wt-m-top-1">
                        <label for="fin">Fin</label>
                        <select id="fin" v-model="fin" class="wt-dropdown-fechas" @change="addDate()">
                            <option value="">Seleccionar</option>
                            <option v-for="item in horas" v-bind:value="item.value">{{item.label}}</option>
                        </select>
                    </div>
                    <ul class="wt-m-top-1 list-group">
                        <li class="list-group-item justify-content-between" v-for="item in totalFechas">
                            <span>{{item.fecha}} desde {{item.inicio}}hs hasta {{item.fin}}hs</span>
                            <span class="cursor-pointer text-danger" @click="removeDate(item)">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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
                showDatos: false,
        		people: '',
        		category: this.categoryId,
        		categories: [],
                espacio: '',
                horas: [
                    {value: '08:00 AM', label: '08:00 AM'},
                    {value: '08:30 AM', label: '08:30 AM'},
                    {value: '09:00 AM', label: '09:00 AM'},
                    {value: '09:30 AM', label: '09:30 AM'},
                    {value: '10:00 AM', label: '10:00 AM'},
                    {value: '10:30 AM', label: '10:30 AM'},
                    {value: '11:00 AM', label: '11:00 AM'},
                    {value: '11:30 AM', label: '11:30 AM'},
                    {value: '12:00 PM', label: '12:00 PM'},
                    {value: '12:30 PM', label: '12:30 PM'},
                    {value: '01:00 PM', label: '01:00 PM'},
                    {value: '01:30 PM', label: '01:30 PM'},
                    {value: '02:00 PM', label: '02:00 PM'},
                    {value: '02:30 PM', label: '02:30 PM'},
                    {value: '03:00 PM', label: '03:00 PM'},
                    {value: '03:30 PM', label: '03:30 PM'},
                    {value: '04:00 PM', label: '04:00 PM'},
                    {value: '04:30 PM', label: '04:30 PM'},
                    {value: '05:00 PM', label: '05:00 PM'},
                    {value: '05:30 PM', label: '05:30 PM'},
                    {value: '06:00 PM', label: '06:00 PM'},
                    {value: '06:30 PM', label: '06:30 PM'},
                    {value: '07:00 PM', label: '07:00 PM'},
                    {value: '07:30 PM', label: '07:30 PM'},
                    {value: '08:00 PM', label: '08:00 PM'},
                    {value: '08:30 PM', label: '08:30 PM'},
                    {value: '09:00 PM', label: '09:00 PM'},
                    {value: '09:30 PM', label: '09:30 PM'},
                    {value: '10:00 PM', label: '10:00 PM'},
                    {value: '10:30 PM', label: '10:30 PM'},
                    {value: '11:00 PM', label: '11:00 PM'},
                    {value: '11:30 PM', label: '11:30 PM'},
                    {value: '12:00 AM', label: '12:00 AM'},
                    {value: '12:30 AM', label: '12:30 AM'},
                    {value: '01:00 AM', label: '01:00 AM'},
                    {value: '01:30 AM', label: '01:30 AM'},
                    {value: '02:00 AM', label: '02:00 AM'},
                    {value: '02:30 AM', label: '02:30 AM'},
                    {value: '03:00 AM', label: '03:00 AM'},
                    {value: '03:30 AM', label: '03:30 AM'},
                    {value: '04:00 AM', label: '04:00 AM'},
                    {value: '04:30 AM', label: '04:30 AM'},
                    {value: '05:00 AM', label: '05:00 AM'},
                    {value: '05:30 AM', label: '05:30 AM'},
                    {value: '06:00 AM', label: '06:00 AM'},
                    {value: '06:30 AM', label: '06:30 AM'},
                    {value: '07:00 AM', label: '07:00 AM'},
                    {value: '07:30 AM', label: '07:30 AM'}
                ],
        		fecha: '',
        		inicio: '',
        		fin: '',
        		fee: '-',
        		totalHoras: 1,
        		totalFechas: [],
        		subTotal: this.price,
        		total: '-',
                modalReserva: false,
                modalFechas: false,
                title: '',
                mensaje: '',
                btnSend: true,
                dateStart: '',
                dateEnd: ''
        	}
        },
        mounted() {
            this.getUserAuthenticated();
            this.getCategories();
            this.calFee();
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
        	calFee() {
        		this.fee = (this.subTotal * 5)/100;
        	},
        	addDate() {
                if(this.isPar((this.fin - this.inicio)) < this.minhours) {
                    this.messageError = `El minimo de horas es ${this.minhours}`;
                    setInterval(() => {
                        this.messageError = "";
                    }, 5000);
                    return;
                }
        		this.totalFechas.push({
        			'fecha': this.fecha,
        			'inicio': this.timeFormat(this.inicio),
        			'fin': this.timeFormat(this.fin)
        		});
                if(this.dateStart == '') {
                    this.dateStart = this.fecha;
                }
                this.dateEnd = this.fecha;
        		this.totalHoras = this.totalHoras + this.isPar((this.fin - this.inicio));
        		this.subTotal = (this.totalHoras * this.price);
        		this.calFee();
        		this.total = this.subTotal + this.fee;
                this.showDatos = true;
                this.fecha = '';
                this.inicio = '';
                this.fin = '';
        	},
            checkfechas() {
                let today = new Date() ;
                let dayselect = new Date(this.fecha);
                if (dayselect < today) {
                    this.messageError = `La fecha seleccionada no puede ser días pasados.`;
                    setInterval(() => {
                        this.messageError = "";
                    }, 500);
                    return;
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
            },
            closeMsg() {
                this.messageError = '';
            },
            addWishlist() {
                let body = {
                    'clientId': this.user.id,
                    'espacio_id': this.espacioId
                }
                this.$http.post(`/wishlist`, body)
                .then(res => {
                    this.showModal = true;
                }, err => {
                    console.log(err);
                });
            },
            openModal(Mensaje) {
                if(!this.authenticated) {
                    swal({
                      title: 'No estas loguedo',
                      text: "Debes iniciar sesión para hacer una pregunta o reserva.",
                      imageUrl: "/avatars/default.png"
                    });
                    return;
                }else {
                    if(this.totalHoras < this.minhours) {
                        this.messageError = `El mínimo de horas es ${this.minhours}`;
                        return;
                    }
                    if(this.people == "") {
                        this.messageError = `Debe ingresar cantidad de invitados`;
                        return;
                    }
                    if(this.people > this.espacio.quanty) {
                        this.messageError = `La cantidad de invitados máxima es ${this.espacio.quanty}`;
                        return;
                    }
                    this.modalReserva = true;
                    this.mensaje = Mensaje;
                }
            },
            closeModal() {
                this.modalReserva = false;
            },
            openModalFechas() {
                this.modalFechas = true;
            },
            closeModalFechas() {
                this.modalFechas = false;
            },
            sendReserva() {
                if(this.totalFechas < 1) {
                    this.messageError = `El mínimo de horas es ${this.minhours}`;
                    return;
                }
                if(this.totalHoras < this.minhours) {
                    this.messageError = `El mínimo de horas es ${this.minhours}`;
                    return;
                }
                this.btnSend = false;
                let body = {
                    'title': this.title,
                    'clientId': this.user.id,
                    'espacioId': this.espacioId,
                    'category': this.category,
                    'invitados': this.people,
                    'price': this.price,
                    'totalFechas': this.totalFechas,
                    'totalHoras': this.totalHoras,
                    'mensaje': this.mensaje,
                    'fee': this.fee,
                    'reserva_desde': this.dateStart,
                    'reserva_hasta': this.dateEnd,
                    'subTotal': this.subTotal,
                    'total': this.total

                }
                this.btnSend = true;
                this.$http.post(`api/sendreserva`, body)
                .then(res => {
                    window.location.href = `/dashboard/user/${this.user.id}/mensajes`;
                }, err => {
                    console.log(err);
                    swal(err.message);
                });
            },
            removeDate(date) {
                let aux = this.totalFechas.indexOf(date);
                this.totalFechas.splice(aux, 1);
                
                if(this.totalFechas.length == 0) {
                    this.showDatos = false;
                }
            },
            getUserAuthenticated() {
                if(this.$auth.isAuthenticated()) {
                    this.user = this.$auth.getUser();
                }
            }
        }
    }
</script>
<style lang="sass">
    .modal-reserva {
        position: fixed;
        z-index: 1200;
        padding-top: 60px;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        ul {
            padding: 0;
        }
        &__left {
            width: 40%;
            padding: 2em;
            background: #f8f8f8;
            .container-img {
                width: 40%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                margin: 0 auto;
                &__imagen {
                    width: 100%;
                    border-radius: 5em;
                }
                &__nombre {
                    font-style: italic;
                    color: #191919;
                    margin-top: 1em;
                }
            }
        }
        &__right {
            width: 60%;
            padding: 1em 2em;
            .form-contact {
                display: flex;
                justify-content: space-between;
                .form-contact__select {
                    display: flex;
                    flex-direction: column;
                    margin: 1em 0;
                    .input-lg {
                        width: 250px;
                        height: 35px;
                        padding: 0.3em;
                        border: solid 1px #d2d2d2;
                    }
                    .select-lg {
                        width: 250px;
                        height: 35px;
                        padding: 0.5em;
                        border: solid 1px #d2d2d2;
                    }
                    .select-sm {
                        width: 114px;
                        height: 35px;
                        padding: 0.5em;
                        border: solid 1px #d2d2d2;
                    }
                    .textarea-lg {
                        width: 100%;
                        border: solid 1px #d2d2d2;
                        padding: 0.5em;
                    }
                }
                .form-contact__textarea {
                    display: flex;
                    flex-direction: column;
                    margin: 1em 0;
                    width: 100%;
                    .textarea-lg {
                        width: 100%;
                        border: solid 1px #d2d2d2;
                        padding: 0.5em;
                    }
                }
                .form-contact__button {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-end;
                    margin: 1em 0;
                    width: 100%;
                    .button-sm {
                        width: 25%;
                        padding: 0;
                    }
                }
            }
            .messageErrorModal {
                margin: 16px 0;
                display: -webkit-box;
                display: flex;
                -webkit-box-pack: justify;
                justify-content: space-between;
                -webkit-box-align: baseline;
                align-items: baseline;
                padding: 1em;
                background: rgba(234, 81, 109, 0.87);
                color: #fff;
                border-radius: 2px;
                border: 1px solid #ea516d;
                p {
                    margin: 0;
                }
            }
        }
    }
    .modal-reserva__content {
        display: flex;
        position: relative;
        background-color: #fefefe;
        margin: auto;
        border: 1px solid #888;
        width: 60%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }

    .modal-reserva__content-fechas {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        background-color: #fefefe;
        margin: 0 auto;
        border: 1px solid #888;
        width: 25%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s;
        .wt-dropdown-fechas {
            width: 100%;
            height: 40px;
            background-color: #ffffff;
            border: solid 1px #979797;
            border-radius: 0;
            opacity: 0.87;
            font-family: Roboto;
            font-size: 12px;
            letter-spacing: -0.1px;
            text-align: justify;
            color: #212121;
        }
    }

    @-webkit-keyframes animatetop {
        from {bottom:-300px; opacity:0} 
        to {bottom:0; opacity:1}
    }

    @keyframes animatetop {
        from {bottom:-300px; opacity:0}
        to {bottom:0; opacity:1}
    }

    .close-reserva {
        color: #000;
        position: absolute;
        float: right;
        top: 10px;
        right: 25px;
        font-size: 28px;
        font-weight: bold;
    }

    .close-reserva:hover,
    .close-reserva:focus {
        text-decoration: none;
        cursor: pointer;
    }

    .modal-body {padding: 2px 16px;}
</style>