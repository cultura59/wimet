<template>
	<div class="container-evento">
		<h4>Detalles del evento</h4>
		<button v-if="user.id" @click="redirectUrl($event, 'mensajes')" class="btn-mensajes">Mensajes</button>
		<div>
			<div class="container-evento__box">
				<div class="container-evento__box__item">
					<label for="titulo">Título del evento</label>
					<input class="container-evento__box__item__campo" type="text" id="titulo" placeholder="Nombre del evento" v-model="evento.nombre_evento">
				</div>
				<div class="container-evento__box__item">
					<label for="adquisicion">Fuente de adquisición</label>
					<select class="container-evento__box__item__campo" id="adquisicion" v-model="evento.lead">
						<option value="wimet">Wimet</option>
					</select>
				</div>
			</div>
			<div class="container-evento__box">
				<div class="container-evento__box__item">
					<label for="actividad">Tipo de actividad</label>
					<select class="container-evento__box__item__campo" id="actividad" v-model="evento.estilo_espacios_id">
						<option value="1">Reunión</option>
					</select>
				</div>
				<div class="container-evento__box__item">
					<label for="invitados">Invitados</label>
					<input class="container-evento__box__item__campo" type="text" id="invitados" placeholder="Nombre del evento" v-model="evento.invitados">
				</div>
			</div>
			<div class="container-evento__box">
				<div class="container-evento__box__item">
					<label for="comienza">Comienza</label>
					<input class="container-evento__box__item__campo" type="date" id="comienza" v-model="evento.reserva_desde">
				</div>
				<div class="container-evento__box__item">
					<label for="finaliza">Finaliza</label>
					<input class="container-evento__box__item__campo" type="date" id="finaliza" v-model="evento.reserva_hasta">
				</div>
			</div>
			<div class="container-evento__box">
				<div class="container-evento__box__item">
					<label for="estado">Estado</label>
					<select class="container-evento__box__item__campo" id="estado" v-model="evento.estado">
						<option value="consulta">Consulta</option>
						<option value="seguimiento">Seguimiento</option>
					</select>
				</div>
				<div class="container-evento__box__item">
					<label for="presupuesto">Presupuesto estimado</label>
					<input class="container-evento__box__item__campo" type="text" id="presupuesto" placeholder="$99.99" v-model="evento.sub_total">
				</div>
			</div>
			<div class="container-evento__box-flex">
				<label for="descripcion">Descripción</label>
				<textarea 
					id="descripcion" 
					class="container-evento__box-flex__campo" 
					cols="30" 
					rows="5" 
					placeholder="Consulta sobre el espacio" 
					v-model="evento.descripcion_consulta">
				</textarea>
			</div>
			<div class="container-evento__box-flex">
				<label for="nota">Notas</label>
				<textarea 
					id="nota" 
					class="container-evento__box-flex__campo" 
					cols="30" 
					rows="5"
					v-model="evento.notas">
				</textarea>
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
				evento: {}
			}
		},
		mounted() {
            this.getUserAuthenticated();
            this.getEvento();
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
				});
			},
			redirectUrl(e, url) {
				e.preventDefault();
				window.location.href = `/dashboard/user/${this.user.id}/evento/${this.eventoId}/${url}`;
			}
		}
	}
</script>
<style lang="sass">
	.container-evento {
		width: 45%;
		&__box {
			display: flex;
		    justify-content: space-between;
		    margin: 1em 0;
		    &__item {
		    	display: flex;
    			flex-direction: column;
    			label {
    				font-size: 12px;
    			}
    			&__campo {
				    padding: 0.5em;
				    width: 200px;
				    height: 40px;
				    background-color: #ffffff;
				    border: solid 1px #979797;
				    font-size: 14px;
				}
		    }
		}
		&__box-flex {
			display: flex;
			flex-direction: column;
		    justify-content: space-between;
		    margin: 1em 0;
			label {
				font-size: 12px;
			}
			&__campo {
			    padding: 0.5em;
			    background-color: #ffffff;
			    border: solid 1px #979797;
			    font-size: 14px;
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
	}
</style>