<template>
    <div>
        <!-- header -->
        <header-espacio :espacio-id="espacioId"></header-espacio>
        <!-- main -->
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="center-title">
                            <h3 class="title">{{espacio.name}}</h3>
                            <img src="http://www.wimet.co/img/wimet_ic_verified_user_black_24px.svg" alt="Espacio verificado" class="verified">
                        </div>
                        <div class="direccion"><span>{{espacio.city}}, {{espacio.state}}</span></div>
                        <div class="contenedor-invitados">
                            <img src="http://www.wimet.co/img/wimet_ic_group_black_24px.svg" class="icon-people"> 120 Máx
                        </div>
                        <div class="box-descripcion">
                            <div class="box-descripcion__titulo">
                                <span>Espacio</span>
                            </div>
                            <div class="box-descripcion__contenido">
                                <p v-html="espacio.description"></p>
                            </div>
                        </div>
                        <div class="box-descripcion">
                            <div class="box-descripcion__titulo">
                                <span>Precio</span>
                            </div>
                            <div class="box-descripcion__contenido">
                                <div class="container-prices">
                                    <div class="wt-center-column">
                                        <span class="price">
                                            <b><i aria-hidden="true" class="fa fa-clock-o"></i></b> ${{priceCategoria.daily}}.-
                                        </span>
                                        <span class="min-hours">Por jornada</span>
                                    </div>
                                    <div class="wt-center-column wt-m-lf-3">
                                        <span class="price">
                                            <b><i aria-hidden="true" class="fa fa-clock-o"></i></b> ${{priceCategoria.price}}.-
                                        </span>
                                        <span class="min-hours">Por media jornada</span>
                                    </div>
                                </div>
                                <span class="min-hours">NOTA: El precio se encuentra sujeto a modificaciones en función de la temporada/ época del año.</span>
                            </div>
                        </div>
                        <div class="box-descripcion">
                            <div class="box-descripcion__titulo">
                                <span>Disponibilidad</span>
                            </div>
                            <div class="box-descripcion__contenido">
                                <div v-for="dia in disponibilidad" class="wt-space-block">
                                    <span>{{dia.dia}}</span>
                                    <span><hr class="box-descripcion__contenido__separador"></span>
                                    <span>{{dia.inicio}} - {{dia.fin}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="box-descripcion">
                            <div class="box-descripcion__titulo">
                                <span>AMENITIES</span>
                            </div>
                            <div class="box-descripcion__contenido">
                                <div class="row">
                                    <div v-for="servicio in espacio.servicios" class="col-xs-6 col-md-4 wt-m-top-1">
                                        <div class="pull-left content-service">
                                            <img :src="servicio.icon" :alt="servicio.nombre">
                                            <p>{{servicio.nombre}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-descripcion">
                            <div class="box-descripcion__titulo">
                                <span>Acceso</span>
                            </div>
                            <div class="box-descripcion__contenido">
                                <div class="row">
                                    <div v-for="acceso in espacio.access" class="col-xs-6 col-md-4 content-service">
                                        <img :src="acceso.icon" :alt="acceso.nombre">
                                        <p>{{acceso.nombre}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-descripcion">
                            <div class="box-descripcion__titulo">
                                <span>Cancelación y depósito de garantía</span>
                            </div>
                            <div class="box-descripcion__contenido">
                                <div class="wt-center-column">
                                    <span>Cancelación: flexible.</span>
                                    <span>Reembolso completo hasta 15 días antes del evento, excepto los gastos de procesamiento.</span>
                                    <span>Depósito de garanía: ${{priceCategoria.securitydeposit}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="box-descripcion">
                            <div class="box-descripcion__titulo">
                                <span>Ubicación</span>
                            </div>
                            <div class="box-descripcion__contenido">
                                <template v-if="showMap">
                                    <mapa-espacio
                                        name="espacio-mapa"
                                        icon="radio"
                                        zoom="13"
                                        gwith="100%"
                                        gheight="400px"
                                        :gespacios="espacioMap"
                                    >
                                    </mapa-espacio>
                                </template>
                            </div>
                        </div>
                        <div class="box-descripcion">
                            <div class="box-descripcion__titulo">
                                <span>Estilo</span>
                            </div>
                            <div class="box-descripcion__contenido">
                                <div class="container-tags">
                                    <span v-for="caracteristica in espacio.characteristics" class="wt-tag">{{caracteristica.nombre}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="calendar">
                            <section class="espacio-categorias">
                                <div v-for="price in espacio.prices"
                                    class="espacio-categorias__categoria"
                                    :class="{'espacio-categorias__categoria--active': (priceCategoria.categoria_id == price.categoria.id)}"
                                    @click="selectCategory(price.categoria.id)">
                                    <img :src="price.categoria.icon" :alt="price.categoria.name" class="img-responsive">
                                    <span class="wt-m-top-1 wt-mayuscula">{{price.categoria.name}}</span>
                                </div>
                            </section>
                            <header class="calendar__header">
                                <div class="calendar__header__price">
                                    <span class="calendar__header__price--default">Desde</span>
                                    <span class="calendar__header__price--active">${{priceCategoria.price}}</span>
                                </div>
                             </header>
                            <main class="calendar__main">
                                <div class="select__mount">
                                    <span  @click="previous()" class="cursor-pointer"><</span>
                                    <span>{{month.format('MMMM YYYY').toUpperCase()}}</span>
                                    <span @click="next()" class="cursor-pointer">></span>
                                </div>
                                <table class="calendar__main__table">
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
                                <template v-if="selected.length > 0">
                                    <div class="wt-m-top-2">
                                        <strong>PRECIO</strong>
                                        <div class="wt-space-block wt-m-top-1">
                                            <span>Espacio x {{totalDays}} días</span>
                                            <span>$ {{subTotal}}</span>
                                        </div>
                                        <div v-show="showFee">
                                            <div class="wt-space-block wt-m-top-1">
                                                <span>Fee de procesamiento</span>
                                                <span>$ {{fee}}</span>
                                            </div>
                                            <div class="wt-space-block wt-m-top-1">
                                                <span>Precio estimado</span>
                                                <strong class="precio-estimado">$ {{total}}</strong>
                                            </div>
                                        </div>
                                        <div v-if="messageError != ''" class="msgAlert">
                                            <span>{{messageError}}</span>
                                            <span class="cursor-pointer" @click="messageError = ''">x</span>
                                        </div>
                                        <button class="btn-reserva wt-m-top-2" @click="openModal()">SOLICITUD DE RESERVA</button>
                                    </div>
                                </template>
                                <div class="datos-duenio">
                                    <div class="datos-duenio__imagen">
                                        <img :src="duenio.imagesource" width="74px">
                                    </div>
                                    <div class="datos-duenio__datos">
                                        <span class="datos-duenio__datos__nombre">{{duenio.firstname}}</span>
                                        <span class="datos-duenio__datos__tipo">Anfitrion</span>
                                    </div>
                                </div>
                            </main>
                            <div class="espacio-tooltip">
                                <p>Selecciona la/s fecha/s que quieres alquilar.</p>
                                <p>Puedes elegir 1/2 jornada, haciendo un segundo click sobre la fecha.</p>
                            </div>
                        </div>
                    </div>
                    <div v-if="modalReserva" class="modal-reserva">
                        <div class="modal-reserva__content">
                            <div class="modal-reserva__left">
                                <div class="container-img">
                                    <img class="container-img__imagen" :src="duenio.imagesource" alt="Wimet consulta" />
                                    <span class="container-img__nombre">{{duenio.firstname}}</span>
                                </div>
                                <div class="wt-m-top-2">
                                    <div class="wt-center-column">
                                        <strong>Fechas</strong>
                                        <li v-for="day in selected">
                                            <span>{{$moment(day.date).locale('es').format("DD MMM YYYY")}}</span>
                                            <span v-if="day.workingDay == 'all'"> (jornada completa)</span>
                                            <span v-if="day.workingDay == 'morning'"> (media jornada/am)</span>
                                            <span v-if="day.workingDay == 'night'"> (media jornada completa/pm)</span>
                                        </li>
                                    </div>
                                </div>
                                <div class="wt-m-top-2">
                                    <strong>Precio</strong>
                                    <div class="wt-space-block wt-m-top-1">
                                        <span>Espacio x {{totalDays}} días</span>
                                        <span>$ {{subTotal}}</span>
                                    </div>
                                    <div v-show="showFee">
                                        <div class="wt-space-block wt-m-top-1">
                                            <span>Fee de procesamiento</span>
                                            <span>$ {{fee}}</span>
                                        </div>
                                        <div class="wt-space-block wt-m-top-1">
                                            <span>Precio estimado</span>
                                            <span class="precio-estimado">$ {{total}}</span>
                                        </div>
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
                                        <input v-model="title" id="title" class="textarea-lg" :class="{'error-input': messageErrorTitle}" placeholder="Ej.: Workshop Google for entrepreneurs" />
                                        <span v-if="messageErrorTitle" style="color:red;font-size:12px;">Campo requerido</span>
                                    </div>
                                </div>
                                <div class="form-contact">
                                    <div class="form-contact__textarea">
                                        <label for="title">Cantidad de asistente</label>
                                        <input v-model="people" id="people" class="textarea-lg" placeholder="50" />
                                    </div>
                                </div>
                                <div class="form-contact">
                                    <div class="form-contact__textarea">
                                        <label for="mensaje">Mensaje</label>
                                        <textarea v-model="mensaje" id="mensaje" class="textarea-lg" :class="{'error-input': messageErrorDetalle != ''}" rows="7" placeholder="Preséntate, describe la actividad que estas planificando y cuéntale cómo utilizarás el espacio. ¿Necesitarás servicios de catering, técnica o producción?
Ej.: 'Hola, mi nombre es Paco y quiero organizar un Workshop para 30 personas. Vamos a necesitar mesas y un servicio de Coffee Break.'"></textarea>
                                        <span v-if="messageErrorDetalle != ''" style="color:red;font-size:12px;">{{messageErrorDetalle}}</span>
                                        <span class="wt-m-top-2">
                                <input type="checkbox" id="terminos" style="display: none;" v-model="terminos">
                                <label class="wt-publica-label" for="terminos">Acepto que está fuera de los <a class="link-wimet" href="#">términos y condiciones</a>  enviar información de contacto (teléfono, email, etc.).</label>
                            </span>
                                    </div>
                                </div>
                                <div class="form-contact">
                                    <div class="form-contact__button">
                                        <img v-show="!btnSend" src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-pig_oxestq.svg" alt="Cargando ..." height="50px" />
                                        <button v-show="btnSend && !terminos" class="btn-primary-pig--disable">Enviar</button>
                                        <button v-show="btnSend && terminos" class="btn-primary-pig" @click="sendReserva()">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer -->
            <footer>
                <div class="container">
                    <div class="row">
                       <div class="col-xs-12 col-sm-4">
                        <img class="img-responsive" src="https://res.cloudinary.com/wimet/image/upload/wimet-logo_frbya5.svg" alt="Wimet" width="163">
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <p class="col-footer">Empresa</p>
                            <ul>
                                <li><a href="/nosotros">Nosotros</a></li>
                                <li><a href="https://blog.wimet.co">Blog</a></li>
                                <li><a href="/nosotros">Ayuda</a></li>
                                <li><a href="/nosotros">Términos y condiciones</a></li>
                                <li><a href="/nosotros">Políticas de privacidad</a></li>
                            </ul>
                        </div>
                         <div class="col-xs-12 col-sm-2">
                            <p class="col-footer">Actividades</p>
                            <ul>
                                <li>
                                    <a href="/search?ubicacion=&categoria=1&quanty=0-1000&price=100-100000">REUNIONES</a>
                                </li>
                                <li>
                                    <a href="/search?ubicacion=&categoria=2&quanty=0-1000&price=100-100000">EVENTOS</a>
                                </li>
                                <li>
                                    <a href="/search?ubicacion=&categoria=3&quanty=0-1000&price=100-100000">PRODUCCIONES</a>
                                </li>
                                <li>
                                    <a href="/search?ubicacion=&categoria=4&quanty=0-1000&price=100-100000">RETAIL</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <p class="col-footer">Contacto</p>
                            <ul>
                                <li><a href="#">hola@wimet.co</a></li>
                                <li><a href="#">El Salvador 5218, CABA</a></li>
                                <li><a href="#">Buenos Aires, Argentina</a></li>
                            </ul>
                            <div class="wt-m-top-3 follow">
                                <a href="https://www.instagram.com/wimet.co/">
                                    <img src="https://res.cloudinary.com/wimet/image/upload/c_scale,h_30,w_30/icons/wimet-icon-instagram.svg" alt="Wimet" class="img-responsive">
                                </a>
                                <a href="https://www.facebook.com/wimet.co/">
                                    <img src="http://res.cloudinary.com/wimet/image/upload/c_scale,h_30,w_30/v1515518301/icons/wimet-icon-facebook.svg" alt="Wimet" class="img-responsive">
                                </a>
                                <a href="https://www.linkedin.com/company/wimet">
                                    <img src="https://res.cloudinary.com/wimet/image/upload/c_scale,h_30,w_30/icons/wimet-icon-linkedin.svg" alt="Wimet" class="img-responsive">
                                </a>
                                <a href="https://twitter.com/wimetco">
                                    <img src="https://res.cloudinary.com/wimet/image/upload/c_scale,h_30,w_30/v1515518302/icons/wimet-icon-twitter.svg" alt="Wimet" class="img-responsive">
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="terminos-copyright">
                        <div>
                            <span>&#169 Wimet SAS. Todos los derechos reservados.</span>
                        </div>
                        <div>
                            <a href="#">Politicas de privacidad</a>
                            <a href="#" class="wt-m-lf-2">Términos y condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
    </div>
</template>
<script>
    import HeaderEspacio from './HeaderEspacio.vue';
    import MapaEspacio from '../GoogleMaps.vue';
    export default {
        components: {
            'header-espacio': HeaderEspacio,
            'mapa-espacio': MapaEspacio
        },
        props: [
            'espacioId',
            'categoriaId'
        ],
        data() {
            return {
                modalReserva: false,
                authenticated: this.$auth.isAuthenticated(),
                espacio: {},
                duenio: {},
                people: 0,
                selected: this.$store.getters.getCategoriesSelected,
                messageError: '',
                espacioMap: [],
                disponibilidad: [],
                showMap: false,
                priceCategoria: {},
                month: '',
                weeks: [],
                totalDays: 0,
                subTotal: 0,
                fee: 0,
                total: 0,
                btnSend: true,
                mensaje: '',
                terminos: false,
                messageErrorTitle: false,
                messageErrorDetalle: '',
                showFee: false
            }
        },
        mounted() {
            this.getEspacio();
            this.getDisponibilidad();
        },
        methods: {
            getEspacio() {
                this.$http.get(`api/espacio/${this.espacioId}`)
                .then(res => {
                    this.espacio = res.body;
                    this.espacioMap.push(this.espacio);
                    this.showMap = true;
                    this.getUser();
                    this.getCategoria();
                    this.startCalendar();
                }, err => {
                    console.log(err);
                });
            },
            getUser() {
                this.$http.get(`api/user/${this.espacio.user_id}`)
                .then(res => {
                    this.duenio = res.body;
                }, err => {
                    console.log(err);
                });
            },
            getCategoria() {
                for(let i = 0; i < this.espacio.prices.length; i++) {
                    if(this.espacio.prices[i].categoria_id == this.categoriaId) {
                        this.priceCategoria = this.espacio.prices[i];
                        return;
                    }
                }
            },
            getDisponibilidad() {
                this.$http.get(`api/disponibilidad/${this.espacioId}`)
                .then(res => {
                   this.disponibilidad = res.body;
                }, err => {
                    console.log(err);
                });
            },
            startCalendar() {
                this.$moment.locale('es', {
                    months : "Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre".split("_")
                });
                this.$moment.locale('es');
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
                this.calcularPrice();
            },
            buildWeek(date, month) {
                let days = [];
                for (let i = 0; i < 7; i++) {
                    days.push({
                        name: date.format("dd").substring(0, 1),
                        number: date.date(),
                        isCurrentMonth: date.month() === this.$moment(),
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
            selectCategory(categoryId) {
                let aux = this.espacio.prices;
                for(let i = 0; i < aux.length; i++) {
                    if(aux[i].categoria_id == categoryId) {
                        this.priceCategoria = aux[i];
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
                this.calcularPrice();
            },
            calcularPrice() {
                let countDays = 0;
                for(let i = 0; i < this.$store.getters.getCategoriesSelected.length; i++) {
                    if(this.$store.getters.getCategoriesSelected[i].workingDay == "all") {
                        countDays = countDays + 1;
                    }else {
                        countDays = countDays + 0.5;
                    }
                }
                this.totalDays = countDays;
                this.subTotal = this.priceCategoria.daily * countDays;
                this.fee = (this.subTotal * 15)/100;
                this.total = this.subTotal + this.fee;
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
            openModal() {
                if(!this.authenticated) {
                    this.$toastr.warning('Debes iniciar sesión para hacer una pregunta', 'Ups no sabemos quien sos');
                    return;
                }else {
                    this.modalReserva = true;
                }
            },
            closeModal() {
                this.modalReserva = false;
            },
            sendReserva() {
                this.btnSend = false;
                if(this.title == '') {
                    this.messageErrorTitle = true;
                    this.btnSend = true;
                    return;
                }
                if(this.mensaje == '') {
                    this.messageErrorDetalle = "Campo requerido";
                    this.btnSend = true;
                    return;
                }
                if(this.mensaje.includes("@")) {
                    this.messageErrorDetalle = "No se pueden incluir emails en el mensaje";
                    this.btnSend = true;
                    return;
                }

                let body = {
                    'title': this.title,
                    'clientId': this.$store.getters.getUser.id,
                    'espacioId': this.espacioId,
                    'category': this.priceCategoria.categoria_id,
                    'invitados': this.people,
                    'price': this.price,
                    'totalHoras': this.totalDays,
                    'mensaje': this.mensaje,
                    'fee': this.fee,
                    'subTotal': this.subTotal,
                    'total': this.total,
                    'dias': this.selected
                }
                this.$http.post(`api/sendreserva`, body)
                    .then(res => {
                        window.location.href = `/thankyou/${res.body.id}`;
                    }, err => {
                        this.btnSend = true;
                        swal(err.message);
                    });
            }
        }
    }
</script>
<style lang="sass" scoped>
    .contenedor-invitados {
        margin: 1em 0;
        padding: 1em 0;
        border-top: 1px solid #dadada;
        border-bottom: 1px solid #dadada;
    }
    .calendar {
        width: 400px;
        position: relative;
        &:hover .espacio-tooltip {
            display: block;
        }
        .espacio-categorias {
            display: flex;
            justify-content: space-around;
            margin-top: 2em;
            width: 100%;
            &__categoria {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 100%;
                border-bottom: 4px solid #dadada;
                cursor: pointer;
                &:hover, &--active {border-bottom: 4px solid #fc5289;}
            }
        }
        &__header {
            display: flex;
            justify-content: space-between;
            padding: 1.2em 2em;;
            background-color: #545454;
            color: #fff;
            font-size: 12px;
            &__price {
                display: flex;
                justify-content: center;
                align-items: center;
                &--default {
                    padding-right: 1em;
                }
                &--active {
                    font-size: 16px;
                    font-weight: bold;
                    padding-right: 1em;
                }
            }
        }
        &__main {
            border: solid 1px #dadada;
            padding: 1em;
            .select__mount {
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 12px;
                color: #212121;
                margin: 0 auto;
            }
            &__table {
                transition: none;
                font-family: Avenir;
                font-size: 10px;
                text-align: center;
                color: #212121;
                margin: 0 auto;
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
            strong {
                color: #212121;
            }
            .datos-duenio {
                padding: 1em;
                display: flex;
                width: 50%;
                justify-content: space-between;
                img {
                    border-radius: 50%;
                }
                &__datos {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    &__name {
                        font-size: 14;
                        font-style: italic;
                    }
                    &__tipo {
                        font-size: 10px;
                    }
                }
            }
        }
    }
    .espacio-tooltip {
        display: none;
        position: absolute;
        left: -42%;
        top: 40%;
        background-color: #fff;
        box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.25);
        padding: 1em;
        font-size: 12px;
        width: 15em;
    }
    .msgAlert {
        padding: 1em;
        background-color: red;
        color: white;
        text-align: center;
        border-radius: 4px;
        margin-top: 2em;
        display: flex;
        justify-content: space-between;
    }
    .modal-reserva {
        position: absolute;
        z-index: 1000;
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
                .error-input {
                    border: 1px solid red;
                }
            }
        }
        &__content {
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
    .content-service {
        display: flex;
        align-items: end;
        font-size: 12px;
        img {
            margin-right: 1em;
        }
    }
    .container-tags {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-flow: wrap;
        .wt-tag {
            padding: .5em;
            border: 1px solid #dadada;
            border-radius: 2px;
            margin: 1em 1em 0 0;
        }
    }
    .btn-primary-pig--disable {
        width: 108px;
        height: 40px;
        background: rgba(252, 82, 137, 0.6);
        font-weight: 500;
        letter-spacing: -0.1px;
        color: white;
        border: 1px solid rgba(252, 82, 137, 0.6);
        border-radius: 2px;
    }
</style>