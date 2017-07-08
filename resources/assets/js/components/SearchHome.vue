<template>
	<div class="wt-center-block">

		<div class="dropdown">
            <button class="dropbtn-left" @click="showSelectUbicacion()">
                <span>{{ubicacion}}</span>
                <i class="fa fa-sort-desc" aria-hidden="true"></i>
            </button>
            <div v-if="stUbicacion" class="dropdown__content">
                <span @click="selectUbucacion('CABA')">CABA</span>
                <span @click="selectUbucacion('Vicente López')">Vicente López</span>
                <span @click="selectUbucacion('San Isidro')">San Isidro</span>
                <span @click="selectUbucacion('Tigre')">Tigre</span>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn-right" @click="showSelectCategoria()">
                <span>{{(categoria == '') ? 'Qué estás planificando?' : categoria.name}}</span>
                <i class="fa fa-sort-desc" aria-hidden="true"></i>
            </button>
            <div v-if="stCategoria" class="dropdown__content">
            	<div v-for="cat in categories"><span @click="selectCategoria(cat)">{{cat.name}}</span></div>
            </div>
        </div>
        <button class="wt-btn-primary" @click="searchEspacios()">BUSCAR</button>
	</div>
</template>
<script>
	export default {
		data() {
            return {
              ubicacion: 'Ubicación',
              categoria: '',
              stUbicacion: false,
              stCategoria: false,
              categories: []
            }
        },
        mounted() {
            this.getCategories();
        },
        methods: {
        	selectUbucacion(ubi) {
        		this.ubicacion = ubi;
        		this.stUbicacion = false;
        	},
        	selectCategoria(cat) {
        		this.categoria = cat;
        		this.stCategoria = false;
        	},
            showSelectUbicacion() {
            	this.stUbicacion = !this.stUbicacion;
            	if(this.stCategoria) {
            		this.stCategoria = false;
            	}
            },
            showSelectCategoria() {
            	this.stCategoria = !this.stCategoria;
            	if(this.stUbicacion) {
            		this.stUbicacion= false;
            	}
            },
        	searchEspacios () {
        		let url = `/search`;

                if(this.ubicacion !== 'Ubicación') {
                    url += `?ubicacion=${this.ubicacion}`;
                }else{
                    url += `?ubicacion=`;
                }
                
                if(this.categoria.id !== undefined) {
                    url += `&categoria=${this.categoria.id}`;
                }

        		window.location.href = url += `&quanty=0-100&price=100-10000`;
            },
            getCategories() {
                this.$http.get(`/api/categoria`)
                .then(res => {
                    this.categories = res.body;
                }, err => {
                    console.log(err);
                });
            },
        }
	}
</script>