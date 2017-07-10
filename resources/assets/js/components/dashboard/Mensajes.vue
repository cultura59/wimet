<style lang="sass">
	.mensajes-main {
		padding: 1em 5em;
	    height: 930px;
	    width: 60%;
	    float: left;
	    &__links{
		    padding: 1em 0 2em 0;
		    width: 55%;
		    display: flex;
		    justify-content: space-between;
		    &--default {
			    opacity: 0.87;
			    font-family: Poppins;
			    font-size: 16px;
			    font-weight: 500;
			    letter-spacing: -0.1px;
			    text-align: justify;
			    color: #191919;
			    &:hover, &:focus {
			    	color: #191919;
		    	    text-decoration: none;
			    }
			}
			&--active {
			    opacity: 0.87;
			    font-family: Poppins;
			    font-size: 16px;
			    font-weight: 500;
			    letter-spacing: -0.1px;
			    text-align: justify;
			    color: #e2385a;
			    &:hover, &:focus {
		    	    text-decoration: none;
			    	color: #e2385a;
			    }
			}
		}
	    .mensajes {
			width: 100%;
			height: 600px;
			.mensaje {
				max-height: 100px;
				background-color: #f8f8f8;
				border-top: 1px solid #fff;
				border-bottom: 1px solid #fff;
				padding: 10px;
				cursor: pointer;
				&__left {
					width: 10%;
					float: left;
				}
				&__right {
					width: 90%;
					padding-left: 1em;
					display: flex;
				    flex-direction: column;
				}
			}
			.mensaje--active {
				max-height: 100px;
				background-color: #f0f0f0;
				border-top: 1px solid #fff;
				border-bottom: 1px solid #fff;
				padding: 10px;
				cursor: pointer;
				&__left {
					width: 10%;
					float: left;
				}
				&__right {
					width: 90%;
					padding-left: 1em;
					display: flex;
				    flex-direction: column;
				}
			}
	    }
	}
    .btn-mensajes-chat {
    	border: none;
	    padding: 1em;
	    color: #fff;
	    background-color: #e2385a;
	    border-radius: 2px;
	    &:hover {
	    	opacity: 87;
	    }
    }
</style>
<template>
	<div>
		<div class="mensajes-main">
			<div class="mensajes-main__links">
				<a href="#" 
					:class="(showMensajesType == 2) ? 'mensajes-main__links--active' : 'mensajes-main__links--default'" 
					@click="changeType($event, 2)">Como anfitrión
				</a>
				<a href="#" 
					:class="(showMensajesType == 1) ? 'mensajes-main__links--active' : 'mensajes-main__links--default'" 
					@click="changeType($event, 1)">Como organizador
				</a>
			</div>
			<div class="mensajes">
				<div 
					v-if="(eventoselect !== '')"
					v-for="(mensaje, key) in mensajes" 
					:class="(eventoselect.id == mensaje.id) ? 'mensaje--active':'mensaje'" 
					@click="getResumen(mensaje)">
					<div class="mensaje__left">
						<img :src="mensaje.imagesource" :alt="mensaje.firstname" class="img-responsive img-circle">
					</div>
					<div class="mensaje__right">
						<div class="wt-space-block">
							<span>{{mensaje.firstname}}</span>
							<span>{{mensaje.created_at}}</span>
						</div>
						<p>{{recortarTexto(mensaje.descripcion_consulta)}}...</p>
					</div>
				</div>
			</div>
		</div>
		<div class="aside-propuesta" v-if="(eventoselect !== '')">
			<div>
				<img :src="`/${espacio.images[0].name}`" :alt="espacio.name" class="img-responsive">
			</div>
			<div class="propuesta-datos">
				<h3>{{espacio.name}}</h3>
				<span>Desde {{evento.reserva_desde}} hasta {{evento.reserva_hasta}}</span>
				<div>
					<div class="wt-space-block">
						<label>Espacio (por {{evento.total_horas}}hs)</label>
						<span>${{evento.sub_total}}.-</span>
					</div>
					<div class="propuesta-datos__total">
						<label>Total</label>
						<h3>${{evento.sub_total}}.-</h3>
					</div>
					<button class="btn-mensajes-chat" @click="redirectMensajes(evento.id)">Mensajes</button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				user: {},
				mensajes: '',
				evento: '',
				espacio: '',
				eventoselect: '',
				showMensajesType: 2
			}
		},
		mounted() {
            this.getUserAuthenticated();
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
        			this.getMensajes();
				}
			},
			getMensajes() {
				this.$http.get(`api/mensajes/${this.user.id}/type/${this.showMensajesType}`)
				.then(res => {
					this.mensajes = res.body;
					this.eventoselect = this.mensajes[0];
					this.getResumen(this.eventoselect);
				});
			},
			recortarTexto(texto) {
				return texto.substring(0, 140);
			},
			getResumen(evento) {
				this.eventoselect = evento;
				this.$http.get(`api/evento/resumen/${evento.id}`)
				.then(res => {
					this.evento = res.body.evento;
					this.espacio = res.body.espacio;
				});
			},
			redirectMensajes(eventoId){
				window.location.href = `/dashboard/user/${this.user.id}/evento/${eventoId}/chats`;
			},
			changeType(e, type) {
				e.preventDefault();
				this.showMensajesType = type;
				this.getMensajes();
			}
		}
	}
</script>