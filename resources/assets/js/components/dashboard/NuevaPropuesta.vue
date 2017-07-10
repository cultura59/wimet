<template>
	<div class="container-propuesta">
		<ul v-if="evento.id" class="box-opciones">
			<li><a :href="`/dashboard/user/${user.id}/evento/${evento.id}`">Detalles evento</a></li>
			<li><a :href="`/dashboard/user/${user.id}/evento/${evento.id}/chats`">Mensajes evento</a></li>
		</ul>
		<div>
			<div class="container-propuesta__titles">
				<h4 class="cursor-pointer" @click="chageShowSetalles()">1. Detalles del evento</h4>
				<i class="fa fa-check" aria-hidden="true"></i>
			</div>
			<div v-if="showdetalles">
				<div class="wt-space-block wt-m-top-2 wt-m-bot-1">
					<div class="wt-center-column">
						<label for="actividad">Tipo de actividad</label>
						<select id="actividad" class="container-propuesta__inputs" v-model="evento.estilo_espacios_id">
							<option value="1">Reunión</option>
						</select>
					</div>
					<div class="wt-center-column">
						<label for="invitados">Invitados</label>
						<input type="text" id="invitados" class="container-propuesta__inputs" placeholder="Nombre del evento" v-model="evento.invitados">
					</div>
				</div>
				<div class="wt-space-block wt-m-bot-2">
					<div class="wt-center-column">
						<label for="comienza">Comienza</label>
						<input type="date" id="comienza" class="container-propuesta__inputs" v-model="evento.reserva_desde">
					</div>
					<div class="wt-center-column">
						<label for="finaliza">Finaliza</label>
						<input type="date" id="finaliza" class="container-propuesta__inputs" v-model="evento.reserva_hasta">
					</div>
				</div>
				<button class="btn-propuesta">GUARDAR</button>
			</div>
		</div>
		<div class="wt-m-top-4">
			<h4>2. Detalles del presupuesto</h4>
			<div class="content-box-price">
				<label for="por-hora">Alquiler del espacio</label>
				<div class="content-box-price__left">
					<input 
						type="text" 
						placeholder="$ 100.-" 
						class="content-box-price__left__input"
						v-model="evento.sub_total">
					<button class="content-box-price__left__btn1" @click="decrementPrice()">-</button>
					<button class="content-box-price__left__btn2" @click="incrementPrice()">+</button>
				</div>
				<div class="propuesta-m-left-0">
					<input type="checkbox" id="iva" v-model="iva" style="display: none;">
					<label for="iva" class="wt-publica-label">IVA</label>
				</div>
			</div>
			<!-- BEGIN Control si existe iva o no -->
			<div v-if="iva">
				<div class="wt-m-bot-2">
					<label for="iva">IVA</label>
					<span class="propuesta-m-left-2">$ {{(setIva) ? setIva : '-'}}</span>
				</div>
				<div class="wt-m-bot-2">
					<label for="subTotal">Sub Total</label>
					<span class="propuesta-m-left-1">$ {{(setSubTotal) ? setSubTotal : '-'}}</span>
				</div>
			</div>
			<!-- END Control si existe iva o no -->
			<div class="wt-m-bot-2">
				<label for="invitados">Comisión (15%)</label>
				<span class="propuesta-m-left-0">$ {{(setComision) ? setComision : '-'}}</span>
			</div>
			<div class="wt-m-bot-2">
				<label for="invitados">Tu pago</label>
				<span class="propuesta-m-left-1">$ {{(setTupago) ? setTupago : '-'}}</span>
			</div>
			<div class="container-propuesta__detalles wt-m-top-2">
				<label for="condiciones">Condiciones generales</label>
				<textarea id="condiciones" v-model="evento.condiciones"></textarea>
			</div>
			<div class="wt-m-top-2">
				<label for="vencimiento">Vencimiento propuesta</label>
				<input type="date" id="vencimiento" class="container-propuesta__inputs propuesta-m-left-0" v-model="evento.vencimiento_propuesta">
			</div>
			<div class="content-box-deposito">
				<label for="por-hora">Depósito de seguridad</label>
				<div class="content-box-deposito__left">
					<input 
						type="text" 
						placeholder="$ 100.-" 
						class="content-box-deposito__left__input"
						v-model="evento.deposito">
					<button class="content-box-deposito__left__btn1" @click="decrementDeposito()">-</button>
					<button class="content-box-deposito__left__btn2" @click="incrementDeposito()">+</button>
				</div>
			</div>
			<div>
				<label for="cancellationflexibility">Política de cancelación</label>
				<span>{{evento.cancellationflexibility}}</span>
			</div>
			<button @click="sendPropuesta()" class="btn-send-presupuesto">ENVIAR PRESUPUESTO</button>
		</div>
	</div>
</template>
<script>
	export default {
		props: [
			'eventoId',
			'securitydeposit',
			'cancellationflexibility'
		],
		data() {
			return {
				user: {},
				evento: {},
				iva: true,
				showdetalles: false
			}
		},
		mounted() {
            this.getUserAuthenticated();
            this.getEvento();
        },
        computed: {
        	setIva() {
        		this.evento.iva = (parseInt(this.evento.sub_total) * 21) / 100;
        		if(this.iva) {
            		this.evento.montoConIva = this.evento.iva + this.evento.sub_total;
            		this.evento.fee = (this.evento.montoConIva * 21) / 100;
            		this.evento.total = this.evento.montoConIva + this.evento.fee;
            	}else {
            		this.evento.montoConIva = this.evento.sub_total;
            		this.evento.fee = (this.evento.sub_total * 21) / 100;
            		this.evento.total = this.evento.montoConIva + this.evento.fee;
            	}
            	return this.evento.iva;
        	},
        	setSubTotal() {
        		return parseInt(this.evento.sub_total + this.evento.iva);
        	},
        	setComision() {
        		let res;
        		if(this.iva){
        			this.evento.comision = ((parseInt(this.evento.sub_total) + this.evento.iva) * 15) / 100;
	            	res = this.evento.comision;
        		}else {
	            	this.evento.comision = (parseInt(this.evento.sub_total) * 15) / 100;
	            	res = this.evento.comision;
	            }
	            return parseFloat(Math.round(res * 100) / 100).toFixed(2);
            },
            setTupago() {
            	if(this.iva){
        			this.evento.tu_pago = (parseInt(this.evento.sub_total) + this.evento.iva) - this.evento.comision;
	            	return this.evento.tu_pago;
        		}else {
	            	this.evento.tu_pago = parseInt(this.evento.sub_total) - this.evento.comision;
	            	return this.evento.tu_pago;
	            }
            }
        },
		methods: {
			getUserAuthenticated() {
				if(!this.$auth.isAuthenticated()) {
	                swal({
	                  title: 'No estas loguedo',
	                  text: "Debes iniciar sesión para hacer una pregunta o reserva.",
	                  imageUrl: "/avatars/default.png"
	                });
	                return;
	            }else {
					this.user = this.$auth.getUser();
				}
			},
			getEvento() {
				this.$http.get(`api/evento/${this.eventoId}`)
				.then(res => {
					this.evento = res.body;
					this.evento.comision = (this.evento.sub_total * 15) / 100;
            		this.evento.tu_pago = this.evento.sub_total - this.evento.comision;
            		this.evento.deposito = this.securitydeposit;
            		this.evento.cancellationflexibility = this.cancellationflexibility;
				});
			},
            incrementPrice() {
            	this.evento.sub_total++;
            },
            decrementPrice() {
            	this.evento.sub_total--;
            },
            incrementDeposito() {
            	this.evento.deposito++;
            },
            decrementDeposito() {
            	this.evento.deposito--;
            },
            chageShowSetalles() {
            	this.showdetalles = !this.showdetalles;
            },
            sendPropuesta() {
            	if(this.evento.vencimiento_propuesta == undefined) {
            		swal("Campo requerido!", "Debe ingresar fecha de vencimiento de la propuesta", "error");
            		return;
            	}
            	
            	let data = this.calcularIvaYFee();

            	this.$http.post(`api/propuesta`, data)
            	.then(res => {
            		if(res.status == 204) {
            			swal("Propuesta enviada!", "Ya falta poco, felicitaciones!", "success");
            			setInterval(()=>{
            				window.location.href = `/dashboard/user/${this.user.id}/evento/${this.evento.id}`;
            			}, 3000);
            		}else {
            			swal("Propuesta no enviada!", "Revisa los datos envíados", "error");
            		}
            	});
            },
            calcularIvaYFee() {
            	if(this.iva) {
            		this.evento.montoConIva = this.evento.iva + this.evento.sub_total;
            		this.evento.fee = (this.evento.montoConIva * 21) / 100;
            		this.evento.total = this.evento.montoConIva + this.evento.fee;
            	}else {
            		this.evento.montoConIva = this.evento.sub_total;
            		this.evento.fee = (this.evento.sub_total * 21) / 100;
            		this.evento.total = this.evento.montoConIva + this.evento.fee;
            	}
            	let data = {
            		evento_id: this.evento.id,
            		estilo_espacios_id: this.evento.estilo_espacios_id,
            		invitados: this.evento.invitados,
            		reserva_desde: this.evento.reserva_desde,
            		reserva_hasta: this.evento.reserva_hasta,
            		user_id: this.evento.user_id,
            		cliente_id: this.evento.cliente_id,
            		espacio_id: this.evento.espacio_id,
            		sub_total: this.evento.sub_total,
            		tu_pago: this.evento.tu_pago,
            		comision: this.evento.comision,
            		condiciones: this.evento.condiciones,
            		iva: this.iva,
            		monto_iva: this.evento.iva,
            		monto_con_iva: this.evento.montoConIva,
            		fee: this.evento.fee,
            		total: this.evento.total,
            		vencimiento_propuesta: this.evento.vencimiento_propuesta,
            		deposito: (this.evento.deposito > 0) ? this.evento.deposito : 0,
            		cancellationflexibility: this.evento.cancellationflexibility
    			}
    			return data;
            }
		}
	}
</script>
<style lang="sass">
	*{outline:0;}
	.container-propuesta {
		.btn-propuesta {
			width: 128px;
			height: 40px;
			border-radius: 2px;
			background-color: #ea516d;
			font-family: Poppins;
			font-size: 14px;
			font-weight: 500;
			letter-spacing: -0.1px;
			color: #ffffff;
			border: none;
			&:hover {
				background-color: rgba(234, 81, 109, 0.87);
			}
		}
		&__titles {
		    display: flex;
		    justify-content: space-between;
		    align-items: baseline;
		}
		&__inputs {
			width: 240px;
		    height: 40px;
		    background-color: #ffffff;
		    border: solid 1px #979797;
		    padding: .5em;
		}
		&__detalles {
			display: flex;
			flex-direction: column;
			textarea {
				width: 510px;
				height: 80px;
				background-color: #ffffff;
				border: solid 1px #979797;
			}
		}
	}
	.content-box-price {
	    display: flex;
	    align-items: baseline;
	    margin: 2em 0;
	    &__left {
		    display: flex;
		    height: 100%;
	        margin-left: 4em;
			&__input {
			    padding: .5em;
			    width: 226px;
    			height: 40px;
			    border-left: 1px solid #979797;
			    border-top: 1px solid #979797;
			    border-bottom: 1px solid #979797;
			    border-right: none;
			}
			&__btn1 {
			    width: 20%;
			    background: #fff;
			    border-left: 1px solid #979797;
			    border-top: 1px solid #979797;
			    border-bottom: 1px solid #979797;
			    border-right: none;
			}
			&__btn2 {
			    width: 20%;
			    background: #fff;
			    border: 1px solid #979797;
			}
		}
		label {
			font-weight: bold;
		}
	}
	.content-box-deposito {
	    display: flex;
	    align-items: baseline;
	    margin: 2em 0;
	    &__left {
		    display: flex;
		    height: 100%;
	        margin-left: 2.5em;
			&__input {
			    padding: .5em;
			    width: 226px;
    			height: 40px;
			    border-left: 1px solid #979797;
			    border-top: 1px solid #979797;
			    border-bottom: 1px solid #979797;
			    border-right: none;
			}
			&__btn1 {
			    width: 20%;
			    background: #fff;
			    border-left: 1px solid #979797;
			    border-top: 1px solid #979797;
			    border-bottom: 1px solid #979797;
			    border-right: none;
			}
			&__btn2 {
			    width: 20%;
			    background: #fff;
			    border: 1px solid #979797;
			}
		}
		label {
			font-weight: bold;
		}
	}
	.propuesta-m-left-0 {
		margin-left: 2em;
	}
	.propuesta-m-left-1 {
		margin-left: 5.5em;
	}
	.propuesta-m-left-2 {
		margin-left: 9em;
	}
	.btn-send-presupuesto {
	    width: 208px;
	    height: 40px;
	    border-radius: 2px;
	    background-color: #ea516d;
	    border: none;
	    font-family: Poppins;
	    font-size: 14px;
	    font-weight: 500;
	    letter-spacing: -0.1px;
	    color: #ffffff;
	    margin-top: 2em;
	    &:hover {
	    	background-color: rgba(234, 81, 109, 0.87);
	    }
	}
	.box-opciones {
		list-style-type: none;
    	margin: 2em 0;
    	li {
    		display: inline;
    		margin-right: 1em;
    		a {
    			padding: 15px;
			    border: 1px solid #e8536f;
			    border-radius: 2px;
			    color: #e8536f;
			    background-color: #fff;
			    &:hover {
			    	background-color: #e8536f;
			    	color: #fff;
			    	text-decoration:none;
			    }
    		}
    	}
	}
</style>