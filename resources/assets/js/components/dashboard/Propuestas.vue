<template>
	<div>
		<div class="container-mis-propuestas">
			<span class="container-mis-propuestas__title">MIS PROPUESTAS</span>
            <router-link to="/propuesta/custom" class="btn-nueva-propuesta">NUEVA PROPUESTA</router-link>
		</div>
        <div class="propuestas-main__links">
            <div v-if="$store.getters.getUser.tipo_clientes_id > 1" >
                <a href="#"
                   :class="(showPropuestasType == 2) ? 'propuestas-main__links--active' : 'propuestas-main__links--default'"
                   @click="changeType($event, 2)">COMO ANFITRIÓN
                </a>
                <a href="#"
                   :class="(showPropuestasType == 1) ? 'propuestas-main__links--active' : 'propuestas-main__links--default'"
                   @click="changeType($event, 1)">COMO ORGANIZADOR
                </a>
            </div>
        </div>
		<div class="propuestas-main">
			<div class="propuestas">
				<div v-if="!loadingData">
					<table v-if="(eventoselect !== '')" class="table text-center">
						<thead>
						<tr>
							<th class="text-center">Número</th>
                            <th class="text-center">Espacio</th>
							<th class="text-center">Creación</th>
							<th class="text-center">Enviada</th>
							<th class="text-center">Importe</th>
                            <th class="text-center">Estado</th>
						</tr>
						</thead>
						<tbody>
						<tr v-for="propuesta in propuestas" @click="verPropuesta(propuesta.id)" class="cursor-pointer active">
							<td>{{propuesta.id}}</td>
                            <td>{{propuesta.espacio.name}}</td>
							<td>{{$moment(propuesta.reserva_desde).locale('es').format("MMM DD")}}</td>
							<td>{{$moment(propuesta.created_at).locale('es').format("MMM DD")}}</td>
							<td>${{propuesta.sub_total}}</td>
                            <td>{{propuesta.estado}}</td>
						</tr>
						</tbody>
					</table>
					<div v-if="(propuestas.length == 0)" class="no-hay-propuestas">
						<p>No hay propuestas aún...</p>
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
        name: 'propuestas',
        data() {
            return {
                loadingData: true,
                propuestas: [],
                evento: {},
                eventoselect: {},
                showPropuestasType: 2,
                filtroType: ''
            }
        },
        mounted() {
            if(this.$route.query.type !== undefined && this.$route.query.type == 'organizador') {
                this.showPropuestasType = 1;
            }
            this.getPropuestas();
        },
        methods: {
            getPropuestas() {
                this.loadingData = true;
                let url = `api/propuesta/?type=${this.showPropuestasType}&user_id=${this.$store.getters.getUser.id}`;

                this.$http.get(url)
                    .then(res => {
                        this.propuestas = res.body;
                        this.eventoselect = this.propuestas[0];
                        this.loadingData = false;
                    });
            },
            recortarTexto(texto, number) {
                return texto.substring(0, number);
            },
            changeType(e, type) {
                e.preventDefault();
                this.showPropuestasType = type;
                this.getPropuestas('');
            },
            verPropuesta(id) {
                this.$router.push({name: 'Propuesta', params: { id: id }});
            }
        }
    }
</script>
<style lang="sass" scoped>
	.container-mis-propuestas {
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
        .btn-nueva-propuesta {
            border-radius: 2px;
            background-color: #fc5289;
            border: none;
            color: #fff;
            padding: .5em 2em;
            text-decoration: none;
        }
	}
    .propuestas-main {
        padding: 3em 2em;
        background-color: #ffffff;
        box-shadow: 0 0 68px 0 rgba(0, 0, 0, 0.1);
        th {color: #333}
        &__links{
            display: flex;
            justify-content: center;
            margin-bottom: 1em;
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
        .propuestas {
            width: 100%;
            height: 30em;
            overflow-y: auto;
            overflow-x: hidden;
            .propuesta {
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
    .no-hay-propuestas {
        height: 150px;
        border-radius: 10px;
        background-color: #f8f8f8;
        display: flex;
        justify-content: center;
        align-items: center;
	}
</style>