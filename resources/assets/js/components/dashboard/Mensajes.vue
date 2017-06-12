<style lang="sass">
	.mensajes-main {
		padding: 1em 5em;
	    height: 930px;
	    width: 60%;
	    float: left;
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
</style>
<template>
	<div>
		<div class="mensajes-main">
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
					<button@click="redirectMensajes(evento.id)">Mensajes</button>
					<button@click="redirectMensajes(evento.id)">Propuesta recibida</button>
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
				eventoselect: ''
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
					this.$http.get('api/usersession')
					.then(res => {
						this.user = res.body;
            			this.getMensajes();
					});
				}
			},
			getMensajes() {
				this.$http.get(`api/mensajes/${this.user.id}`)
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
			}
		}
	}
</script>