<template>
    <div>
        <h2>Espacios</h2>
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
                    <th colspan="5">Acciones</th>
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
                            :href="`/categoria/${espacio.categorias[0].id}/espacio/${espacio.id}`"
                            target="_blank"><i class="material-icons">visibility</i>
                        </a>
                        <span v-if="(!espacio.categorias.length > 0)">-</span>
                    </td>
                    <td>
                        <a
                            v-if="(espacio.categorias.length > 0)"
                            :href="`/publicar/espacio/${espacio.id}`"
                            target="_blank"><i class="material-icons">edit</i>
                        </a>
                        <span v-if="(!espacio.categorias.length > 0)">-</span>
                    </td>
                    <td>
                        <router-link :to="`/admin/espacio/${espacio.id}/imagenes`">
                            <i class="material-icons">perm_media</i>
                        </router-link>
                    </td>
                    <td>
                        <a v-if="(espacio.status == 0)" href="#" @click="updateEspacio($event, espacio, key)">
                            <i class="material-icons">thumb_down</i>
                        </a>
                        <a v-if="(espacio.status == 1)" href="#" @click="updateEspacio($event, espacio, key)">
                            <i class="material-icons">thumb_up</i>
                        </a>
                    </td>
                    <td>
                        <a href="#" @click="deleteEspacio($event, espacio.id, key)">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="wt-center-center">
            <a v-if="(this.espacios.prev_page_url != null)" href="#" @click="backEspacio($event)">
                <i class="material-icons">navigate_before</i>
            </a>
            <a v-if="(this.espacios.next_page_url != null)" href="#" @click="nextEspacio($event)">
                <i class="material-icons">navigate_next</i>
            </a>
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