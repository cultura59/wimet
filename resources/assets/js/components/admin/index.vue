<template>
    <div>
        <h2>Ultimos usuarios</h2>
        <table class="striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apillido</th>
                    <th>Email</th>
                    <th>Es anfitrión</th>
                    <th>Creado</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users.data" :key="user.id" class="cursor-pointer">
                    <td>{{user.id}}</td>
                    <td>{{user.firstname}}</td>
                    <td>{{user.lastname}}</td>
                    <td>{{user.email}}</td>
                    <td>{{(user.tipo_cliente_id == 2) ? 'Sí' : 'No'}}</td>
                    <td>{{$moment(user.created_at).format('DD/MM/YYYY')}}</td>
                </tr>
            </tbody>
        </table>
        <div class="wt-center-center">
            <a v-if="(this.users.prev_page_url != null)" href="#" @clieck="backUser($event)">Atrás</a><br>
            <a v-if="(this.users.next_page_url != null)" href="#" @clieck="nextUser($event)">Siguiente</a>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                users: ''
            }
        },
        mounted() {
            this.getUsers();
        },
        methods: {
            getUsers() {
                this.$http.get('api/user')
                .then(res => {
                    this.users = (res.body);
                }, err => {
                    console.log(err);
                });
            },
            backUser(e) {
                e.preventDefault();
                this.runUrl(this.users.prev_page_url);
            },
            nextUser(e) {
                e.preventDefault();
                this.runUrl(this.users.next_page_url);
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
                                this.users = resJson;
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