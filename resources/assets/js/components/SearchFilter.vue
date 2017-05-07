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
		<div class="dropdown">
            <button class="dropbtn" @click="showSelectQuanty()">
                <span>{{quanty}}</span>
                <i class="fa fa-sort-desc" aria-hidden="true"></i>
            </button>
            <div v-if="stQuanty" class="dropdown__content">
                <span @click="selectQuanty('5')">5+</span>
                <span @click="selectQuanty('10')">10+</span>
                <span @click="selectQuanty('15')">15+</span>
                <span @click="selectQuanty('25')">25+</span>
                <span @click="selectQuanty('50')">50+</span>
                <span @click="selectQuanty('100')">100+</span>
                <span @click="selectQuanty('200')">200+</span>
            </div>
        </div>
		<div class="dropdown">
            <button class="dropbtn" @click="showSelectPrice()">
                <span>{{price}}</span>
                <i class="fa fa-sort-desc" aria-hidden="true"></i>
            </button>
            <div v-if="stPrice" class="dropdown__content">
                <span @click="selectPrice('0-500')">$0 - $500</span>
                <span @click="selectPrice('500-1000')">$500 - $1000</span>
                <span @click="selectPrice('1000-1500')">$1000 - $1500</span>
                <span @click="selectPrice('1500-2500')">$1500 - $2500</span>
                <span @click="selectPrice('2500-3500')">$2500 - $3500</span>
                <span @click="selectPrice('3500')">$3500</span>
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
              quanty: 'Invitados',
              price: 'Precio / hr',
              stUbicacion: false,
              stCategoria: false,
              stQuanty: false,
              stPrice: false,
              categorias: [
              	{velue: 1, label: 'Reuniones'},
              	{velue: 2, label: 'Eventos'},
              	{velue: 3, label: 'Producciones'},
              	{velue: 4, label: 'Pop-ups'}
              ]
            }
        },
        methods: {
        	// Selectores
        	selectUbucacion(ubi) {
        		this.ubicacion = ubi;
        		this.stUbicacion = false;
        	},
        	selectCategoria(cat) {
        		this.categoria = cat;
        		this.stCategoria = false;
        	},
        	selectQuanty(quanty) {
        		this.quanty = quanty;
        		this.stQuanty = false;
        	},
        	selectPrice(price) {
        		this.price = price;
        		this.stPrice = false;
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
            showSelectQuanty() {
            	this.stQuanty = !this.stQuanty;
            	if(this.stQuanty) {
            		this.stQuanty = false;
            	}
            },
            showSelectPrice() {
            	this.stPrice = !this.stPrice;
            	if(this.stPrice) {
            		this.stPrice = false;
            	}
            },
        	searchEspacios () {
        		let url = `/search?
        					ubicacion=${this.ubicacion}&
        					categoria=${this.categoria.velue}&
        					quanty=${this.quanty.velue}&
        					price=${this.price.velue}`;
        		window.location.href = url;
            }
        }
	}
</script>