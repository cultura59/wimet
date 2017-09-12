<template>
    <div class="container">
        <div>
            <h2>Espacios</h2>
            <table class="table table-striped">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Dueño</th>
                    <th>Ciudad</th>
                    <th>Provincia</th>
                    <th>Paso</th>
                    <th>Estado</th>
                    <th>Creado</th>
                    <th colspan="3">Acciones</th>
                </tr>
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
                            :href="`/categoria/${espacio.categorias[0].id}/espacio/${espacio.id}`"
                            target="_blank">Ver
                        </a>
                        <span v-if="(!espacio.categorias.length > 0)">-</span>
                    </td>
                    <td>
                        <a
                            v-if="(espacio.categorias.length > 0)"
                            :href="`/publicar/espacio/${espacio.id}`"
                            target="_blank">Editar
                        </a>
                        <span v-if="(!espacio.categorias.length > 0)">-</span>
                    </td>
                    <td>
                        <a v-if="(espacio.status == 0)" href="#" @click="updateEspacio($event, espacio, key)">Activar</a>
                        <a v-if="(espacio.status == 1)" href="#" @click="updateEspacio($event, espacio, key)">Desactivar</a>
                    </td>
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
            updateEspacio(e, espacio, key) {
                e.preventDefault();
                espacio.status = !espacio.status;
                this.$http.put(`api/espacio/${espacio.id}`, espacio)
                    .then(res => {
                        this.espacios[key] = res.body;
                    }, err => {
                        espacio.status = !espacio.status;
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