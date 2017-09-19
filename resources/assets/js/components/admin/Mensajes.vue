<template>
    <div>
        <h2>Mensajes</h2>
        <table class="striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Mensaje</th>
                <th>Creado</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="mensaje in mensajes.data" :key="mensaje.id" class="cursor-pointer">
                <td>{{mensaje.id}}</td>
                <td>{{(mensaje.firstname == "")? '-' : mensaje.firstname}}</td>
                <td>{{mensaje.mensaje}}</td>
                <td>{{$moment(mensaje.created_at).format('DD/MM/YYYY')}}</td>
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
                mensajes: ''
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
            updateMensaje(e, mensaje, key) {
                e.preventDefault();
                this.$http.put(`api/mensaje/${mensaje.id}`, mensaje)
                    .then(res => {
                        this.mensajes[key] = res.body;
                        alert('El mensaje fue modificado!');
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