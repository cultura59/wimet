<template>
    <div>
        <h2>Espacios</h2>
        <div class="row">
            <div class="col s12 m3 offset-m9">
                <label>Filtros pasos</label>
                <select v-model="step" @change="selectStep()">
                    <option value="">Seleccione un paso</option>
                    <option value="1">Selecciono categoria</option>
                    <option value="2">Finalizo Primer paso</option>
                    <option value="3">Finalizo Segundo paso</option>
                    <option value="4">Finalizo Tercer paso</option>
                    <option value="5">Pendiente de aprobación</option>
                    <option value="6">Espacios aprobados</option>
                </select>
            </div>
        </div>
        <span>Total espacios: {{espacios.total}}</span>
        <table class="highlight center responsive-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Dueño</th>
                    <th>Ciudad</th>
                    <th>Provincia</th>
                    <th>Paso</th>
                    <th>Estado</th>
                    <th>Creado</th>
                    <th colspan="6">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(espacio, key) in espacios.data" :key="espacio.id" class="cursor-pointer">
                    <td>{{espacio.id}}</td>
                    <td>{{(espacio.name == null)? '-' : espacio.name}}</td>
                    <td>{{espacio.user.firstname}} {{espacio.user.lastname}}</td>
                    <td>{{(espacio.city == null)? '-' : espacio.city}}</td>
                    <td>{{(espacio.state == null)? '-' : espacio.state}}</td>
                    <td>{{espacio.step}}</td>
                    <td>{{(espacio.status == 1) ? 'Publicado' : 'Borrador'}}</td>
                    <td>{{$moment(espacio.created_at).format('DD/MM/YYYY')}}</td>
                    <td>
                        <a
                            v-if="(espacio.categorias.length > 0)"
                            :href="`/categoria/${espacio.categorias[0].id}/espacio/${espacio.name}`"
                            target="_blank" title="Ver"><i class="material-icons">visibility</i>
                        </a>
                        <span v-if="(!espacio.categorias.length > 0)">-</span>
                    </td>
                    <td>
                        <a
                            v-if="(espacio.categorias.length > 0)"
                            :href="`/publicar/espacio/${espacio.id}`"
                            target="_blank"><i class="material-icons" title="Editar">edit</i>
                        </a>
                        <span v-if="(!espacio.categorias.length > 0)">-</span>
                    </td>
                    <td>
                        <router-link :to="`/espacio/${espacio.id}/imagenes`" title="Imagenes">
                            <i class="material-icons">perm_media</i>
                        </router-link>
                    </td>
                    <td>
                        <a v-if="(espacio.status == 0)" href="#" @click="updateEspacio($event, espacio, key)" title="Activar">
                            <i class="material-icons">thumb_down</i>
                        </a>
                        <a v-if="(espacio.status == 1)" href="#" @click="updateEspacio($event, espacio, key)" title="Desactivar">
                            <i class="material-icons">thumb_up</i>
                        </a>
                    </td>
                    <td>
                        <a href="#" @click="deleteEspacio($event, espacio.id, key)" title="Borrar">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                    <td>
                        <a href="#" @click="actionModal($event, espacio)" title="Detalles">
                            <i class="material-icons">details</i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="wt-center-center">
            <a v-if="(espacios.prev_page_url != null)" href="#" @click="backEspacio($event)">
                <i class="material-icons">navigate_before</i>
            </a>
            <a v-if="(espacios.next_page_url != null)" href="#" @click="nextEspacio($event)">
                <i class="material-icons">navigate_next</i>
            </a>
        </div>
        <div id="myModal" class="modal-espacio" v-if="showModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close" @click="actionModal($event, null)">&times;</span>
                    <h4>Datos del espacio</h4>
                </div>
                <div class="modal-body">
                    <ul class="tabs">
                        <li class="tab col s3">
                            <a :class="{active: (showStep == 'primer-paso')}" href="#" @click="changeStep($event, 'primer-paso')">Primer paso</a>
                        </li>
                        <li class="tab col s3">
                            <a :class="{active: (showStep == 'segundo-paso')}" href="#" @click="changeStep($event, 'segundo-paso')">Segundo paso</a>
                        </li>
                        <li class="tab col s3">
                            <a :class="{active: (showStep == 'tercer-paso')}" href="#" @click="changeStep($event, 'tercer-paso')">Tercer paso</a>
                        </li>
                    </ul>
                    <ul class="collection with-header" v-show="(showStep == 'primer-paso')">
                        <li class="collection-header"><h5>Primer paso</h5></li>
                        <li class="collection-item">Actividades: <span>{{(espacioSelected.categorias.length > 0)?'Cargado':'No cargado'}}</span></li>
                        <li class="collection-item">Accebilidad: <span>{{(espacioSelected.access.length > 0)?'Cargado':'No cargado'}}</span></li>
                        <li class="collection-item">Ambiente: <span>{{(espacioSelected.quantyrooms > 0)?espacioSelected.quantyrooms:'No cargado'}}</span></li>
                        <li class="collection-item">Capacidad: <span>{{(espacioSelected.quanty>0)?espacioSelected.quanty:'No cargado'}}</span></li>
                        <li class="collection-item">De pie: <span>{{(espacioSelected.foot>0)?espacioSelected.foot:'No cargado'}}</span></li>
                        <li class="collection-item">Sentados: <span>{{(espacioSelected.seated>0)?espacioSelected.seated:'No cargado'}}</span></li>
                        <li class="collection-item">Dirección: <span>{{(espacioSelected.adress !== null)?espacioSelected.adress:'No cargado'}}</span></li>
                    </ul>
                    <ul class="collection with-header" v-show="(showStep == 'segundo-paso')">
                        <li class="collection-header"><h5>Segundo paso</h5></li>
                        <li class="collection-item">Imagenes: <span>{{(espacioSelected.images.length > 0)?'Cargadas':'No cargadas'}}</span></li>
                        <li class="collection-item">Características: <span>{{(espacioSelected.characteristics.length > 0)?'Cargadas':'No cargadas'}}</span></li>
                        <li class="collection-item">Amenities: <span>{{(espacioSelected.servicios.length > 0)?'Cargados':'No cargados'}}</span></li>
                        <li class="collection-item">Descripción: <span>{{(espacioSelected.description !== "")?"Cargada":'No cargada'}}</span></li>
                    </ul>
                    <ul class="collection with-header" v-show="(showStep == 'tercer-paso')">
                        <li class="collection-header"><h5>Tercer paso</h5></li>
                        <li class="collection-item">Reglas: <span>{{(espacioSelected.rules.length > 0)?'Cargadas':'No cargadas'}}</span></li>
                        <li class="collection-item">Precios: <span>{{(espacioSelected.prices.length > 0)?'Cargados':'No cargados'}}</span></li>
                        <li class="collection-item">Política de cancelación: <span>{{(espacioSelected.cancellationflexibility !== null)?espacioSelected.cancellationflexibility:'No cargada'}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'Espacios',
        data() {
            return {
                espacios: '',
                showModal: false,
                espacioSelected: null,
                showStep: 'primer-paso',
                step: ''
            }
        },
        mounted() {
            this.getEspacios();
        },
        methods: {
            getEspacios() {
                this.$http.get('api/espacio')
                .then(res => {
                    this.espacios = (res.body);
                }, err => {
                    console.log(err);
                });
            },
            updateEspacio(e, espacio, key) {
                e.preventDefault();
                espacio.step = 6;
                espacio.status = !espacio.status;
                this.$http.put(`api/espacio/${espacio.id}`, espacio)
                    .then(res => {
                        this.espacios[key] = res.body;
                    }, err => {
                        espacio.status = !espacio.status;
                        console.log(err);
                    });
            },
            deleteEspacio(e, id, key) {
                let vm = this;
                this.$http.delete(`api/espacio/${id}`)
                    .then(res => {
                        alert('El espacio fue borrado');
                        this.getEspacios();
                    }, err => {
                        console.log(err);
                    });
            },
            backEspacio(e) {
                e.preventDefault();
                let url = this.espacios.prev_page_url.replace('http://127.0.0.1:3000', "https://wimet.co");
                this.runUrl(url);
            },
            nextEspacio(e) {
                e.preventDefault();
                let url = this.espacios.next_page_url.replace('http://127.0.0.1:3000', "https://wimet.co");
                this.runUrl(url);
            },
            runUrl(url) {
                fetch(url, {method: 'GET', headers: {'Authorization': `Bearer ${this.$auth.getToken()}`}})
                .then((response) => {
                        if (response.status !== 200) {
                            console.log('Looks like there was a problem. Status Code: ' +
                                response.status);
                            return;
                        }
                        response.json().then((resJson) => {
                            this.espacios = resJson;
                        });
                    }
                )
                .catch(function(err) {
                    console.log('Fetch Error :-S', err);
                });
            },
            changeStep(e, step) {
                e.preventDefault();
                this.showStep = step;
            },
            selectStep() {
                this.$http.get(`api/espacio?step=${this.step}`)
                .then(res => {
                    this.espacios = (res.body);
                }, err => {
                    console.log(err);
                });
            },
            actionModal(e, espacio){
                e.preventDefault();
                this.espacioSelected = espacio;
                this.showModal = !this.showModal;
            }
        }
    }
</script>
<style scoped>
    .modal-espacio {
        position: fixed;
        z-index: 1;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 60%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }
    @-webkit-keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }
    @keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }
    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
    .modal-header {
        padding: 2px 16px;
        background-color: #FC5289;
        color: white;
    }
    .modal-body {padding: 2px 16px;}
    select {
        display: block;
    }
</style>