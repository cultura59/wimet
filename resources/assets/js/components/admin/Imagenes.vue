<template>
    <div class="container">
        <h2>imagenes</h2>
        <div class="row">
            <div class="col s12 m4" v-for="(imagen, key) in imagenes" :key="imagen.id">
                <div class="card">
                    <div class="card-image">
                        <img :src="`https://res.cloudinary.com/wimet/image/upload/q_60/${imagen.name}`" class="responsive-img">
                    </div>
                    <div class="card-content">
                        <input type="text" v-model="imagen.imgorder" placeholder="Orden de la imagen" class="form-control">
                    </div>
                    <div class="card-action">
                        <a class="waves-effect btn" @click="updateImagen($event, imagen)">Guardar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="wt-center-center">
            <a v-if="(this.imagenes.prev_page_url != null)" href="#" @click="backimagen($event)">Atrás</a><br>
            <a v-if="(this.imagenes.next_page_url != null)" href="#" @click="nextimagen($event)">Siguiente</a>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                imagenes: ''
            }
        },
        mounted() {
            this.getImagenes();
        },
        methods: {
            getImagenes() {
                this.$http.get(`api/image/${this.$route.params.id}`)
                .then(res => {
                    this.imagenes = (res.body);
                }, err => {
                    console.log(err);
                });
            },
            updateImagen(e, imagen, key) {
                e.preventDefault();
                this.$http.put(`api/image/${imagen.id}`, imagen)
                    .then(res => {
                        this.imagenes[key] = res.body;
                        alert('Orden imagen, se guardo el nuevo orden de la imagen');
                    }, err => {
                        console.log(err);
                    });
            },
            backimagen(e) {
                e.preventDefault();
                this.runUrl(this.imagenes.prev_page_url);
            },
            nextimagen(e) {
                e.preventDefault();
                this.runUrl(this.imagenes.next_page_url);
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
                            this.imagenes = resJson;
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