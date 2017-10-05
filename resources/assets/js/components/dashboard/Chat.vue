<template>
	<div class="container-evento">
		<template v-if="(user.id && user.id == evento.user_id)">
			<h4 class="text-center dashboard-title">{{evento.titulo_cliente}}</h4>
			<div class="navbar-chat">
				<a href="#"@click="redirectUrl($event, '')" >RESUMEN</a>
				<a href="#"@click="redirectUrl($event, '/chats')" >MENSAJES</a>
			</div>
		</template>
		<template v-if="(user.id && user.id == evento.user_id)">
			<p class="mensajes-alert">La mayoría de los organizadores cuando se contactan con el anfitrión es porque han visto las cualidades del espacio, y lo han elegido. Quítate las dudas del evento y cuando estés listo, envía tu presupuesto formal para confirmar la reserva.</p>
		</template>
		<template v-if="(user.id && user.id != evento.user_id)">
			<p class="mensajes-alert">La mayoría de los anfitriones responden en un plazo de 24 hs. Si has elegido esta publicación y estas de acuerdo con sus políticas y precio, demuestra tu interés en confirmar la reserva, solicitando el presupuesto formal al anfitrión.</p>
		</template>
		<template v-if="(user.id && user.id == evento.cliente_id)">
			<label class="cursor-pointer" @click="redirectMensajes()">< Ver mensajes</label>
		</template>

		<div class="box-chat">
			<textarea rows="3" v-model="mensajeEnviar"></textarea>
			<div class="box-chat__actions">
				<button 
					v-if="user.id != evento.cliente_id" 
					class="btn-presupuesto" 
					@click="enviarPropuesta()">ENVIAR PRESUPUESTO
				</button>
				<button 
					v-if="user.id == evento.cliente_id" 
					class="btn-presupuesto" 
					@click="solicitarPropuesta()">SOLICITAR PRESUPUESTO
				</button>
				<button v-if="!showLoading" class="btn-enviar-chat" @click="sendMensaje()">ENVIAR</button>
				<button v-if="showLoading" class="btn-enviar-chat" @click="sendMensaje()">
					<img src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-white.svg" alt="Cargando ..." height="40px" />
				</button>
			</div>
		</div>
		<div class="mensajes">
			<div v-for="mensaje in mensajes">
				<template v-if="mensaje.user_id == user.id">
					<div class="emisor">
						<div class="emisor__left">
							<div class="mensaje-cliente__header">
								<span>{{mensaje.created_at}}</span>
								<span>{{mensaje.firstname}}</span>
							</div>
							<p>{{mensaje.mensaje}}</p>
						</div>
						<div class="emisor__right">
							<img :src="mensaje.imagesource" :alt="mensaje.firstname" class="img-responsive img-circle">
						</div>
					</div>
				</template>
				<template v-if="mensaje.user_id != user.id">
					<div class="receptor">
						<div class="receptor__left">
							<img :src="mensaje.imagesource" :alt="mensaje.firstname" class="img-responsive img-circle">
						</div>
						<div class="receptor__right">
							<div class="mensaje-cliente__header">
								<span>{{mensaje.firstname}}</span>
								<span>{{mensaje.created_at}}</span>
							</div>
							<p>{{mensaje.mensaje}}</p>
						</div>
					</div>
				</template>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		props: [
			'eventoId'
		],
		data() {
			return {
				user: {},
				mensajeEnviar: '',
				mensajes: '',
				evento: '',
                showLoading: false
			}
		},
		mounted() {
            this.getUserAuthenticated();
            this.getEvento();
            this.getMensajes();
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
				});
			},
			getMensajes() {
				this.$http.get(`api/mensaje/${this.eventoId}`)
				.then(res => {
					this.mensajes = res.body.data;
				});
			},
			enviarPropuesta() {
				window.location.href=`/dashboard/user/${this.user.id}/evento/${this.eventoId}/nuevapropuesta`;
			},
			solicitarPropuesta() {
				let data = {
					evento_id: this.eventoId,
					user_id: 1,
					presupuesto: true,
					mensaje: `El usuario ${this.user.firstname} a solicitado que le envies un presupuesto.`
				}
				this.$http.post('api/mensaje', data)
				.then(res => {
					if(res.status == 204) {
						this.getMensajes();
						this.mensajeEnviar = '';
						swal(
								"Presupuesto solicitado!", 
								"Dentro de las próximas 48hs el dueño se pondrá en contacto", 
								"success"
							);
					}else {
						swal("Mensaje no enviado!", "Revisa los datos envíados", "error");
					}
				});
			},
			sendMensaje(){
			    this.showLoading = true;
				let data = {
					evento_id: this.eventoId,
					user_id: this.user.id,
                    presupuesto: false,
					mensaje: this.mensajeEnviar
				}
				this.$http.post('api/mensaje', data)
				.then(res => {
                    this.showLoading = false;
					if(res.status == 204) {
						this.getMensajes();
						this.mensajeEnviar = '';
					}else {
						swal("Mensaje no enviado!", "Revisa los datos envíados", "error");
					}
				});
			},
			redirectUrl(e, url) {
				e.preventDefault();
				window.location.href = `/dashboard/user/${this.user.id}/evento/${this.eventoId}${(url !== '')?url:''}`;
			},
			redirectMensajes() {
				window.location.href = `/dashboard/user/${this.user.id}/mensajes`;
			}
		}
	}
</script>
<style lang="sass">
	.container-evento {
		height: 88px;
		.navbar-chat {
			font-family: Roboto;
			font-size: 12px;
			font-weight: 500;
			letter-spacing: -0.1px;
			text-align: center;
			margin: 2em 0;
			a {
				opacity: 0.87;
				color: #191919;
				margin: 0 1em;
				transition: none;
				&:hover {
					color: #FC5289;
				}
			}
		}
		.box-chat {
			padding: 0.5em;
		    background: #f0f0f0;
		    margin: 1em 0;
		    textarea {
		    	width: 100%;
		    	padding: 1em;
		    }
		    &__actions {
			    display: flex;
			    justify-content: space-between;
			    .btn-presupuesto {
				    width: 150px;
				    height: 40px;
				    opacity: 0.87;
				    border-radius: 2px;
				    background-color: rgba(0, 0, 0, 0);
				    border: solid 2px #FC5289;
				    color: #FC5289;
				    font-size: 11px;
				    &:hover {
					    background-color: #FC5289;
					    color: #fff;
				    }
				}
				.btn-enviar-chat {
					border-radius: 2px;
				    background-color: #FC5289;
				    color: #fff;
				    border: none;
				    width: 110px;
				    height: 40px;
				    font-size: 11px;
				    &:hover {
				    	background-color: rgba(234, 81, 109, 0.87);
				    }
				}
			}
		}
		.btn-mensajes {
		    border-radius: 2px;
		    background-color: #FC5289;
		    border: none;
		    color: #fff;
		    width: 240px;
		    height: 40px;
		    &:hover {
		    	opacity: 0.87;
		    }
		}
		.mensajes {
			transition: none;
			height: auto;
		    max-height: 600px;
		    overflow-y: auto;
			.receptor {
				display: flex;
			    justify-content: space-between;
			    width: 100%;
			    height: auto;
			    padding: 1em 0;
			    margin: 1em 0;
			    &__left {
					width: 10%;
					transition: none;
			    }
			    &__right {
					width: 90%;
    				padding: 1em;
				    background-color: #f8f8f8;
				    border: solid 1px #bbbbbb;
				    margin-left: 1em;
				    transition: none;
    				.mensaje-cliente__header {
						display: flex;
    					justify-content: space-between;
    				}
			    }
			}
			.emisor {
				display: flex;
			    justify-content: space-between;
			    width: 100%;
			    height: auto;
			    padding: 1em;
			    margin: 1em 0;
			    &__left {
					width: 90%;
    				padding: 1em;
				    background-color: #fff;
				    border: solid 1px #bbbbbb;
				    margin-right: 1em;
				    transition: none;
    				.mensaje-cliente__header {
						display: flex;
    					justify-content: space-between;
    				}
			    }
			    &__right {
					width: 10%;
					transition: none;
			    }
			}
		}
	}
</style>