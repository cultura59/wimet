<template>
    <div>
        <h2>Mensajes</h2>
        <table class="highlight center responsive-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Mensaje</th>
                <th>Creado</th>
                <th>Estado</th>
                <th colspan="2">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(mensaje, key) in mensajes.data" :key="mensaje.id" class="cursor-pointer">
                <td>{{mensaje.id}}</td>
                <td>{{(mensaje.firstname == "")? '-' : mensaje.firstname}}</td>
                <td v-if="!(mensaje.id == mensajeSelected.id)">{{mensaje.mensaje}}</td>
                <td v-if="mensaje.id == mensajeSelected.id">
                    <input type="text" v-model="mensaje.mensaje">
                    <a href="#" @click="updateMensaje($event, mensaje, key)"><i class="material-icons">save</i></a>
                </td>
                <td>{{$moment(mensaje.created_at).format('DD/MM/YYYY')}}</td>
                <td>{{(mensaje.status == false)? 'Pendiente' : 'Enviado'}}</td>
                <td>
                    <a href="#" @click="selectMensaje($event, mensaje)"><i class="material-icons">edit</i></a>
                </td>
                <td><a href="#" @click="enviarMensaje($event, mensaje.id, key)"><i class="material-icons">send</i></a></td>
            </tr>
            </tbody>
        </table>
        <div class="wt-center-center">
            <a v-if="(this.mensajes.prev_page_url != null)" href="#" @click="backmensaje($event)">Atrás</a><br>
            <a v-if="(this.mensajes.next_page_url != null)" href="#" @click="nextmensaje($event)">Siguiente</a>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                mensajes: '',
                mensajeSelected: {}
            }
        },
        mounted() {
            this.getmensajes();
        },
        methods: {
            getmensajes() {
                this.$http.get(`api/mensaje/${this.$route.params.id}`)
                    .then(res => {
                        this.mensajes = (res.body);
                    }, err => {
                        console.log(err);
                    });
            },
            selectMensaje(e, mensaje) {
                e.preventDefault();
                this.mensajeSelected = mensaje;
            },
            updateMensaje(e, mensaje, key) {
                e.preventDefault();
                this.$http.put(`api/mensaje/${mensaje.id}`, mensaje)
                .then(res => {
                    this.mensajes[key] = res.body;
                    this.mensajeSelected = {};
                    alert('El mensaje fue modificado!');
                }, err => {
                    console.log(err);
                });
            },
            enviarMensaje(e, id, key){
                e.preventDefault();
                this.$http.get(`api/mensaje/${id}/send`)
                .then(res => {
                    this.mensajes[key] = res.body;
                    alert('El mensaje fue enviado!');
                }, err => {
                    console.log(err);
                });
            },
            backmensaje(e) {
                e.preventDefault();
                this.runUrl(this.mensajes.prev_page_url);
            },
            nextmensaje(e) {
                e.preventDefault();
                this.runUrl(this.mensajes.next_page_url);
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
                                this.mensajes = resJson;
                            });
                        }
                    )
                    .catch(function(err) {
                        console.log('Fetch Error :-S', err);
                    });
            }
        }
    }
</script>