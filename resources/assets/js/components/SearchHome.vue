<template>
    <div>
    	<div id="search-desktop">
    		<div class="content-dropbtn-select">
                <div class="dropdown">
                    <button class="dropbtn-left" @click="showSelectUbicacion()">
                        <div class="wt-center-center">
                            <span class="slash-search"></span>
                            <span class="wt-mayuscula">{{ubicacion}}</span>
                        </div>
                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    </button>
                    <div v-if="stUbicacion" class="dropdown__content-left">
                        <span class="contaniner-categorias" @click="selectUbicacion('CABA')">Ciudad de Buenos Aires</span>
                        <span class="contaniner-categorias" @click="selectUbicacion('Buenos Aires')">Gran Buenos Aires</span>
                    </div>
                </div>
            </div>
            <div class="content-dropbtn-select">
                <div class="dropdown">
                    <button class="dropbtn-right" @click="showSelectCategoria()">
                        <div class="wt-center-center">
                            <span class="slash-search"></span>
                            <span class="wt-mayuscula">{{(categoria == '') ? 'QUÉ ESTÁS PLANIFICANDO?' : categoria.name}}</span>
                        </div>
                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    </button>
                    <div v-if="stCategoria" class="dropdown__content">
                        <div v-for="cat in categories" class="contaniner-categorias" @click="selectCategoria(cat)">
                            <div>
                                <img :src="cat.icon" :alt="cat.name" class="img-responsive">
                            </div>
                            <div class="wt-center-column wt-m-lf-2">
                                <span class="wt-mayuscula">{{cat.name}}</span>
                                <span class="subCategoria">{{showSubCategories(cat.sub_category)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-dropbtn-btn"><button class="search-home-btn" @click="searchEspacios()">BUSCAR</button></div>
    	</div>
        <div class="wt-center-column" id="search-mobile">
            <div class="dropdown wt-m-bot-1">
                <button class="dropbtn" @click="showSelectUbicacion()">
                    <span>{{ubicacion}}</span>
                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                </button>
                <div v-if="stUbicacion" class="dropdown__content">
                    <span class="contaniner-categorias" @click="selectUbicacion('CABA')">CABA</span>
                    <span class="contaniner-categorias" @click="selectUbicacion('Buenos Aires')">Buenos Aires</span>
                </div>
            </div>
            <div class="dropdown wt-m-bot-1">
                <button class="dropbtn" @click="showSelectCategoria()">
                    <span>{{(categoria == '') ? 'QUÉ ESTÁS PLANIFICANDO?' : categoria.name}}</span>
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
              ubicacion: 'UBICACIÓN',
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
        	selectUbicacion(ubi) {
        		this.ubicacion = ubi;
        		this.stUbicacion = false;
        		if(this.categoria == '') {
        		    this.stCategoria = true;
                }
        	},
        	selectCategoria(cat) {
        		this.categoria = cat;
        		this.stCategoria = false;
                if(this.ubicacion == 'Ubicación') {
                    this.stUbicacion = false;
                }
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

                if(this.ubicacion !== 'UBICACIÓN') {
                    url += `?ubicacion=${this.ubicacion}`;
                }else{
                    this.stUbicacion = true;
                    return;
                }
                
                if(this.categoria.id !== undefined) {
                    url += `&categoria=${this.categoria.id}`;
                }else {
                    this.stCategoria = true;
                    return;
                }

        		window.location.href = url += `&quanty=0-1000&price=100-100000`;
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
<style lang="sass" scoped>
    .search-home-btn {
        width: 100%;
        display: inline-block;
        margin-bottom: 0;
        font-weight: normal;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        border: 1px solid transparent;
        white-space: nowrap;
        padding: 1em 2em;
        line-height: 1.6;
        font-size: 12px !important;
        color: white;
        background-color: #FC5289;
        border-radius: 0 !important;
        border-top-right-radius: 2px !important;
        border-bottom-right-radius: 2px !important;
        height: 100%;
        &:hover, &:focus {
            color: white !important;
        }
    }
</style>