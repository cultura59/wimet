<template>
    <div class="container">
        <div>
            <h2>Espacios</h2>
            <table class="table table-striped">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Provincia</th>
                    <th>Paso</th>
                    <th>Estado</th>
                    <th>Creado</th>
                </tr>
                <tr v-for="espacio in espacios.data" :key="espacio.id" class="cursor-pointer">
                    <td>{{espacio.id}}</td>
                    <td>{{(espacio.name == null)? '-' : espacio.name}}</td>
                    <td>{{(espacio.city == null)? '-' : espacio.city}}</td>
                    <td>{{(espacio.state == null)? '-' : espacio.state}}</td>
                    <td>{{espacio.step}}</td>
                    <td>{{(espacio.status == 1) ? 'Publicado' : 'Borrador'}}</td>
                    <td>{{$moment(espacio.created_at).format('DD/MM/YYYY')}}</td>
                </tr>
            </table>
            <div class="wt-center-center">
                <a v-if="(this.espacios.prev_page_url != null)" href="#" @click="backEspacio($event)">Atrás</a><br>
                <a v-if="(this.espacios.next_page_url != null)" href="#" @click="nextEspacio($event)">Siguiente</a>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                espacios: ''
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
            backEspacio(e) {
                e.preventDefault();
                this.runUrl(this.espacios.prev_page_url);
            },
            nextEspacio(e) {
                e.preventDefault();
                this.runUrl(this.espacios.next_page_url);
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
            }
        }
    }
</script>