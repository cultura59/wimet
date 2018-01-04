<template>
    <div class="wt-m-top-3">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <h1 class="publica-titulo">Define la disponibilidad</h1>
                <h1 class="publica-titulo">de tu espacio</h1>
                <h4 class="wt-m-top-2">Elige los días que tu espacio podría estar disponible.</h4>
                <div class="container-disponibilidad-btn-default">
                    <button
                            @click="addDisponibilidad('Lunes')"
                            :class="estaDisponible('Lunes')">
                        Lunes
                    </button>
                    <button
                            @click="addDisponibilidad('Martes')"
                            :class="estaDisponible('Martes')">
                        Martes
                    </button>
                    <button
                            @click="addDisponibilidad('Miércoles')"
                            :class="estaDisponible('Miércoles')">
                        Miércoles
                    </button>
                    <button
                            @click="addDisponibilidad('Jueves')"
                            :class="estaDisponible('Jueves')">
                        Jueves
                    </button>
                    <button
                            @click="addDisponibilidad('Viernes')"
                            :class="estaDisponible('Viernes')">
                        Viernes
                    </button>
                    <button
                            @click="addDisponibilidad('Sábado')"
                            :class="estaDisponible('Sábado')">
                        Sábado
                    </button>
                    <button
                            @click="addDisponibilidad('Domingo')"
                            :class="estaDisponible('Domingo')">
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
                        <template v-if="(item.inicio == 0 && item.fin == 0)">
						<span>
							No disponible
							<i class="fa fa-trash cursor-pointer" @click="removeDisponibilidad(item)"></i>
						</span>
                        </template>
                        <template v-if="(item.inicio == 0 && item.fin == 24)">
						<span>
							Abierto 24hs
							<i class="fa fa-trash cursor-pointer" @click="removeDisponibilidad(item)"></i>
						</span>
                        </template>
                        <template v-if="(item.inicio != 0 && item.fin != 24)">
						<span>
							{{item.inicio}} a {{item.fin}} hs
							<i class="fa fa-trash cursor-pointer" @click="removeDisponibilidad(item)"></i>
						</span>
                        </template>
                    </div>
                </div>
                <div class="wt-space-block wt-m-top-3">
                    <button class="btn-publica-step-default">
                        <img src="https://res.cloudinary.com/wimet/image/upload/v1512746740/ic_keyboard_backspace_black_24px.svg">
                        <span>ATRÁS</span>
                    </button>
                    <img v-show="!btnSend" src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-pig_oxestq.svg" alt="Cargando ..." height="50px" />
                    <button v-show="btnSend" class="btn-publica-step-primary" @click="saveDisponibilidad($event)">GUARDAR Y CONTINUAR</button>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <img src="https://res.cloudinary.com/wimet/image/upload/v1512792368/wimet_disponibilidad.svg" class="img-responsive">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "disponibilidad",
        data() {
            return {
                btnSend: true,
                disponibilidad: [],
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
                this.$http.get(`/api/disponibilidad/${this.$store.getters.getEspacio.id}`)
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
                            this.$toastr.error('Día ya seleccionado', `El dia ${day} ya posee una configuración.`);
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
                    this.$toastr.error('Campos requeridos!', 'Debe seleccionar algún dia y horarios de disponibilidad');
                    return;
                }
                this.disponibilidad.forEach((element) => {
                    vm.agrupadorDias.push({
                        espacio_id: this.$store.getters.getEspacio.id,
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
                this.btnSend = false;
                this.$http.post(`/api/disponibilidad`, this.agrupadorDias)
                .then(res => {
                    if(res.status == 200) {
                        this.getEspacio(this.$store.getters.getEspacio.id);
                    }
                }, err => {
                    this.btnSend = true;
                });
            },
            getEspacio(id) {
                this.$http.get(`api/espacio/${id}`)
                .then(res => {
                    this.$store.commit('setEspacio', res.body);
                    this.$router.push({ name: "foto"});
                }, err => {
                    this.btnSend = true;
                    $toastr.error("Ups...", "Hubo un problema al modificar su espacio, vuelva a intentarlo");
                });
            }
        }
    }
</script>

<style lang="sass" scoped>
    .container-disponibilidad-btn-default {
        margin: 2em 0;
        button {
            width: 76px;
            height: 40px;
            background-color: #ffffff;
            border: none;
            &:hover {
                color: #fc5289;
                border: solid 1px #fc5289;
                border-radius: 2px;
                transition: none;
            }
        }
        .btn-disponibilidad--active {
            width: 76px;
            height: 40px;
            background-color: #fc5289;
            color: #ffffff;
            border: none;
            border-radius: 2px;
            &:hover {
                background-color: #fc5289;
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