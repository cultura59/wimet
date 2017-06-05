<template>
	<div>
		<h1>Detalles del evento</h1>
		<ul v-if="user.id">
			<li><a href="#" @click="redirectUrl($event, 'mensajes')">Mensajes</a></li>
		</ul>
		<form>
			<div>
				<label for="titulo">Título del evento</label>
				<input type="text" id="titulo" placeholder="Nombre del evento" v-model="evento.nombre_evento">
			</div>
			<div>
				<label for="adquisicion">Fuente de adquisición</label>
				<select id="adquisicion" v-model="evento.lead">
					<option value="wimet">Wimet</option>
				</select>
			</div>
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
			<div>
				<label for="estado">Estado</label>
				<select id="estado" v-model="evento.estado">
					<option value="consulta">Consulta</option>
					<option value="seguimiento">Seguimiento</option>
				</select>
			</div>
			<div>
				<label for="presupuesto">Presupuesto estimado</label>
				<input type="text" id="presupuesto" placeholder="$99.99" v-model="evento.sub_total">
			</div>
			<div>
				<label for="descripcion">Descripción</label>
				<textarea 
					id="descripcion" 
					cols="30" 
					rows="10" 
					placeholder="Consulta sobre el espacio" 
					v-model="evento.descripcion_consulta">
				</textarea>
			</div>
			<div>
				<label for="nota">Notas</label>
				<textarea 
					id="nota" 
					cols="30" 
					rows="10"
					v-model="evento.notas">
				</textarea>
			</div>
		</form>
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
<style>
	
</style>