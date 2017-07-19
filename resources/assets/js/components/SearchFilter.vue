<template>
    <div>
    	<div class="container-filters">
    		<div class="container-filters__dropdown">
                <button class="container-filters__dropdown__button-left" @click="showSelectUbicacion()">
                    <span>{{ubicacion}}</span>
                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                </button>
                <template v-if="stUbicacion">
                    <div class="container-filters__dropdown__content">
                        <div class="chield-filter" @click="selectUbucacion('CABA')"><span>CABA</span></div>
                        <div class="chield-filter" @click="selectUbucacion('Buenos Aires')"><span>Buenos Aires</span></div>
                    </div>
                </template>
            </div>
            <div class="container-filters__dropdown">
                <button class="container-filters__dropdown__button-right" @click="showSelectCategoria()">
                    <span>{{(categoria == '') ? 'Qué estás planificando?' : categoria.label}}</span>
                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                </button>
                <template v-if="stCategoria">
                    <div class="container-filters__dropdown__content">
                    	<div class="chield-filter" v-for="cat in 
                        " @click="selectCategoria(cat)">
                            <span>{{cat.name}}</span>
                        </div>
                    </div>
                </template>
            </div>
    	</div>
        <div class="row wt-m-top-1">
            <div class="col-xs-12 col-md-6">
                <vue-slider 
                    @callback="callbackbQuanty" 
                    :value="[quantyFrom, quantyTo]"
                    :min="0"
                    :max="1000"
                    :tooltip="false"
                    :event-type="auto"
                    :process-style="processStyle"
                    :real-time="true">
                </vue-slider>
                <p class="text-center">{{quantyFrom}} a {{quantyTo}} personas.</p>
            </div>
            <div class="col-xs-12 col-md-6">
                <vue-slider 
                    @callback="callbackbPrice" 
                    :value="[priceFrom, priceTo]"
                    :min="0"
                    :max="10000"
                    :tooltip="false"
                    :event-type="auto"
                    :process-style="processStyle"
                    :real-time="true">
                </vue-slider>
                <p class="text-center">${{priceFrom}} - ${{priceTo}}.-</p>
            </div>
        </div>
    </div>
</template>
<script>
    import vueSlider from 'vue-slider-component';
	export default {
        components: {
            vueSlider
        },
		data() {
            return {
                ubicacion: 'Ubicación',
                categoria: {},
                quantyFrom: 0,
                quantyTo: 10,
                priceFrom: 100,
                priceTo: 1000,
                processStyle: {
                    "backgroundColor": "#e8536f"
                },
                stUbicacion: false,
                stCategoria: false,
                categorias: ''
            }
        },
        mounted() {
            this.getParametros();
        },
        methods: {
            getCategories() {
                this.$http.get(`/api/categoria`)
                .then(res => {
                    this.categorias = res.body;
                }, err => {
                    console.log(err);
                });
            },
            getParametros() {
                let urlParams = new URLSearchParams(window.location.search);
                let catId = urlParams.get('categoria');
                let quanties = urlParams.get('quanty').split("-");
                let prices = urlParams.get('price').split("-");

                this.ubicacion = (urlParams.has('ubicacion') && urlParams.get('ubicacion') !== '') ? urlParams.get('ubicacion') : 'Ubicación';
                this.categorias.forEach((element, index) => {
                    if(element.id == catId) {
                        this.categoria = element;
                    }
                });
                this.quantyFrom = quanties[0];
                this.quantyTo = quanties[1];
                this.priceFrom = prices[0];
                this.priceTo = prices[1];
            },
            callbackbPrice(val) {
                this.priceFrom = val[0];
                this.priceTo = val[1];
                this.searchEspacios();
            },
            callbackbQuanty(val) {
                this.quantyFrom = val[0];
                this.quantyTo = val[1];
                this.searchEspacios();
            },
        	selectUbucacion(ubi) {
        		this.ubicacion = ubi;
        		this.showSelectUbicacion();
                this.searchEspacios();
        	},
        	selectCategoria(cat) {
        		this.categoria = cat;
        		this.showSelectCategoria();
                this.searchEspacios();
        	},
        	// Show field
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

        		let url = `/search?ubicacion=${(this.ubicacion == 'Ubicación')? '' : this.ubicacion}&categoria=${this.categoria.velue}&`;
                url += `quanty=${this.quantyFrom}-${this.quantyTo}&price=${this.priceFrom}-${this.priceTo}`;
        		window.location.href = url;
            },
            getUrlVars()
            {
                var vars = [], hash;
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for(var i = 0; i < hashes.length; i++)
                {
                    hash = hashes[i].split('=');
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                return vars;
            }
        }
	}
</script>
<style lang="sass">
    .container-filters {
        width: 100%;
        height: 50px;
        display: flex;
        justify-content: center;
        * {
            transition: none;
        }
        &__dropdown {
            position: relative;
            width: 50%;
            &__button-left {
                width: 100%;
                display: flex;
                color: #262629;
                padding: 0.5em 1em;
                background: #f2f2f2;
                border-left: 1px solid #d6d6d6;
                border-top: 1px solid #d6d6d6;
                border-right: none;
                border-bottom: 1px solid #d6d6d6;
                justify-content: space-between;
            }
            &__button-right {
                width: 100%;
                background: #f2f2f2;
                color: #262629;
                border: 1px solid #d6d6d6;
                padding: 0.5em 1em;
                display: flex;
                justify-content: space-between;

            }
            &__content {
                width: 100%;
                color: #000;
                background: #fff;
                border-left: 1px solid #d6d6d6;
                border-bottom: 1px solid #d6d6d6;
                border-right: 1px solid #d6d6d6;
                position: absolute;
                z-index: 100;
                .chield-filter {
                    padding: 0.5em 1em;
                    &:hover {
                        background: #dadada;
                        cursor: pointer;
                    }
                }
            }
        }
    }
</style>