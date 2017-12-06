export const registerLogin = {
    data() {
        return {
            email: '',
            password: '',
            imagesource: '',
            msgError: '',
            authenticated: this.$auth.isAuthenticated(),
            terminos: true,
            showBtnLogin: true
        }
    },
    methods: {
        registrar() {
            if(!this.terminos) {
                this.msgError = 'Debe aceptar los terminos y condiciones';
                setInterval(() => {
                    this.msgError = '';
                }, 3000);
                return;
            }
            this.showBtnLogin = false;
            let data = {
                firstname: this.firstname,
                lastname: this.lastname,
                email: this.email,
                password: this.password,
                imagesource: this.imagesource,
                status: false
            };
            this.$http.post('api/user', data)
                .then(res => {
                    if(res.status == 200) {
                        this.showModalRegistro = false;
                        swal('Cuenta registrada!', 'Se ha enviado un email a su correo', 'success');
                    }else {
                        this.showBtnLogin = true;
                        swal('Ups, algo salio mal', res.message, 'error');
                    }
                });
        },
        login() {
            this.showBtnLogin = false;
            let data = {
                client_id: 2,
                client_secret: 'XjZ3yp33zTrPdF0vWPLPH1sQ62swzzbBVvAnJa0A',
                grant_type: 'password',
                username: this.email,
                password: this.password
            }
            this.$http.post('oauth/token', data)
                .then(res => {
                    if(res.status == 200) {
                        this.$auth.setToken(res.body.access_token, res.body.expires_in + Date.now());
                        this.showModalLogin = false;
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                }, err => {
                    this.$http.get(`api/emailexist/${this.email}`)
                    .then(resp => {
                        if(resp.body == "") {
                            this.showBtnLogin = true;
                            this.msgError = `El email no existe, registralo :)`;
                            setInterval(() => {
                                this.msgError = '';
                            }, 4000);
                        }else {
                            this.showBtnLogin = true;
                            this.msgError = `La contraseña no es correcta, intente nuevamente`;
                            setInterval(() => {
                                this.msgError = '';
                            }, 5000);
                        }
                    });
                });
        },
        logout(event) {
            event.preventDefault();
            this.$store.commit('clearInfo');
            gapi.auth.signOut();
            FB.getLoginStatus((resStatusFb) => {
                resStatusFb.status === 'connected';
                FB.logout();
            });
            window.localStorage.clear();
            location.href = '/';
        },
        getUserAuthenticated() {
            let vm = this;
            if(this.$auth.isAuthenticated()) {
                if (localStorage.getItem("user") !== null){
                    this.user = this.$auth.getUser();
                } else {
                    vm.$http.get('api/usersession')
                    .then(res => {
                        this.$store.commit('setUser', res.body);
                    });
                }
            }
        }
    }
};