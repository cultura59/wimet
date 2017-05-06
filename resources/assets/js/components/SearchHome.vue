<template>
	<div class="wt-center-block">
		<div class="dropdown">
            <button class="dropbtn" @click="showSelectUbicacion()">
                <span>{{ubicacion}}</span>
                <i class="fa fa-sort-desc" aria-hidden="true"></i>
            </button>
            <div v-if="stUbicacion" class="dropdown__content">
                <span @click="selectUbucacion('CABA')">CABA</span>
                <span @click="selectUbucacion('Martinez')">Martinez</span>
                <span @click="selectUbucacion('San Isidro')">San Isidro</span>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn" @click="showSelectCategoria()">
                <span>{{(categoria == '') ? 'Qué estás planificando?' : categoria.label}}</span>
                <i class="fa fa-sort-desc" aria-hidden="true"></i>
            </button>
            <div v-if="stCategoria" class="dropdown__content">
            	<div v-for="cat in categorias"><span @click="selectCategoria(cat)">{{cat.label}}</span></div>
            </div>
        </div>
        <button class="btn wt-btn-primary" @click="searchEspacios()">BUSCAR</button>
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
              categorias: [
              	{velue: 1, label: 'Reuniones'},
              	{velue: 2, label: 'Eventos'},
              	{velue: 3, label: 'Producciones'},
              	{velue: 4, label: 'Pop-ups'}
              ]
            }
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
        		let url = `/search?ubicacion=${this.ubicacion}&categoria=${this.categoria.velue}`;
        		window.location.href = url;
            }
        }
	}
</script>