<template>
	<div class="chat-main">
        <div class="evento">
            <div class="row">
                <div class="col-md-7">
                    <div class="evento_info">
                        <div class="evento_info_user">
                            <img :src="$store.getters.getUser.imagesource" :alt="$store.getters.getUser.firstname">
                            <span>{{$store.getters.getUser.firstname}}</span>
                        </div>
                        <div class="evento_info_status">
                            <span>Estado:</span>
                            <span class="evento_info_status--result">{{evento.estado}}</span>
                        </div>
                    </div>
                    <div class="evento_mensajes">
                        <div v-for="mensaje in mensajes" class="mensaje" :key="mensaje.id">
                            <div class="mensaje__avatar">
                                <img :src="mensaje.imagesource" :alt="mensaje.firstname"/>
                            </div>
                            <div class="mensaje__contenido">
                                <span class="mensaje__contenido__name">{{mensaje.firstname}}</span>
                                <p>{{mensaje.mensaje}}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <textarea class="textarea-mensaje" v-model="mensajeEnviar" rows="4"></textarea>
                    </div>
                    <div class="evento_botones">
                        <button
                                v-if="$store.getters.getUser.id != evento.cliente_id"
                                class="btn-presupuesto"
                                @click="enviarPropuesta()">ENVIAR PRESUPUESTO
                        </button>
                        <button
                                v-if="$store.getters.getUser.id == evento.cliente_id"
                                class="btn-presupuesto"
                                @click="solicitarPropuesta()">SOLICITAR PRESUPUESTO
                        </button>
                        <button v-if="!showLoading" class="btn-enviar-chat" @click="sendMensaje()">ENVIAR</button>
                        <button v-if="showLoading" class="btn-enviar-chat" @click="sendMensaje()">
                            <img src="https://res.cloudinary.com/wimet/image/upload/v1504053299/loading-white.svg" alt="Cargando ..." height="40px" />
                        </button>
                    </div>
                </div>
                <div class="col-md-5 rm-boot">
                    <div class="evento__resumen">
                        <div class="img-espacio" :style="backgroundEspacio"></div>
                        <div class="detalle__resumen">
                            <h3>{{espacio.name}}</h3>
                            <div class="detalle__resumen__detalles">
                                <div class="detalle__resumen__detalles__item-flex">
                                    <span>Categoria</span>
                                    <span>{{getCategoria(evento.estilo_espacios_id)}}</span>
                                </div>
                                <div class="detalle__resumen__detalles__item-flex">
                                    <span>Precio</span>
                                    <span>${{evento.sub_total}} /día</span>
                                </div>
                                <div class="detalle__resumen__detalles__item-flex">
                                    <span>Depósito</span>
                                    <span>${{espacio.securitydeposit}}</span>
                                </div>
                                <div class="detalle__resumen__detalles__item-flex">
                                    <span>Invitados</span>
                                    <span>{{evento.invitados}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="dias">
                            <strong>Fechas</strong>
                            <ul class="lista-dias">
                                <li v-for="dia in dias" :key="dia.id">
                                    <strong>{{$moment(dia.fecha).locale('es').format("D MMM YYYY")}}</strong>
                                    <span v-if="dia.tipo == 'all'"> (todo el día)</span>
                                    <span v-if="dia.tipo == 'morning'"> (mañana-tarde)</span>
                                    <span v-if="dia.tipo == 'night'"> (tarde-noche)</span>
                                </li>
                            </ul>
                        </div>
                        <div class="grilla">
                            <strong>Fee</strong>
                            <span>${{fee}}</span>
                        </div>
                        <div class="grilla">
                            <strong>Total</strong>
                            <span>${{evento.sub_total}}</span>
                        </div>
                        <div class="grilla">
                            <span>Políticas de cancelación</span>
                            <span>{{espacio.cancellationflexibility}}</span>
                        </div>
                        <div class="grilla">
                            <span>¿Necesita ayuda?</span>
                            <span>soporte@wimet.co</span>
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
				mensajeEnviar: '',
				mensajes: [],
				evento: {},
                espacio: {},
				propuestas: [],
                dias: [],
                showLoading: false,
                backgroundEspacio: {},
                fee: 0
			}
		},
		mounted() {
            this.getEvento();
            this.getMensajes();
        },
		methods: {
			getEvento() {
				this.$http.get(`api/evento/${this.$route.params.id}`)
				.then(res => {
					this.evento = res.body;
					this.fee = (parseFloat(this.evento.sub_total) * 5) / 100;
					this.getDias();
					this.getEspacio();
				});
			},
			getMensajes() {
				this.$http.get(`api/mensaje/${this.$route.params.id}`)
				.then(res => {
					this.mensajes = res.body.data;
				});
			},
			enviarPropuesta() {
				window.location.href=`/dashboard/user/${this.$store.getters.getUser.id}/evento/${this.$route.params.id}/nuevapropuesta`;
			},
			solicitarPropuesta() {
				let data = {
					evento_id: this.$route.params.id,
					user_id: 1,
					presupuesto: true,
					mensaje: `El usuario ${this.$store.getters.getUser.firstname} a solicitado que le envies un presupuesto.`
				}
				this.$http.post('api/mensaje', data)
				.then(res => {
					if(res.status == 204) {
						this.getMensajes();
						this.mensajeEnviar = '';
						swal(
								"Presupuesto solicitado!", 
								"Dentro de las próximas 48hs el dueño se pondrá en contacto", 
								"success"
							);
					}else {
						swal("Mensaje no enviado!", "Revisa los datos envíados", "error");
					}
				});
			},
			sendMensaje(){
			    this.showLoading = true;
				let data = {
					evento_id: this.$route.params.id,
					user_id: this.$store.getters.getUser.id,
                    presupuesto: false,
					mensaje: this.mensajeEnviar
				}
				this.$http.post('api/mensaje', data)
				.then(res => {
                    this.showLoading = false;
					if(res.status == 204) {
						this.getMensajes();
						this.mensajeEnviar = '';
					}else {
						swal("Mensaje no enviado!", "Revisa los datos envíados", "error");
					}
				});
			},
			redirectUrl(e, url) {
				e.preventDefault();
				window.location.href = `/dashboard/user/${this.$store.getters.getUser.id}/evento/${this.eventoId}${(url !== '')?url:''}`;
			},
			getEspacio() {
			    this.$http.get(`api/espacio/${this.evento.espacio_id}`)
				.then(res => {
					this.espacio = res.body;
					this.backgroundEspacio = {
					    backgroundImage: `url(https://res.cloudinary.com/wimet/image/upload/q_60/${this.espacio.images[0].name})`,
                        backgroundSize: 'cover',
                        backgroundPosition: 'center'
                    }
				}, err => {
				   console.log(err);
				});
			},
			getPropuestas() {
                this.$http.get(`api/propuesta?eventoId=${this.evento.id}`)
				.then(res => {
					this.propuestas = res.body;
				}, err => {
					console.log(err);
				});
			},
            getDias() {
			    this.$http.get(`api/eventosdias/${this.$route.params.id}`)
                .then(res => {
                    this.dias = res.body;
                });
            },
            getCategoria(id) {
			    switch(id) {
                    case 1:
                        return 'REUNIÓN';
                    case 2:
                        return 'EVENTO';
                    case 3:
                        return 'PRODUCCIÓN';
                    case 4:
                        return 'POP-UPS';
                }
            }
		}
	}
</script>
<style lang="sass" scoped>
    .chat-main {
        padding: 0 5em;
        width: 85%;
        margin: 0 auto;
        .evento {
            margin-top: 3em;
            box-shadow: 0px 0px 80px 0px rgba(0, 0, 0, 0.15);
            height: 100%;
            &_info {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: baseline;
                border: 1px solid #ececec;
                &_user {
                    width: 60%;
                    padding: 1em;
                    border-right: 1px solid #ececec;
                }
                &_status {
                    width: 40%;
                    padding: 1em;
                    display: flex;
                    justify-content: space-around;
                    &--result {
                        font-size: 14px;
                        font-weight: 600;
                        letter-spacing: 0.81px;
                        text-transform: uppercase;
                        white-space: nowrap;
                    }
                }
            }
            &_mensajes {
                height: 18em;
                padding: 1em;
                border-right: 1px solid #ececec;
                overflow-y: auto;
                .mensaje {
                    display: flex;
                    justify-content: flex-start;
                    align-items: flex-end;
                    margin-bottom: 1em;
                    &__contenido {
                        background-color: #fafafa;
                        padding: 1em;
                        border-bottom-right-radius: 1rem;
                        border-top-left-radius: 1rem;
                        border-top-right-radius: 1rem;
                        &__name {
                            color: #333;
                        }
                    }
                }
            }
            &_botones {
                border: 1px solid #ececec;
                display: flex;
                justify-content: space-between;
                align-items: baseline;
                .btn-presupuesto {
                    width: 150px;
                    height: 40px;
                    opacity: 0.87;
                    border-radius: 2px;
                    background-color: transparent;
                    border: solid 2px #FC5289;
                    color: #FC5289;
                    font-size: 11px;
                    &:hover {
                        background-color: #FC5289;
                        color: #fff;
                    }
                }
                .btn-enviar-chat {
                    border-radius: 2px;
                    background-color: #FC5289;
                    color: #fff;
                    border: none;
                    width: 110px;
                    height: 40px;
                    font-size: 11px;
                }
            }
            img {
                width: 2rem;
                border-radius: 50%;
                margin-right: 1em;
            }
            &__resumen {
                height: 28rem;
                overflow-y: auto;
                .img-espacio {
                    width: 100%;
                    height: 13em;
                }
                .detalle__resumen {
                    padding: 0 1em;
                    &__detalles {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        font-size: 11px;
                        width: 100%;
                        &__item-flex {
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            align-items: center;
                            padding: 0 1em;
                            border-right: 1px solid #ececec;
                            width: 25%;
                            height: 2rem;
                        }
                    }
                }
                .grilla {
                    padding: 1em;
                    border-bottom: 1px solid #ececec;
                    display: flex;
                    justify-content: space-between;
                    align-items: baseline;
                }
                .dias {
                    padding: 1em;
                    display: flex;
                    flex-direction: column;
                    border-bottom: 1px solid #ececec;
                    .lista-dias {
                        margin-left: 2em;
                    }
                }
            },
            .textarea-mensaje {
                width: 100%;
                border: 1px solid #ececec;
            }
        }
    }
    .rm-boot {
        margin: 0 -15px;
        padding: 0;
    }
</style>