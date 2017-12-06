<template>
    <div class="perfil-main">
        <div class="row">
            <div class="col-xs-12 col-md-6">
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
                        <button class="wt-btn-primary" @click="saveUser($event)">GUARDAR</button>
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
                            <button class="wt-btn-primary" @click="changePassword($event)">GUARDAR</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="container-avatar">
                    <img class="label-avatar" :src="$store.getters.getUser.imagesource" :alt="$store.getters.getUser.firstname">
                    <button class="perfil-btn-trasnparent">
                        <label for="imagen">CARGAR</label>
                    </button>
                    <input id="imagen" type="file" class="input-hidden" multiple @change="changeImage()">
                </div>
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
                    console.info(res.body);
                    this.$toastr.success('Sus datos fueron modiificados correctamente!');
                }, err => {
                    console.info(err);
                    this.$toastr.error('I do not think that word means what you think it means.', 'Inconceivable!');
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
                    files = control.files,
                    len = files.length;
                console.log(control);
                console.log(files);
                console.log(len);
                for (let i = 0; i < len; i++) {
                    console.log("Filename: " + files[i].name);
                    console.log("Type: " + files[i].type);
                    console.log("Size: " + files[i].size + " bytes");
                }
            }
        }
    }
</script>
<style lang="sass" scoped>
    .perfil-main {
        padding: 1em 5em;
        width: 85%;
        margin: 0 auto;
        label {
            color: #333;
        }
        .profile-input, .profile-textarea {
            color: #333;
            border: 1px solid #666;
            padding: .5em;
        }
        .container-avatar {
            margin: 1em;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            .label-avatar {
                width: 13em;
                height: 13em;
                background-size: cover;
                border-radius: 50%;
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