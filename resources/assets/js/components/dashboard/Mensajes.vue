<template>
	<div>
		<div class="mensajes-main">
			<div class="mensajes-main__links">
				<div v-if="$store.getters.getUser.tipo_clientes_id > 1" >
					<a href="#" 
						:class="(showMensajesType == 1) ? 'mensajes-main__links--active' : 'mensajes-main__links--default'" 
						@click="changeType($event, 1)">COMO ORGANIZADOR
					</a>
					<a href="#" 
						:class="(showMensajesType == 2) ? 'mensajes-main__links--active' : 'mensajes-main__links--default'" 
						@click="changeType($event, 2)">COMO ANFITRIÓN
					</a>
				</div>
				<div>
					<select v-model="filtroType" @change="getMensajes(filtroType)" class="mensajes-main__select">
						<option value="">Todos</option>
                        <option value="consulta">Consulta</option>
						<option value="seguimiento">Seguimiento</option>
						<option value="visita">Visita</option>
						<option value="presupuesto">Presupuesto</option>
						<option value="reservado">Reservado</option>
                        <option value="realizado">Realizado</option>
                        <option value="perdido">Perdido</option>
					</select>
				</div>
			</div>
			<div class="mensajes">
				<div v-if="!loadingData">
					<div
						v-if="(eventoselect !== '')"
						v-for="(mensaje, key) in mensajes"
						class="cursor-pointer mensaje row"
					>
						<router-link :to="`/mensaje/${mensaje.evento_id}`">
							<div class="col-md-1">
								<img :src="mensaje.imagesource" :alt="mensaje.firstname" class="img-responsive img-circle">
							</div>
							<div class="col-md-2">
								<div class="wt-center-column">
									<span>{{mensaje.firstname}}</span>
									<span>{{$moment(mensaje.created_at).locale('es').format("MMM DD")}}</span>
								</div>
							</div>
							<div class="col-md-7">
								<p>{{recortarTexto(mensaje.mensaje)}}...</p>
							</div>
							<div class="col-md-2">
								<span class="status">{{mensaje.estado}}</span>
							</div>
						</router-link>
					</div>
					<div v-if="(mensajes.length == 0)">
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
				showMensajesType: 1,
                filtroType: ''
			}
		},
		mounted() {
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
					this.eventoselect = this.mensajes[0];
					this.loadingData = false;
				});
			},
			recortarTexto(texto) {
				return texto.substring(0, 140);
			},
			changeType(e, type) {
				e.preventDefault();
				this.showMensajesType = type;
				this.getMensajes('');
			}
		}
	}
</script>
<style lang="sass" scoped>
	.mensajes-main {
		padding: 1em 5em;
		width: 85%;
		margin: 0 auto;
		&__links{
			padding: 1em 0 2em 0;
			display: flex;
			justify-content: space-between;
			&--default {
				opacity: 0.87;
				font-size: 16px;
				font-weight: 500;
				letter-spacing: -0.1px;
				text-align: justify;
                margin-right: 1em;
				color: #191919;
				&:hover, &:focus {
					transition: none;
					text-decoration: none;
					border-bottom: 2px solid #d17f87;
					padding-bottom: .5em;
				}
			}
			&--active {
				opacity: 0.87;
				font-size: 16px;
				font-weight: 500;
				letter-spacing: -0.1px;
				text-align: justify;
				color: #d17f87;
				text-decoration: none;
				border-bottom: 2px solid #d17f87;
                margin-right: 1em;
				padding-bottom: .5em;
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
				.status {
					color: #d17f87;
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
        &__select {
            padding: 5px;
            cursor: pointer;
        }
	}
	.link-chats {
		text-decoration: none;
		color: #e2385a;
	}
</style>