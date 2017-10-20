<template>
    <div>
        <h2>Eventos</h2>
        <div class="row">
            <div class="col s12 m3 offset-m9">
                <label>Filtros pasos</label>
                <select v-model="statusEvento" @change="selectEstado()">
                    <option value="">Seleccione estado</option>
                    <option value="consulta">Consulta</option>
                    <option value="seguimiento">Seguimiento</option>
                </select>
            </div>
        </div>
        <span>Total eventos: {{eventos.total}}</span>
        <table class="striped responsive-table">
            <thead>
                <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Espacio</th>
                <th>Fecha desde</th>
                <th>Fecha hasta</th>
                <th>Total horas</th>
                <th>Precio estimado</th>
                <th>Estado</th>
                <th>Creado</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="evento in eventos.data" :key="evento.id" class="cursor-pointer">
                <td>{{evento.id}}</td>
                <td>{{(evento.titulo_cliente == "")? '-' : evento.titulo_cliente}}</td>
                <td>{{evento.name}}</td>
                <td>{{evento.reserva_desde}}</td>
                <td>{{evento.reserva_hasta}}</td>
                <td>{{evento.total_horas}}</td>
                <td>${{evento.sub_total}}</td>
                <td>{{evento.estado}}</td>
                <td>{{$moment(evento.created_at).format('DD/MM/YYYY')}}</td>
                <td>
                    <router-link :to="`/evento/${evento.id}/mensajes`">
                        <i class="material-icons">visibility</i>
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="wt-center-center">
            <a v-if="(this.eventos.prev_page_url != null)" href="#" @click="backevento($event)">
                <i class="material-icons">navigate_before</i>
            </a>
            <a v-if="(this.eventos.next_page_url != null)" href="#" @click="nextevento($event)">
                <i class="material-icons">navigate_next</i>
            </a>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                eventos: '',
                statusEvento: ''
            }
        },
        mounted() {
            this.geteventos();
        },
        methods: {
            geteventos() {
                this.$http.get('api/evento')
                .then(res => {
                    this.eventos = (res.body);
                }, err => {
                    console.log(err);
                });
            },
            backevento(e) {
                e.preventDefault();
                this.runUrl(this.eventos.prev_page_url);
            },
            nextevento(e) {
                e.preventDefault();
                this.runUrl(this.eventos.next_page_url);
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
                            this.eventos = resJson;
                        });
                    }
                )
                .catch(function(err) {
                    console.log('Fetch Error :-S', err);
                });
            },
            selectEstado() {
                this.$http.get(`api/evento?statusEvento=${this.statusEvento}`)
                    .then(res => {
                        this.eventos = (res.body);
                    }, err => {
                        console.log(err);
                    });
            },
        }
    }
</script>
<style scoped>
    select {
        display: block;
    }
</style>