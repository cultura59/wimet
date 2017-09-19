<template>
    <div>
        <h2>Eventos</h2>
        <table class="striped">
            <thead>
                <tr>
                <th>#</th>
                <th>Nombre</th>
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
                <td>{{evento.reserva_desde}}</td>
                <td>{{evento.reserva_hasta}}</td>
                <td>{{evento.total_horas}}</td>
                <td>${{evento.sub_total}}</td>
                <td>{{evento.estado}}</td>
                <td>{{$moment(evento.created_at).format('DD/MM/YYYY')}}</td>
                <td>
                    <router-link :to="`/admin/evento/${evento.id}/mensajes`">
                        <i class="material-icons">visibility</i>
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="wt-center-center">
            <a v-if="(this.eventos.prev_page_url != null)" href="#" @click="backevento($event)">Atrás</a><br>
            <a v-if="(this.eventos.next_page_url != null)" href="#" @click="nextevento($event)">Siguiente</a>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                eventos: ''
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
            }
        }
    }
</script>