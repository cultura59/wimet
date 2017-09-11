<template>
    <div class="container">
        <div class="row wt-m-top-5">
            <div class="col-md-6">
                <h2>Ultimos usuarios</h2>
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apillido</th>
                        <th>Email</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                    <tr v-for="user in users.data" :key="user.id">
                        <td>{{user.id}}</td>
                        <td>{{user.firstname}}</td>
                        <td>{{user.lastname}}</td>
                        <td>{{user.email}}</td>
                        <td>{{$moment(user.created_at).format('DD/MM/YYYY')}}</td>
                        <td><a href="#"><i class="material-icons">edit</i></a></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h2>Ultimos espacios</h2>
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Paso</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                    <tr v-for="espacio in espacios.data" :key="espacio.id">
                        <td>{{espacio.id}}</td>
                        <td>{{espacio.name}}</td>
                        <td>{{espacio.step}}</td>
                        <td>{{(espacio.status == 1) ? 'Publicado' : 'Borrador'}}</td>
                        <td>{{$moment(espacio.created_at).format('DD/MM/YYYY')}}</td>
                        <td><a href="#"><i class="material-icons">edit</i></a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                users: '',
                espacios: ''
            }
        },
        mounted() {
            this.getUsers();
            this.getEspacios();
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
            getEspacios() {
                this.$http.get('api/espacio')
                .then(res => {
                    this.espacios = (res.body);
                }, err => {
                    console.log(err);
                });
            }
        }
    }
</script>