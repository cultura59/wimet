<template>
	<div class="container-evento">
		<div>
			<h4 class="text-center dashboard-title">{{evento.titulo_cliente}}</h4>
			<div class="navbar-chat">
				<a href="#" @click="redirectUrl($event, '')" >RESUMEN</a>
				<a href="#" @click="redirectUrl($event, '/chats')" >MENSAJES</a>
			</div>
		</div>
		<h4 class="dashboard-title">Detalles del evento <span class="leer-mas" @click="verDetalle()">+ más</span></h4>
		<template v-if="showDetail">
			<div class="row wt-m-top-2">
				<div class="col-xs-12 col-md-6">
					<div class="wt-center-column">
						<label class="container-evento__label" for="titulo">Título del evento</label>
						<span class="container-evento__span">{{evento.nombre_evento}}</span>
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="wt-center-column">
						<label class="container-evento__label" for="adquisicion">Fuente de adquisición</label>
						<span class="container-evento__span">{{evento.lead}}</span>
					</div>
				</div>
			</div>
			<div class="row wt-m-top-2">
				<div class="col-xs-12 col-md-6">
					<div class="wt-center-column">
						<label class="container-evento__label" for="actividad">Tipo de actividad</label>
						<span class="container-evento__span">{{categoria.name}}</span>
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="wt-center-column">
						<label class="container-evento__label" for="invitados">Invitados</label>
						<span class="container-evento__span">{{evento.invitados}}</span>
					</div>
				</div>
			</div>
			<div class="row wt-m-top-2">
				<div class="col-xs-12 col-md-6">
					<div class="wt-center-column">
						<label class="container-evento__label" for="comienza">Comienza</label>
						<span class="container-evento__span">{{evento.reserva_desde}}</span>
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="wt-center-column">
						<label class="container-evento__label" for="finaliza">Finaliza</label>
						<span class="container-evento__span">{{evento.reserva_hasta}}</span>
					</div>
				</div>
			</div>
			<div class="row wt-m-top-2">
				<div class="col-xs-12 col-md-6">
					<div class="wt-center-column">
						<label class="container-evento__label" for="estado">Estado</label>
						<span class="container-evento__span">{{evento.estado}}</span>
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="wt-center-column">
						<label class="container-evento__label" for="presupuesto">Presupuesto estimado</label>
						<span class="container-evento__span">{{evento.sub_total}}</span>
					</div>
				</div>
			</div>
			<div class="container-evento__box-flex">
				<label class="container-evento__label" for="descripcion">Descripción</label>
				<textarea 
					id="descripcion" 
					class="container-evento__box-flex__campo" 
					cols="30" 
					rows="5" 
					placeholder="Consulta sobre el espacio" 
					v-model="evento.descripcion_consulta"
					disabled="disabled">
				</textarea>
			</div>
			<div class="container-evento__box-flex">
				<label class="container-evento__label" for="nota">Notas</label>
				<textarea 
					id="nota" 
					class="container-evento__box-flex__campo" 
					cols="30" 
					rows="5"
					v-model="evento.notas">
				</textarea>
			</div>
		</template>
		<div>
			<h3 class="dashboard-title wt-m-top-4">Propuestas enviadas</h3>
			<table class="table text-center">
				<tr>
					<th class="text-center">Número</th>
					<th class="text-center">Creación</th>
					<th class="text-center">Enviada</th>
					<th class="text-center">Importe</th>
				</tr>
				<tr v-for="propuesta in propuestas" @click="redirectPropuesta($event, propuesta.id)" class="cursor-pointer">
					<td>{{propuesta.id}}</td>
					<td>{{propuesta.reserva_desde}}</td>
					<td>{{propuesta.created_at}}</td>
					<td>${{propuesta.sub_total}}</td>
				</tr>
			</table>
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
				evento: {},
				categoria: {},
				propuestas: '',
				showDetail: false
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
					this.user = this.$auth.getUser();
				}
			},
			getEvento() {
				this.$http.get(`api/evento/${this.eventoId}`)
				.then(res => {
					this.evento = res.body;
					this.getCategoria();
					this.getPropuestas();
				});
			},
			getCategoria() {
				this.$http.get(`/api/categoria/${this.evento.estilo_espacios_id}`)
				.then(res => {
					this.categoria = res.body;
				});
			},
			getPropuestas() {
				this.$http.get(`api/propuesta/${this.eventoId}`)
				.then(res => {
					this.propuestas = res.body;
					if(this.propuestas.length == 0) {
						this.showDetail = true;
					}
				});
			},
			verDetalle() {
				this.showDetail = !this.showDetail;
			},
			redirectUrl(e, url) {
				e.preventDefault();
				window.location.href = `/dashboard/user/${this.user.id}/evento/${this.eventoId}${url}`;
			},
			redirectPropuesta(e, id) {
				e.preventDefault();
				window.location.href = `/dashboard/user/${this.user.id}/evento/${this.eventoId}/propuesta/${id}`;
			}
		}
	}
</script>
<style lang="sass">
	.container-evento {
		.leer-mas {
			font-size: 12px;
			color: #ea516d;
			cursor: pointer;
		}
		&__label {
			font-size: 14px;
			font-weight: 500;
			letter-spacing: -0.1px;
			color: rgba(33, 33, 33, 0.87);
		}
		&__span {
			font-family: Roboto;
			font-size: 12px;
			letter-spacing: -0.1px;
			color: rgba(33, 33, 33, 0.87);
		}
		&__box-flex {
			display: flex;
			flex-direction: column;
		    justify-content: space-between;
		    margin: 1em 0;
			&__campo {
			    padding: 0.5em;
			    background-color: #ffffff;
			    border: solid 1px #979797;
			    font-size: 12px;
			    color: rgba(33, 33, 33, 0.87);
			}
		}
		.btn-mensajes {
		    border-radius: 2px;
		    background-color: #ea516d;
		    border: none;
		    color: #fff;
		    width: 240px;
		    height: 40px;
		    &:hover {
		    	opacity: 0.87;
		    }
		}
	}
</style>