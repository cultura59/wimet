<template>
	<div>
		<div class="container-center">
			<h3>¿Cual es el precio de tu espacio?</h3>
			<div class="content-categories">
				<button 
					v-for="cat in categories" 
					:class="(cat == categorySelected) ? 'btn-price-active': 'btn-price-defualt'"
					@click="selectCategory(cat)">
					{{cat.name}}
				</button>
			</div>
			<div>
				<div class="content-bpx-price">
					<div class="content-bpx-price__left">
						<input 
							type="text" 
							placeholder="$ 100.-" 
							class="content-bpx-price__left__input"
							v-model="categorySelected.price">
						<button class="content-bpx-price__left__btn1" @click="incrementPrice()">+</button>
						<button class="content-bpx-price__left__btn2" @click="decrementPrice()">-</button>
					</div>
					<label for="por-hora">Por hora</label>
				</div> 
				<div>
					<div class="content-bpx-price">
						<div class="content-bpx-price__left">
							<input 
								type="text" 
								placeholder="3 hs.-" 
								class="content-bpx-price__left__input"
								v-model="categorySelected.minhours">
							<button class="content-bpx-price__left__btn1" @click="incrementHour()">+</button>
							<button class="content-bpx-price__left__btn2" @click="decrementHour()">-</button>
						</div>
						<label for="por-hora">Mínimo de horas</label>
					</div>
					<span>(puedes establecer una cantidad mínima de horas a contratar).</span>
				</div>
				<div class="check-all">
					<input type="checkbox" id="all-categories" v-model="allCategories" @change="changeAllCategories()">
					<label class="all-categories" for="all-categories">Establecer precios para todas las categorias.</label>
				</div>
			</div>
		</div>
		<div class="buttons" id="second-buttons">
			<a href="#" @click="backPage($event)" class="btn-volver">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
				<span>ATRÁS</span>
			</a>
			<a class="btn wt-btn-primary" href="#" @click="savePrice($event)">GUARDAR</a>
		</div>
	</div>
</template>

<script>
	export default {
		props: [
			'espacioId',
			'prices'
		],
		data() {
			return {
				categories: [],
				categorySelected: {},
				allCategories: false
			}
		},
		mounted() {
            this.getCategories();
        },
        methods: {
        	getCategories() {
        		this.categories = eval(this.prices);
        		this.categorySelected = this.categories[0];
            },
            selectCategory(cat) {
            	this.categorySelected = cat;
            },
            incrementPrice() {
            	this.categorySelected.price = this.categorySelected.price + 1;
            },
            decrementPrice() {
            	this.categorySelected.price = this.categorySelected.price - 1;
            },
            incrementHour() {
            	this.categorySelected.minhours = this.categorySelected.minhours + 1;
            },
            decrementHour() {
            	this.categorySelected.minhours = this.categorySelected.minhours - 1;
            },
            changeAllCategories() {
            	if(this.allCategories == true) {
	            	for(let i = 0; i < this.categories.length; i++) {
	            		if(this.categories[i].id != this.categorySelected.id) {
		            		this.categories[i].price = this.categorySelected.price;
		            		this.categories[i].minhours = this.categorySelected.minhours;
		            	}
	            	}
	            }
            },
            savePrice(e){
            	e.preventDefault();
            	let data = {categories: this.categories};
            	this.$http.post('saveprice', data)
            	.then((res) =>{
            		if(res.status == 200) {
            			window.location.href = `/publicar/tercer-paso/espacio/${this.espacioId}/disponibilidad`;
            		}
            	});
            },
            backPage(e) {
            	e.preventDefault();
            	window.location.href = `/publicar/tercer-paso/espacio/${this.espacioId}/reglas`;
            }
        }
	}
</script>

<style lang="sass">
	.content-categories {
	    display: flex;
	    justify-content: flex-start;
	    margin: 2em 0;
	}
	.btn-price-defualt {
	    background: transparent;
	    border: none;
	    padding: 0.5em 2em;
	    &:hover {
	    	color: #e8536f;
	    	transition: none;
	    }
	    &:focus {outline:0;}
	}
	.btn-price-active {
	    background: #e8536f;
	    border: 1px solid #e8536f;
	    padding: 0.5em 2em;
	    color: #fff;
	    border-radius: 2px;
	    &:hover {
	    	background: rgba(232, 83, 111, 0.8);
	    }
	    &:focus {outline:0;}
	}
	.content-bpx-price {
	    display: flex;
	    align-items: baseline;
	    width: 50%;
	    height: 3em;
	    margin: 2em 0;
	    &__left {
		    display: flex;
		    height: 100%;
			&__input {
			    padding: 1em;
			    width: 40%;
			    height: 100%;
			    border-left: 1px solid #dadada;
			    border-top: 1px solid #dadada;
			    border-bottom: 1px solid #dadada;
			    border-right: none;
			}
			&__btn1 {
			    width: 20%;
			    background: #fff;
			    border-left: 1px solid #dadada;
			    border-top: 1px solid #dadada;
			    border-bottom: 1px solid #dadada;
			    border-right: none;
			}
			&__btn2 {
			    width: 20%;
			    background: #fff;
			    border: 1px solid #dadada;
			}
		}
		label {
			font-weight: bold;
		}
	}
	.check-all {
		margin: 1em 0;
		input[type="checkbox"] {
			display: none;
		}
		.all-categories {
			padding-left: 2.3em;
		    position: relative;
		    cursor: pointer;
		    &:before {
			    content: ' ';
			    width: 1.5em;
			    height: 1.5em;
			    border: 1px solid #dadada;
			    background: #ffF;
			    border-radius: 4px;
			    transition: all .2s;
			    transform: rotate(0);
			    position: absolute;
			    left: 0;
			    top: 0;
			}
		}
	}
</style>