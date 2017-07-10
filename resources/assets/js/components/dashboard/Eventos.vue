<template>
	<div>
		<table class="table table-eventos">
			<tr class="table-eventos__header">
				<th>Creación</th>
				<th>Evento</th>
				<th>Nombre</th>
				<th>Espacio</th>
				<th>Lead</th>
				<th>Estado</th>
				<th colspan="2"></th>
			</tr>
			<tr class="table-eventos__item"v-for="evento in eventos">
				<td>{{evento.created_at}}</td>
				<td>{{evento.reserva_desde}}</td>
				<td>{{evento.firstname}}</td>
				<td>{{(evento.nombre_evento)?evento.nombre_evento:'-'}}</td>
				<td>{{evento.lead}}</td>
				<td>
					<select v-model="evento.estado">
						<option v-for="est in estados" :value="est.key">{{est.value}}</option>
					</select>
				</td>
				<td class="table-eventos__item__icons">
					<a href="#" @click="redirectEvento($event, evento.id)">
						<i class="fa fa-calendar fa-lg" aria-hidden="true"></i>
					</a>
					<a href="#"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
				</td>
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
	            	this.user = this.$auth.getUser();
        			this.getEventos();
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
<style lang="sass">
	.table-eventos {
	    background-color: #f8f8f8;
	    &__header {
	    	background-color: #fff;
	    	th {
    			padding: 1em;
	    		font-size: 16px;
				font-weight: 500;
	    		text-align: center;
				letter-spacing: -0.1px;
			    color: rgba(25, 25, 25, 0.87);
	    	}
	    }
	    &__item {
	    	td {
	    		padding: 2em;
				opacity: 0.87;
				color: #212121;
				font-size: 12px;
	    		text-align: center;
				letter-spacing: -0.1px;
	    	}
	    	&__icons {
	    		display: flex;
    			justify-content: space-between;
    			a:hover {
    				color: #e2385a;
    			}
	    	}
	    }
	}
</style>