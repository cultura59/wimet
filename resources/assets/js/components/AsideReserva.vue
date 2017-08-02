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
                <template v-if="(messageError != '')">
                    <div class="messageError">
                        <p>{{messageError}}</p>
                        <i class="fa fa-times cursor-pointer" aria-hidden="true" @click="closeMsg()"></i>
                    </div>
                </template>
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
    					<label for="inicio">Inicio</label>
    					<input type="text" id="inicio" class="wt-dropdown" placeholder="Check-In" />
    				</div>
    				<div class="wt-center-column">
    					<label for="fin">Fin</label>
                        <input type="text" id="fin" class="wt-dropdown" placeholder="Check-Out" />
    				</div>
                </div>
                <div>
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
                        <div class="wt-center-column">
                            <strong>Fechas</strong>
                            <span>{{inicio}} - {{fin}}</span>
                        </div>
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
                    <template v-if="(messageError != '')">
                        <div class="messageError">
                            <p>{{messageError}}</p>
                            <i class="fa fa-times cursor-pointer" aria-hidden="true" @click="closeMsg()"></i>
                        </div>
                    </template>
                    <div class="form-contact">
                        <div class="form-contact__textarea">
                            <label for="title">Título del evento</label>
                            <input v-model="title" id="title" class="textarea-lg" placeholder="Ej.: Workshop Google for entrepreneurs" />
                        </div>
                    </div>
                    <div class="form-contact">
                        <div class="form-contact__textarea">
                            <label for="mensaje">Mensaje</label>
                            <textarea v-model="mensaje" id="mensaje" class="textarea-lg" rows="7" placeholder="Preséntate, describe la actividad que estas planificando y cuéntale cómo utilizarás el espacio. ¿Necesitarás servicios de catering, técnica o producción? 
Ej.: 'Hola, mi nombre es Paco y quiero organizar un Workshop para 30 personas. Vamos a necesitar mesas y un servicio de Coffee Break.'"></textarea>
                            <span class="wt-m-top-2">Nota: Recuerda que esta fuera de nuestros <a class="link-wimet" href="#">Términos y condiciones</a> enviar información de contacto (teléfono, email, etc.).</span>
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
    </div>
</template>
<script>
    import swal from 'sweetalert';
    import moment from 'moment';
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
            openModal(Mensaje) {
                if(!this.authenticated) {
                    this.messageError = "Debes iniciar sesión para hacer una pregunta";
                    return;
                }else {
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
                this.btnSend = false;
                if(this.mensaje.includes("@")) {
                    this.messageError = "No se pueden incluir emails en el mensaje";
                    this.btnSend = true;
                    return
                }
                let inicio = moment(this.inicio);
                let fin = moment(this.fin);
                let totalHoras = this.checkDiffDates(fin, inicio);

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
                    window.location.href = `/dashboard/user/${this.user.id}/mensajes`;
                }, err => {
                    this.btnSend = true;
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
                        inicio = moment(localStorage.getItem("consultaInicio"));
                        fin = moment(localStorage.getItem("consultaFin"));

                        if(inicio > fin) {
                            localStorage.removeItem("consultaInicio");
                            localStorage.removeItem("consultaFin");
                            this.messageError = 'La fecha de inicio no puede ser mayor que la de fin';
                            return;
                        }

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
                }.bind(this), 2000); 
            },
            checkDiffDates(end, start) {
                let fin = moment(end);
                let inicio = moment(start);
                return moment.utc(fin.diff(inicio));
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
        color: #212121;
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
    .link-wimet {
        color: #ea516d;
        &:hover, &:focus {
            color: #ea516d;
        }
    }
    .modal-body {padding: 2px 16px;}
</style>