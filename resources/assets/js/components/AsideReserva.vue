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
                <div v-if="messageError" class="messageError">
                    <p>El mínimo de horas es {{minhours}}</p>
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
    					<select name="people" id="people" class="wt-dropdown" v-model="people">
    						<option value="">Seleccionar</option>
    						<option value="5">5+</option>
    						<option value="10">10+</option>
    						<option value="25">25+</option>
    						<option value="50">50+</option>
                            <option value="100+">100 +</option>
    						<option value="200+">200 +</option>
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
            					<span>$ {{total}}</span>
            				</div>
                    </div>
    			</div>
                <div v-if="clientId != ''">
                    <button class="wt-btn-aqua wt-m-top-2" @click="openModal(`Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, aliquid perferendis possimus eum accusamus earum odio qui a iure quis vero ut nesciunt distinctio et facilis dolorem ducimus laborum natus.`)">SOLICITUD DE RESERVA</button>
        			<button class="wt-btn-aqua wt-m-top-1" @click="openModal('')">SOLICITUD DE VISITA</button>
                </div>
                <div v-if="clientId == ''">
                    <button class="wt-btn-aqua wt-m-top-2"><a href="/login">SOLICITUD DE RESERVA</a></button>
                    <button class="wt-btn-aqua wt-m-top-1"><a href="/login">SOLICITUD DE VISITA</a></button>
                </div>
    		</section>
    	</aside>

        <div v-if="modalReserva" class="modal-reserva">
            <div class="modal-reserva__content">
                <div class="modal-reserva__left">
                    <div class="container-img">
                        <img v-bind:src="avatarUrl" alt="Wimet consulta" />
                    </div>
                    <div>
                        <h3>1.</h3>
                        <p>Providing plenty of details will help the owner and speed up the process.</p>
                    </div>
                    <div>
                        <h3>2.</h3>
                        <p>If you're ready to move forward, request a quote or schedule a site visit.</p>
                    </div>
                </div>
                <div class="modal-reserva__right">
                    <div>
                        <h2>Contactar</h2>
                        <span class="close-reserva" @click="closeModal()">&times;</span>
                        <div v-if="messageError" class="messageErrorModal">
                            <p>El mínimo de horas es {{minhours}}</p>
                            <i class="fa fa-times cursor-pointer" aria-hidden="true" @click="closeMsg()"></i>
                        </div>
                    </div>
                    <div class="form-contact">
                        <div class="form-contact__select">
                            <label for="">Tipo actividad</label>
                            <select class="select-lg" v-model="category">
                                <option value="">Seleccionar</option>
                                <option v-for="cat in categories" v-bind:value="cat.id">
                                    {{cat.name}}
                                </option>
                            </select>
                        </div>
                        <div class="form-contact__select">
                            <label for="people">Invitados</label>
                            <select name="people" id="people" class="select-lg" v-model="people">
                                <option value="">Seleccionar</option>
                                <option value="5">5+</option>
                                <option value="10">10+</option>
                                <option value="25">25+</option>
                                <option value="50">50+</option>
                                <option value="100+">100 +</option>
                                <option value="200+">200 +</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="fechas">Fechas</label>
                        <ul>
                            <li class="form-contact" v-for="item in totalFechas">
                                <span>{{item.fecha}} desde {{item.inicio}}hs hasta {{item.fin}}hs</span>
                                <span class="cursor-pointer text-danger" @click="removeDate(item)">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="form-contact">
                        <div class="form-contact__textarea">
                            <label for="mensaje">Mensaje</label>
                            <textarea v-model="mensaje" id="mensaje" class="textarea-lg" rows="5" placeholder="Cuentale lo mejor que puedas, sobre el evento que quieres realizar al dueño del espacio."></textarea>
                        </div>
                    </div>
                    <div class="form-contact">
                        <div class="form-contact__button">
                            <img v-if="!btnSend" src="/img/default.gif" alt="Cargando ..." height="50px" />
                            <button v-if="btnSend" class="wt-btn-aqua button-sm" @click="sendReserva()">Enviar</button>
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
    export default {
    	props: [
            'espacioId',
            'clientId',
    		'avatarUrl',
            'price',
            'minhours',
            'categoryId',
        ],
        data() {
        	return {
        		messageError: false,
                showDatos: false,
        		people: '',
        		category: this.categoryId,
        		categories: [],
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
                mensaje: '',
                btnSend: true
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
        		this.totalFechas.push({
        			'fecha': this.fecha,
        			'inicio': this.timeFormat(this.inicio),
        			'fin': this.timeFormat(this.fin)
        		});
                this.fecha = '';
                this.inicio = '';
                this.fin = '';
        		this.totalHoras = this.isPar((this.fin - this.inicio));
        		this.subTotal = (this.totalHoras * this.price);
        		this.calFee();
        		this.total = this.subTotal + this.fee;
                this.showDatos = true;
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
                this.messageError = false;
            },
            addWishlist() {
                let body = {
                    'clientId': this.clientId,
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
                if(this.totalFechas < 1) {
                    this.messageError = true;
                    return;
                }
                this.modalReserva = true;
                this.mensaje = Mensaje;

            },
            openModalFechas() {
                this.modalFechas = true;
            },
            closeModal() {
                this.modalReserva = false;
            },
            closeModalFechas() {
                this.modalFechas = false;
            },
            sendReserva() {
                if(this.totalFechas < 1) {
                    this.messageError = true;
                    return;
                }
                if(this.totalHoras < this.minhours) {
                    this.messageError = true;
                    return;
                }
                this.btnSend = false;
                let body = {
                    'clientId': this.clientId,
                    'espacioId': this.espacioId,
                    'price': this.price,
                    'totalFechas': this.totalFechas,
                    'totalHoras': this.totalHoras,
                    'mensaje': this.mensaje,
                    'fee': this.fee,
                    'subTotal': this.subTotal,
                    'total': this.total

                }
                this.$http.post(`/api/sendreserva`, body)
                .then(res => {
                    this.btnSend = true;
                    this.modalReserva = false;
                }, err => {
                    console.log(err);
                });
            },
            removeDate(date) {
                let aux = this.totalFechas.indexOf(date);
                this.totalFechas.splice(aux, 1);
                
                if(this.totalFechas.length == 0) {
                    this.showDatos = false;
                }
            }
        }
    }
</script>
<style lang="sass">
    .modal-reserva {
        position: fixed;
        z-index: 1;
        padding-top: 50px;
        left: 0;
        top: 5%;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        ul {
            padding: 0;
        }
        &__left {
            width: 30%;
            padding: 2em;
            background: #eeeeee;
            .container-img {
                width: 70%;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0 auto;
                img {
                    width: 100%;
                    border-radius: 5em;
                }
            }
        }
        &__right {
            width: 80%;
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