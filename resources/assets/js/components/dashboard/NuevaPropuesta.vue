<template>
	<div class="container-evento">
		<template v-if="evento.id" class="box-opciones">
			<div class="navbar-chat">
				<a href="#" @click="redirectUrl($event, '')" >RESUMEN</a>
				<a href="#" @click="redirectUrl($event, '/chats')" >MENSAJES</a>
			</div>
		</template>
		<div>
			<div class="container-propuesta__titles">
				<h4 class="dashboard-title" >1. Detalles del evento</h4>
			</div>
			<template v-show="showdetalles">
				<div class="wt-space-block wt-m-top-2 wt-m-bot-1">
					<div class="wt-center-column">
						<label for="actividad" class="container-evento__label">Tipo de actividad</label>
						<select id="actividad" class="container-propuesta__inputs" v-model="evento.estilo_espacios_id">
							<option value="1">Reunión</option>
						</select>
					</div>
					<div class="wt-center-column">
						<label for="invitados" class="container-evento__label">Invitados</label>
						<input type="text" id="invitados" class="container-propuesta__inputs" placeholder="Nombre del evento" v-model="evento.invitados">
					</div>
				</div>
				<div class="wt-space-block wt-m-bot-2">
					<div class="wt-center-column">
						<label for="comienza" class="container-evento__label">Comienza</label>
						<input type="text" id="comienza" class="container-propuesta__inputs" placeholder="Check-In" :value="evento.reserva_desde">
					</div>
					<div class="wt-center-column">
						<label for="finaliza" class="container-evento__label">Finaliza</label>
						<input type="text" id="finaliza" class="container-propuesta__inputs" placeholder="Check-Out" :value="evento.reserva_hasta">
					</div>
				</div>
			</template>
		</div>
		<div class="wt-m-top-4">
			<h4 class="dashboard-title">2. Detalles del presupuesto</h4>
			<div class="content-box-price">
				<label for="por-hora" class="container-evento__label">Alquiler del espacio</label>
				<div class="content-box-price__left">
					<input 
						type="text" 
						placeholder="$ 100.-" 
						class="content-box-price__left__input"
						v-model="subTotal"
						@change="calcIvanAndTotals"
					>
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
					<label for="iva" class="container-evento__label">IVA</label>
					<span class="propuesta-m-left-2">$ {{(evento.iva) ? evento.iva : '-'}}</span>
				</div>
				<div class="wt-m-bot-2">
					<label for="subTotal" class="container-evento__label">Sub Total</label>
					<span class="propuesta-m-left-1">$ {{(evento.montoConIva) ? evento.montoConIva : '-'}}</span>
				</div>
			</div>
			<!-- END Control si existe iva o no -->
			<div class="wt-m-bot-2">
				<label v-if="iva" for="invitados" class="container-evento__label">Comisión (15%)</label>
				<label v-if="!iva" for="invitados" class="container-evento__label">Comisión (15% + IVA)</label>
				<span class="propuesta-m-left-0">$ {{(evento.comision) ? evento.comision : '-'}}</span>
			</div>
			<div class="wt-m-bot-2">
				<label for="invitados" class="container-evento__label">Tu pago</label>
				<span class="propuesta-m-left-1">$ {{(evento.tu_pago) ? evento.tu_pago : '-'}}</span>
			</div>
			<div class="container-propuesta__detalles wt-m-top-2">
				<label for="condiciones" class="container-evento__label">Condiciones generales</label>
				<textarea id="condiciones" v-model="evento.condiciones"></textarea>
			</div>
			<div class="wt-m-top-2">
				<label for="vencimiento" class="container-evento__label">Vencimiento propuesta</label>
				<input type="date" id="vencimiento" class="container-propuesta__inputs propuesta-m-left-0" v-model="evento.vencimiento_propuesta">
			</div>
			<div class="content-box-deposito">
				<label for="por-hora" class="container-evento__label">Depósito de seguridad</label>
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
				<label for="cancellationflexibility" class="container-evento__label">Política de cancelación</label>
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
				showdetalles: false,
				subTotal: 0
			}
		},
		mounted() {
            this.getUserAuthenticated();
            this.getEvento();
        },
        watch: {
        	iva() {
        		this.calcIvanAndTotals();
        	},
        	subTotal() {
        		this.calcIvanAndTotals();
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
					this.subTotal = this.evento.sub_total;
					this.calcIvanAndTotals();
            		this.evento.deposito = this.securitydeposit;
            		this.evento.cancellationflexibility = this.cancellationflexibility;
				});
			},
            incrementPrice() {
            	this.subTotal++;
            },
            decrementPrice() {
            	this.subTotal--;
            },
            incrementDeposito() {
            	this.evento.deposito++;
            },
            decrementDeposito() {
            	this.evento.deposito--;
            },
            chageShowDetalles() {
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
            	this.calcIvanAndTotals();
            	let data = {
            		evento_id: this.evento.id,
            		estilo_espacios_id: this.evento.estilo_espacios_id,
            		invitados: this.evento.invitados,
            		reserva_desde: document.getElementById("comienza").value,
            		reserva_hasta: document.getElementById("finaliza").value,
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
            },
			redirectUrl(e, url) {
				e.preventDefault();
				window.location.href = `/dashboard/user/${this.user.id}/evento/${this.eventoId}${url}`;
			},
			calcIvanAndTotals() {
				this.evento.sub_total = this.subTotal;
				this.evento.iva = (parseFloat(this.evento.sub_total) * 21) / 100;
	    		if(this.iva) {
	        		this.evento.montoConIva = parseFloat(this.evento.iva) + parseFloat(this.evento.sub_total);
					this.evento.comision = this.stringToDouble((this.evento.montoConIva * 15) / 100);
					console.log(this.evento.comision);
	        		this.evento.fee = (this.evento.montoConIva * 5) / 100;
	    			this.evento.tu_pago = this.stringToDouble((parseInt(this.evento.sub_total) + this.evento.iva) - this.evento.comision);
	        		this.evento.total = parseFloat(this.evento.montoConIva + this.evento.fee).toFixed(2);
	        	}else {
	        		this.evento.montoConIva = this.evento.sub_total;
					this.evento.comision = this.stringToDouble(((this.evento.montoConIva + this.evento.iva) * 15) / 100);
	        		this.evento.fee = (this.evento.sub_total * 5) / 100;
	        		this.evento.tu_pago = this.stringToDouble(parseInt(this.evento.sub_total) - this.evento.comision);
	        		this.evento.total = this.evento.montoConIva + this.evento.fee;
	            }
			},
            stringToDouble(num){
			    return Math.round((parseFloat(num) + 0.00001) * 100) / 100;
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
			background-color: #FC5289;
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
	    background-color: #FC5289;
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