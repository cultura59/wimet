<template>
	<div>
		<div class="container-mis-mensajes">
			<span class="container-mis-mensajes__title">MIS MENSAJES</span>
			<div class="mensajes-main__links">
				<div v-if="$store.getters.getUser.tipo_clientes_id > 1" >
					<a href="#"
					   :class="(showMensajesType == 2) ? 'mensajes-main__links--active' : 'mensajes-main__links--default'"
					   @click="changeType($event, 2)">COMO ANFITRIÓN
					</a>
					<a href="#"
					   :class="(showMensajesType == 1) ? 'mensajes-main__links--active' : 'mensajes-main__links--default'"
					   @click="changeType($event, 1)">COMO ORGANIZADOR
					</a>
				</div>
			</div>
			<select v-model="filtroType" @change="getMensajes(filtroType)" class="mensajes-main__select">
				<option value="">Todos los mensajes</option>
				<option value="consulta">Consulta</option>
				<option value="seguimiento">Seguimiento</option>
				<option value="visita">Visita</option>
				<option value="presupuesto">Presupuesto</option>
				<option value="reservado">Reservado</option>
				<option value="realizado">Realizado</option>
				<option value="perdido">Perdido</option>
			</select>
		</div>
		<div class="mensajes-main">
			<div class="mensajes">
				<div v-if="!loadingData">
					<div class="row wt-m-bot-1">
						<div class="col-md-1"></div>
						<div class="col-md-7"><strong>Recibido</strong></div>
						<div class="col-md-2"><p class="text-center"><b>Evento</b></p></div>
						<div class="col-md-2"><p class="text-center"><b>Estado</b></p></div>
					</div>
					<div
						v-if="(eventoselect !== '')"
						v-for="(mensaje, key) in mensajes.data"
						class="cursor-pointer mensaje row"
					>
						<router-link :to="`/mensaje/${mensaje.evento_id}`">
							<div class="col-md-1">
								<img :src="mensaje.imagesource" :alt="mensaje.firstname" class="img-responsive img-circle" style="width: 44px;">
							</div>
							<div class="col-md-2">
								<div class="wt-center-column">
									<strong>{{mensaje.firstname}}</strong>
									<span class="firstUpper">{{$moment(mensaje.created_at).locale('es').format("DD MMM YYYY")}}</span>
								</div>
							</div>
							<div class="col-md-5">
								<p>{{recortarTexto(mensaje.mensaje, 75)}}...</p>
							</div>
							<div class="col-md-2">
								<p class="text-center">{{recortarTexto(mensaje.name, 20)}}...</p>
							</div>
							<div class="col-md-2">
								<p class="status text-center">{{mensaje.estado}}</p>
							</div>
						</router-link>
					</div>
					<div v-if="(mensajes.length == 0)" class="no-hay-mensajes">
						<p>No hay consultas aún...</p>
					</div>
				</div>
				<div v-if="loadingData">
					<div class="white-widget grey-bg author-area">
						<div class="auth-info row">
							<div class="timeline-wrapper">
								<div class="timeline-item">
									<div class="animated-background">
										<div class="background-masker header-top"></div>
										<div class="background-masker header-left"></div>
										<div class="background-masker header-right"></div>
										<div class="background-masker header-bottom"></div>
										<div class="background-masker subheader-left"></div>
										<div class="background-masker subheader-right"></div>
										<div class="background-masker subheader-bottom"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="wt-center-around wt-m-top-3">
				<div>
					<span v-if="mensajes.prev_page_url !== null" @click="getPagination(true)" class="pointer">Atrás</span>
				</div>
				<div>
					<span v-if="mensajes.next_page_url !== null" @click="getPagination(false)" class="pointer">Siguiente</span>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
                loadingData: true,
				mensajes: '',
				evento: '',
				espacio: '',
				eventoselect: '',
				showMensajesType: 2,
                filtroType: ''
			}
		},
		mounted() {
            if(this.$route.query.type !== undefined && this.$route.query.type == 'organizador') {
                this.showMensajesType = 1;
            }
            this.getMensajes('');
        },
		methods: {
			getMensajes(filtro) {
			    this.loadingData = true;
                let url = `api/mensajes/${this.$store.getters.getUser.id}/type/${this.showMensajesType}`;

                if(filtro !== ''){
                    url += `?estado=${filtro}`;
                }

				this.$http.get(url)
				.then(res => {
					this.mensajes = res.body;
					this.eventoselect = this.mensajes.data[0];
					this.loadingData = false;
				});
			},
			recortarTexto(texto, number) {
				return texto.substring(0, number);
			},
			changeType(e, type) {
				e.preventDefault();
				this.showMensajesType = type;
				this.getMensajes('');
			},
            getPagination(val) {
			    let url;
			    if(val) {
			        url = this.mensajes.prev_page_url;
				}else {
                    url = this.mensajes.next_page_url;
				}
                this.$http.get(url)
				.then(res => {
					this.mensajes = res.body;
					this.eventoselect = this.mensajes.data[0];
					this.loadingData = false;
				});
			}
		}
	}
</script>
<style lang="sass" scoped>
	.container-mis-mensajes {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		padding: 0 2em;
		margin-top: 4em;
		align-items: center;
		&__title {
			font-family: Avenir;
			font-size: 16px;
			font-weight: bold;
			color: #333333;
			margin-bottom: 1em;
		}
	}
	.mensajes-main {
		padding: 3em 2em;
		background-color: #ffffff;
		box-shadow: 0 0 68px 0 rgba(0, 0, 0, 0.1);
		&__links{
			display: flex;
			justify-content: space-between;
			&--default {
				opacity: 0.87;
				font-size: 12px;
				color: #191919;
				text-decoration: none;
				padding: .8em 0;
				margin: 0 .5em;
				&:hover, &:focus {
					transition: none;
					text-decoration: none;
					border-bottom: 4px solid #fc5289;
					padding: .8em 0;
					margin: 0 .5em;
				}
			}
			&--active {
				opacity: 0.87;
				font-size: 12px;
				color: #fc5289;
				text-decoration: none;
				border-bottom: 4px solid #fc5289;
				padding: .8em 0;
				margin: 0 .5em;
			}
		}
		.mensajes {
			width: 100%;
			height: 30em;
			overflow-y: auto;
			overflow-x: hidden;
			.mensaje {
				max-height: 100px;
				background-color: #f8f8f8;
				border-top: 2px solid #fff;
				border-bottom: 2px solid #fff;
				padding: 10px;
				cursor: pointer;
				a{
					font-family: Avenir;
					font-size: 12px;
					color: #333333;
				}
				.firstUpper {text-transform: capitalize;}
				.status {color: #fc5289;}
			}
		}
        &__select {
			padding: .6em 2em;
			cursor: pointer;
			border: 1px solid #fff;
			-webkit-appearance: none;
			border-radius: 0px;
			background-color: #fff;
			color: #191919;
        }
	}
	.link-chats {
		text-decoration: none;
		color: #e2385a;
	}
	b, strong {color: #333333}
	.no-hay-mensajes {
		height: 150px;
		border-radius: 10px;
		background-color: #f8f8f8;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.pointer {
		cursor: pointer;
		color: #FC5289;
	}
</style>