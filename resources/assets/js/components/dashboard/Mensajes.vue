<template>
	<div>
		<div class="mensajes-main">
			<div class="mensajes-main__links">
				<a href="#" 
					:class="(showMensajesType == 1) ? 'mensajes-main__links--active' : 'mensajes-main__links--default'" 
					@click="changeType($event, 1)">Como organizador
				</a>
				<a href="#" 
					:class="(showMensajesType == 2) ? 'mensajes-main__links--active' : 'mensajes-main__links--default'" 
					@click="changeType($event, 2)">Como anfitrión
				</a>
			</div>
			<div class="mensajes">
				<div 
					v-if="(eventoselect !== '')"
					v-for="(mensaje, key) in mensajes" 
					@click="redirectMensajes($event, mensaje.id)"
					class="cursor-pointer mensaje row"
				>
					<div class="col-md-1">
						<img :src="mensaje.imagesource" :alt="mensaje.firstname" class="img-responsive img-circle">
					</div>
					<div class="col-md-2">
						<div class="wt-center-column">
							<span>{{mensaje.firstname}}</span>
							<span>{{mensaje.created_at}}</span>
						</div>
					</div>
					<div class="col-md-8">
						<p>{{recortarTexto(mensaje.mensaje)}}...</p>
					</div>
					<div class="col-md-1">
						<span>Consulta</span>
					</div>
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
				showMensajesType: 1
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
			redirectMensajes(e, eventoId){
			    e.preventDefault();
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
<style lang="sass" scoped>
	.mensajes-main {
		padding: 1em 5em;
		height: 930px;
		width: 100%;
		float: left;
		&__links{
			padding: 1em 0 2em 0;
			width: 25%;
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
					transition: none;
					text-decoration: none;
					border-bottom: 2px solid #e2385a;
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
					transition: none;
					text-decoration: none;
					border-bottom: 2px solid #e2385a;
				}
			}
		}
		.mensajes {
			width: 100%;
			height: 600px;
			overflow-y: auto;
			overflow-x: hidden;
			.mensaje {
				max-height: 100px;
				background-color: #f8f8f8;
				border-top: 1px solid #fff;
				border-bottom: 1px solid #fff;
				padding: 10px;
				cursor: pointer;
				&__left {
					width: 5%;
					float: left;
				}
				&__right {
					width: 90%;
					padding-left: 1em;
					display: flex;
					flex-direction: row;
					&__text {
						padding-left: 2em;
						display: flex;
						justify-content: baseline;
						align-items: center;
					}
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
					width: 5%;
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
	.link-chats {
		text-decoration: none;
		color: #e2385a;
	}
</style>