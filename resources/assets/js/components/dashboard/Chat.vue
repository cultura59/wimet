<template>
	<div class="container-evento">
		<button v-if="user.id" @click="redirectUrl($event, 'mensajes')" class="btn-mensajes">Detalles evento</button>
		<div class="box-chat">
			<textarea rows="3" v-model="mensajeEnviar"></textarea>
			<div class="box-chat__actions">
				<button class="btn-presupuesto" @click="enviarPropuesta()">Enviar presupuesto</button>
				<button class="btn-enviar-chat" @click="sendMensaje()">Enviar</button>
			</div>
		</div>
		<div class="mensajes">
			<div v-for="mensaje in mensajes" :class="mensaje.nombre">
				<div :class="`${mensaje.nombre}__left`">
					<img :src="mensaje.imagesource" :alt="mensaje.firstname" class="img-responsive img-circle">
				</div>
				<div :class="`${mensaje.nombre}__right`">
					<div class="mensaje-cliente__header">
						<span>{{mensaje.firstname}}</span>
						<span>{{mensaje.created_at}}</span>
					</div>
					<p>{{mensaje.mensaje}}</p>
				</div>
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
				mensajes: ''
			}
		},
		mounted() {
            this.getUserAuthenticated();
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
					this.$http.get('api/usersession')
					.then(res => {
						this.user = res.body;
					});
				}
			},
			getMensajes() {
				this.$http.get(`api/mensaje/${this.eventoId}`)
				.then(res => {
					this.mensajes = res.body;
				});
			},
			enviarPropuesta() {
				window.location.href=`/dashboard/user/${this.user.id}/evento/${this.eventoId}/nuevapropuesta`;
			},
			sendMensaje(){
				let data = {
					evento_id: this.eventoId,
					user_id: this.user.id,
					mensaje: this.mensajeEnviar
				}
				this.$http.post('api/mensaje', data)
				.then(res => {
					if(res.status == 204) {
						this.getMensajes();
						this.mensajeEnviar = '';
						swal("Mensaje enviado!", "Ya falta poco, felicitaciones!", "success");
					}else {
						swal("Mensaje no enviado!", "Revisa los datos envíados", "error");
					}
				});
			},
			redirectUrl() {
				window.location.href = `/dashboard/user/${this.user.id}/evento/${this.eventoId}`;
			}
		}
	}
</script>
<style lang="sass">
	.container-evento {
		width: 45%;
		height: 88px;
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
				    width: 128px;
				    height: 40px;
				    opacity: 0.87;
				    border-radius: 2px;
				    background-color: rgba(0, 0, 0, 0);
				    border: solid 2px #ea516d;
				    color: #ea516d;
				    font-size: 11px;
				    &:hover {
					    background-color: #ea516d;
					    color: #fff;
				    }
				}
				.btn-enviar-chat {
					border-radius: 2px;
				    background-color: #ea516d;
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
		    background-color: #ea516d;
		    border: none;
		    color: #fff;
		    width: 200px;
		    height: 40px;
		    &:hover {
		    	opacity: 0.87;
		    }
		}
		.mensajes {
			height: auto;
		    max-height: 600px;
		    overflow-y: scroll;
		    padding: 0 1em;
		    border: 1px solid #f0f0f0;
			.usuario {
				display: flex;
			    justify-content: space-between;
			    width: 100%;
			    height: auto;
			    padding: 1em;
			    background-color: #f8f8f8;
			    border: solid 1px #bbbbbb;
			    margin: 1em 0;
			    &__left {
					width: 10%;
			    }
			    &__right {
					width: 90%;
    				padding: 0 1em;
    				.mensaje-cliente__header {
						display: flex;
    					justify-content: space-between;
    				}
			    }
			}
			.particular {
				display: flex;
			    justify-content: space-between;
			    width: 100%;
			    height: auto;
			    padding: 1em;
			    background-color: #f8f8f8;
			    border: solid 1px #bbbbbb;
			    margin: 1em 0;
			    &__left {
					width: 10%;
			    }
			    &__right {
					width: 90%;
    				padding: 0 1em;
    				.mensaje-cliente__header {
						display: flex;
    					justify-content: space-between;
    				}
			    }
			}
		}
	}
</style>