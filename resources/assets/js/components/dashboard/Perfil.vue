<template>
    <div>
        <div class="container-perfil">
            <span class="container-perfil__title">MI PERFIL</span>
        </div>
        <div class="perfil-main">
            <div class="row">
                <div class="col-xs-12 col-md-2">
                    <div class="container-avatar">
                        <label for="imagen">
                            <img class="label-avatar" :src="$store.getters.getUser.imagesource" :alt="$store.getters.getUser.firstname">
                        </label>
                        <input id="imagen" type="file" class="input-hidden" multiple @change="changeImage()">
                    </div>
                </div>
                <div class="col-xs-12 col-md-8">
                    <form class="row">
                        <div class="col-xs-12 col-md-6 wt-m-top-1">
                            <div class="wt-center-column">
                                <label>Nombre</label>
                                <input class="profile-input" type="text" v-model="$store.getters.getUser.firstname">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 wt-m-top-1">
                            <div class="wt-center-column">
                                <label>Apellido</label>
                                <input class="profile-input" type="text" v-model="$store.getters.getUser.lastname">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 wt-m-top-1">
                            <div class="wt-center-column">
                                <label>Empresa</label>
                                <input class="profile-input" type="text" v-model="$store.getters.getUser.businessName">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 wt-m-top-1">
                            <div class="wt-center-column">
                                <label>Rol</label>
                                <input class="profile-input" type="text" v-model="$store.getters.getUser.industry">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 wt-m-top-1">
                            <div class="wt-center-column">
                                <label>Teléfono</label>
                                <input class="profile-input" type="text" v-model="$store.getters.getUser.phone">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 wt-m-top-1">
                            <div class="wt-center-column">
                                <label>Ciudad de residencia</label>
                                <input class="profile-input" type="text" v-model="$store.getters.getUser.city">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 wt-m-top-1">
                            <div class="wt-center-column">
                                <label>Descricpción personal</label>
                                <textarea class="profile-textarea" v-model="$store.getters.getUser.personaldescription" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 wt-m-top-1">
                            <button class="wt-btn-primary pull-right" @click="saveUser($event)">GUARDAR</button>
                        </div>
                        <div class="wt-m-top-3">
                            <div class="col-xs-12 col-md-6 wt-m-top-1">
                                <div class="wt-center-column">
                                    <label>Nueva contraseña</label>
                                    <input class="profile-input" type="password" v-model="password">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 wt-m-top-1">
                                <div class="wt-center-column">
                                    <label>Repetir contraseña</label>
                                    <input class="profile-input" type="password" v-model="repassword">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12 wt-m-top-1">
                                <button class="wt-btn-primary pull-right" @click="changePassword($event)">GUARDAR</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-md-2"></div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                password: '',
                repassword: '',
                imagesource: ''
            }
        },
        methods: {
            saveUser(e) {
                e.preventDefault();
                this.$http.put(`api/user/${this.$store.getters.getUser.id}`, this.$store.getters.getUser)
                .then(res => {
                    this.$toastr.success('Sus datos fueron modificados correctamente!');
                }, err => {
                    this.$toastr.error(err, 'Inconceivable!');
                });
            },
            changePassword(e) {
                e.preventDefault();
                if(this.password !== this.repassword) {
                    this.$toastr.error(`La mismas no son iguales`, 'Revisa las contraseñas');
                    return;
                }
                this.$http.get(`api/changepassword/${this.$store.getters.getUser.id}/password/${this.password}`)
                .then(res => {
                    console.info(res.body);
                    this.$toastr.success('La contraseña fue modificada correctamente!');
                }, err => {
                    console.info(err);
                    this.$toastr.error(`La contraseña no se modifico, ${err}`, 'Ups hubo un error');
                });
            },
            changeImage() {
                let control = document.getElementById("imagen"),
                    file = control.files[0],
                    formData = new FormData();
                //Check the file type
                if (!file.type.match('image.*')) {
                    this.$toastr.error(`El archivo debe ser una imagen`, 'Ups hubo un error');
                    return;
                }
                //Check the file type
                if (file.size >= 2000000) {
                    this.$toastr.error(`El archivo debe pesar menos de 2MB`, 'Ups hubo un error');
                    return;
                }
                // Add the file to the request.
                formData.append('image', file, file.name);
                fetch(`/api/user/foto/${this.$store.getters.getUser.id}`, {
                    method: 'post',
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${this.$auth.getToken()}`
                    },
                    body: formData
                })
                .then((res)=> {
                    if (res.status === 200 || res.status === 0) {
                        this.getUser();
                        this.$toastr.success(`El archivo fue cargado correctamente`, 'Avatar modificado');
                    } else {
                        this.$toastr.error(`El archivo no se pudo cargar, vuelva a intentarlo`, 'Ups hubo un error');
                    }
                })
                .then((resJson) => {
                    console.log(resJson);
                });
            },
            getUser() {
                this.$http.get(`api/user/${this.$store.getters.getUser.id}`)
                .then(res => {
                    this.$store.commit('setUser', res.body);
                }, err => {
                    this.$toastr.error(err, 'Inconceivable!');
                });
            }
        }
    }
</script>
<style lang="sass" scoped>
    .container-perfil {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 0 2em;
        margin-top: 4em;
        align-items: flex-end;
        &__title {
            font-family: Avenir;
            font-size: 16px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 1em;
        }
    }
    .perfil-main {
        padding: 3em 2em;
        background-color: #ffffff;
        box-shadow: 0 0 68px 0 rgba(0, 0, 0, 0.1);
        label {
            color: #333;
        }
        .profile-input, .profile-textarea {
            color: #333;
            border: 1px solid #dadada;
            padding: .5em;
            overflow: hidden;
        }
        .container-avatar {
            margin: 1em;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            .label-avatar {
                width: 140px;
                height: 140px;
                background-size: cover;
                border-radius: 50%;
                cursor: pointer;
            }
            .perfil-btn-trasnparent {
                background: transparent;
                color: #fc5289;
                border: 2px solid #fc5289;
                border-radius: 2px;
                margin-top: 1em;
                label {
                    color: #fc5289;
                    padding: .5em 3em;
                    cursor: pointer;
                }
            }
            .input-hidden {
                display: none
            }
        }
    }
</style>