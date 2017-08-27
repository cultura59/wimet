<template>
    <div>
    	<div class="wt-center-block" id="search-desktop">
    		<div class="dropdown">
                <button class="dropbtn-left" @click="showSelectUbicacion()">
                    <span>{{ubicacion}}</span>
                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                </button>
                <div v-if="stUbicacion" class="dropdown__content-left">
                    <span class="contaniner-categorias" @click="selectUbucacion('CABA')">CABA</span>
                    <span class="contaniner-categorias" @click="selectUbucacion('Buenos Aires')">Gran Buenos Aires</span>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn-right" @click="showSelectCategoria()">
                    <span>{{(categoria == '') ? 'Qué estás planificando?' : categoria.name}}</span>
                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                </button>
                <div class="dropdown__content">
                    <div class="contaniner-categorias">
                        <span>Reuniones</span>
                        <span class="subCategoria">(Workshops, Presentación, Offsites)</span>
                    </div>
                    <div class="contaniner-categorias">
                        <span>Eventos</span>
                        <span class="subCategoria">(Corporativos, Sociales, Acciones /Promociones)</span>
                    </div>
                    <div class="contaniner-categorias">
                        <span>Producciones</span>
                        <span class="subCategoria">(Fotográficas, Filmaciones, Escénicas (musicales y teatrales))</span>
                    </div>
                    <div class="contaniner-categorias">
                        <span>Pop-ups</span>
                        <span class="subCategoria">(Store, Cursos, Exhibiciones &amp; Cenas)</span>
                    </div>
                </div>
            </div>
            <button class="wt-btn-primary" @click="searchEspacios()">BUSCAR</button>
    	</div>
        <div class="wt-center-column" id="search-mobile">
            <div class="dropdown wt-m-bot-1">
                <button class="dropbtn" @click="showSelectUbicacion()">
                    <span>{{ubicacion}}</span>
                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                </button>
                <div v-if="stUbicacion" class="dropdown__content">
                    <span class="contaniner-categorias" @click="selectUbucacion('CABA')">CABA</span>
                    <span class="contaniner-categorias" @click="selectUbucacion('Buenos Aires')">Buenos Aires</span>
                </div>
            </div>
            <div class="dropdown wt-m-bot-1">
                <button class="dropbtn" @click="showSelectCategoria()">
                    <span>{{(categoria == '') ? 'Qué estás planificando?' : categoria.name}}</span>
                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                </button>
                <div v-if="stCategoria" class="dropdown__content">
                    <div v-for="cat in categories" class="contaniner-categorias" @click="selectCategoria(cat)">
                        <span>{{cat.name}}</span>
                        <span class="subCategoria">{{showSubCategories(cat.sub_category)}}</span>
                    </div>
                </div>
            </div>
            <button class="btn-primary-pig-mobile" @click="searchEspacios()">BUSCAR</button>
        </div>
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
            showSubCategories(subCat) {
                let stringSubCat = "(";
                for(let i = 0; i < subCat.length; i++) {
                    stringSubCat += `${subCat[i].name}`;

                    if(i != subCat.length -1) {
                        stringSubCat += ", ";
                    }
                }
                stringSubCat += ")";
                return stringSubCat;
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

        		window.location.href = url += `&quanty=0-1000&price=100-10000`;
            },
            getCategories() {
                this.$http.get(`/api/categoria`)
                .then(res => {
                    this.categories = res.body;
                }, err => {
                    console.log(err);
                });
            }
        }
	}
</script>