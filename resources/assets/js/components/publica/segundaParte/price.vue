<template>
	<div>
		<div class="container-center">
			<div class="alert alert-danger" v-show="errorMsg">
				<strong>Ups!</strong> Debes ingresar mínimo de horas y algun precio.
			</div>
			<h3>¿Cuál es el precio de tu espacio?</h3>
			<div class="content-categories">
				<button 
					v-for="cat in categories" 
					:class="(cat == categorySelected) ? 'btn-price-active': 'btn-price-defualt'"
					@click="selectCategory(cat)">
					{{cat.name}}
				</button>
			</div>
			<div>
				<div>
					<div class="content-bpx-price">
						<div class="content-bpx-price__left">
							<input
								type="text"
								placeholder="$ 100.-"
								class="content-bpx-price__left__input"
								v-model="categorySelected.daily">
							<button class="content-bpx-price__left__btn1" @click="incrementDaily()">+</button>
							<button class="content-bpx-price__left__btn2" @click="decrementDaily()">-</button>
						</div>
						<label for="por-hora">Por día</label>
					</div>
				</div>
				<div class="check-all">
					<input type="checkbox" id="all-categories" v-model="allCategories" @change="changeAllCategories()">
					<label class="all-categories" for="all-categories">Establecer precios para todas las categorias.</label>
				</div>
                <div class="check-all">
                    <input type="checkbox" id="all-rangos" v-model="rangoPrecios" @change="changeAllCategories()">
                    <label class="all-categories" for="all-rangos">Rango de precios</label>
                </div>
				<div v-if="rangoPrecios">
					<input type="text" class="select-range" placeholder="Invitados desde">
					<input type="text" class="select-range" placeholder="Invitados hasta">
                    <input type="text" class="select-range" placeholder="Precio">
					<button class="btn-primary-pig">+</button>
				</div>
                <div>

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
				allCategories: false,
                rangoPrecios: false,
                errorMsg: false
			}
		},
		mounted() {
            this.getCategories();
        },
        methods: {
        	getCategories() {
        		this.categories = eval(this.prices);
        		console.log(this.categories);
        		this.categorySelected = this.categories[0];
            },
            selectCategory(cat) {
            	this.categorySelected = cat;
            },
            incrementDaily() {
            	this.categorySelected.daily = this.categorySelected.daily + 1;
            },
            decrementDaily() {
            	this.categorySelected.daily = this.categorySelected.daily - 1;
            },
            changeAllCategories() {
            	if(this.allCategories == true) {
	            	for(let i = 0; i < this.categories.length; i++) {
	            		if(this.categories[i].id != this.categorySelected.id) {
		            		this.categories[i].price = this.categorySelected.price;
		            		this.categories[i].minhours = this.categorySelected.minhours;
                            this.categories[i].daily = this.categorySelected.daily;
		            	}
	            	}
	            }
            },
            savePrice(e){
            	e.preventDefault();
                for(let i = 0; i < this.categories.length; i++) {
                    if(this.categories[i].daily == 0) {
                        if(this.categories[i].price == 0 || this.categories[i].minhours == 0){
							this.errorMsg = true;
                            setInterval(() =>{
                                this.this.allCategories = false;
                                this.errorMsg = false;
							}, 4000);
                            return;
						};
                    }
                }
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
            },
            selectRangos() {
                this.rangoPrecios = !this.rangoPrecios;
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
	    	color: #FC5289;
	    	transition: none;
	    }
	    &:focus {outline:0;}
	}
	.btn-price-active {
	    background: #FC5289;
	    border: 1px solid #FC5289;
	    padding: 0.5em 2em;
	    color: #fff;
	    border-radius: 2px;
		transition: none;
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
			    border-left: 1px solid #666666;
			    border-top: 1px solid #666666;
			    border-bottom: 1px solid #666666;
			    border-right: none;
				color: #666666;
			}
			&__btn1 {
			    width: 20%;
			    background: #fff;
			    border-left: 1px solid #666666;
			    border-top: 1px solid #666666;
			    border-bottom: 1px solid #666666;
			    border-right: none;
				color: #666666;
			}
			&__btn2 {
			    width: 20%;
			    background: #fff;
			    border: 1px solid #666666;
				color: #666666;
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
			    border: 1px solid #666666;
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
    .select-range {
        padding: .4em;
    }
</style>