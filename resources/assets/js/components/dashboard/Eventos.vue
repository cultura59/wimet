<template>
	<div>
		<table class="table">
			<tr>
				<th>Creación</th>
				<th>Evento</th>
				<th>Nombre</th>
				<th>Espacio</th>
				<th>Lead</th>
				<th>Estado</th>
				<th colspan="2"></th>
			</tr>
			<tr v-for="evento in eventos">
				<td>{{evento.created_at}}</td>
				<td>{{evento.reserva_desde}}</td>
				<td>{{evento.firstname}}</td>
				<td>{{evento.nombre_evento}}</td>
				<td>{{evento.lead}}</td>
				<td>
					<select v-model="evento.estado">
						<option v-for="est in estados" :value="est.key">{{est.value}}</option>
					</select>
				</td>
				<td><a href="#" @click="redirectEvento($event, evento.id)">ver</a></td>
				<td><a href="#">borrar</a></td>
			</tr>
		</table>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				user: {},
				eventos: '',
				estados: [
					{key: 'consulta', value: 'consulta'},
					{key: 'seguimiento', value: 'seguimiento'},
					{key: 'visita', value: 'visita'},
					{key: 'presupuesto', value: 'consulta'},
					{key: 'reservado', value: 'reservado'},
					{key: 'realizado', value: 'realizado'},
					{key: 'perdido', value: 'perdido'}
				]
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
            			this.getEventos();
					});
				}
			},
			getEventos() {
				this.$http.get(`api/geteventos/${this.user.id}`)
				.then(res => {
					this.eventos = res.body;
				});
			},
			redirectEvento(e, eventoId) {
				e.preventDefault();
				window.location.href = `/dashboard/user/${this.user.id}/evento/${eventoId}`;
			}
		}
	}
</script>