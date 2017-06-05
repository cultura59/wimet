<template>
	<div>
		<ul v-if="evento.id">
			<li><a :href="`/dashboard/user/${user.id}/evento/${evento.id}`">Detalles evento</a></li>
			<li><a :href="`/dashboard/user/${user.id}/evento/${evento.id}/mensajes`">Mensajes evento</a></li>
		</ul>
		<div>
			<h4>1. Detalles del evento</h4>
			<div>
				<label for="actividad">Tipo de actividad</label>
				<select id="actividad" v-model="evento.estilo_espacios_id">
					<option value="1">Reunión</option>
				</select>
			</div>
			<div>
				<label for="invitados">Invitados</label>
				<input type="text" id="invitados" placeholder="Nombre del evento" v-model="evento.invitados">
			</div>
			<div>
				<label for="comienza">Comienza</label>
				<input type="date" id="comienza" v-model="evento.reserva_desde">
			</div>
			<div>
				<label for="finaliza">Finaliza</label>
				<input type="date" id="finaliza" v-model="evento.reserva_hasta">
			</div>
			<button>CONTINUAR</button>
		</div>
		<div>
			<h4>2. Detalles del presupuesto</h4>
			<div class="content-box-price">
				<div class="content-box-price__left">
					<input 
						type="text" 
						placeholder="$ 100.-" 
						class="content-box-price__left__input"
						v-model="evento.sub_total">
					<button class="content-box-price__left__btn1" @click="incrementPrice()">+</button>
					<button class="content-box-price__left__btn2" @click="decrementPrice()">-</button>
				</div>
				<label for="por-hora">Alquiler del espacio</label>
			</div>
			<div>
				<label for="invitados">Comisión (15%)</label>
				<span>$ {{(setComision) ? setComision : '-'}}</span>
			</div>
			<div>
				<label for="invitados">Tu pago</label>
				<span>$ {{(setTupago) ? setTupago : '-'}}</span>
			</div>
			<div>
				<label for="condiciones">Condiciones generales</label>
				<textarea id="condiciones" cols="30" rows="10" v-model="evento.cancellationflexibility"></textarea>
			</div>
			<div>
				<label for="vencimiento">Vencimiento propuesta</label>
				<input type="date" id="vencimiento" v-model="evento.vencimiento_propuesta">
			</div>
			<div class="content-box-price">
				<div class="content-box-price__left">
					<input 
						type="text" 
						placeholder="$ 100.-" 
						class="content-box-price__left__input"
						v-model="evento.deposito">
					<button class="content-box-price__left__btn1" @click="incrementPrice()">+</button>
					<button class="content-box-price__left__btn2" @click="decrementPrice()">-</button>
				</div>
				<label for="por-hora">Depósito de seguridad</label>
			</div>
			<div>
				<label for="cancellationflexibility">Política de cancelación</label>
				<span>{{evento.cancellationflexibility}}</span>
			</div>
			<button @click="sendPropuesta()">ENVIAR PRESUPUESTO</button>
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
				evento: {}
			}
		},
		mounted() {
            this.getUserAuthenticated();
            this.getEvento();
        },
        computed: {
        	setComision() {
            	this.evento.comision = (this.evento.sub_total * 15) / 100;
            	return this.evento.comision;
            },
            setTupago() {
            	this.evento.tu_pago = this.evento.sub_total - this.evento.comision;
            	return this.evento.tu_pago;
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
					this.$http.get('api/usersession')
					.then(res => {
						this.user = res.body;
					});
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
            sendPropuesta() {
            	if(this.evento.vencimiento_propuesta == undefined) {
            		swal("Campo requerido!", "Debe ingresar fecha de vencimiento de la propuesta", "error");
            		return;
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
            		vencimiento_propuesta: this.evento.vencimiento_propuesta,
            		deposito: (this.evento.deposito > 0) ? this.evento.deposito : 0,
            		cancellationflexibility: this.evento.cancellationflexibility
            	}
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
            }
		}
	}
</script>
<style lang="sass">
	*{outline:0;}
	.content-box-price {
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
</style>