<template>
	<div>
		<div class="container-center">
			<div id="first-step">
				<h2>¡Hola {{user.firstname}}! Estas a pasos de</h2>
				<h2>ser anfitrión de tu espacio ;)</h2>
				<div class="wt-m-top-3 wt-m-bot-3">
					<span class="title-paso">PASO 1: DATOS BÁSICOS (descripción del lugar)</span>
				</div>

				<div class="wt-m-top-3 wt-m-bot-3">
					<h3>¿Qué estilo de espacio tienes?</h3>
					
					<div class="drop-characteristic">
						<button class="drop-characteristic__btn">{{ characteristicsSelected.nombre }}</button>
						<div class="drop-characteristic__content">
							<span v-for="caract in characteristics" href="#" @click="selectCharacteristic(caract)">
								{{caract.nombre}}
							</span>
						</div>
					</div>

				</div>
				<h4>¿Qué tipo de espacio es?</h4>
				<ul class="tipo-espacio">
					<li class="typespace">
						<input type="radio" id="comercial" v-model="type" value="comercial" required style="display: none;">
						<label for="comercial" class="wt-publica-first-label">Comercial</label>
					</li>
					<li class="typespace">
						<input type="radio" id="privado" v-model="type" value="privado" required style="display: none;">
						<label for="privado" class="wt-publica-first-label">Privado</label>
					</li>
				</ul>
			</div>
		</div>
		<div class="buttons">
			<a href="/publica" class="btn-volver" onclick="showNextStep(0)">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
				<span>ATRÁS</span>
			</a>
			<input class="btn-primary-pig" type="submit" value="GUARDAR" @click="saveCharacteristic()"/>
		</div>
	</div>
</template>
<script>
	import swal from 'sweetalert';
	export default {
		data() {
			return {
				user: {},
				type: '',
				characteristics: [],
				characteristicsSelected: {id: '', nombre: 'Seleccionar'}
			}
		},
		mounted() {
            this.getUserAuthenticated();
            this.getCharacteristics();
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
			getCharacteristics() {
				this.$http.get('api/estiloespacio')
				.then(res => {
					this.characteristics = res.body;
				});
			},
			selectCharacteristic(caract) {
				this.characteristicsSelected = caract;
			},
			saveCharacteristic() {
				let data = {
					user_id: this.user.id,
					name: Date.now(),
					description: '',
					type: this.type,
					estilos: [this.characteristicsSelected.id]
				};
				this.$http.post('saveEspaciowithoutdata', data)
				.then(res => {
					if(res.status == 200) {
						location.href = `/publicar/primer-paso/espacio/${res.body.id}/categorias`;
					}else {
						swal("Error al guardar el espacio", "Los datos no son correctos", "error")
					}
				});
			}
		}
	}
</script>
<style lang="sass">
	.drop-characteristic {
		position: relative;
    	display: inline-block;
    	&__btn {
		    width: 204px;
		    font-size: 16px;
		    cursor: pointer;
		    text-align: left;
		    padding: 16px 30px;
		    background-color: white;
		    border: 1px solid rgba(0,0,0,0.2);
		}
		&__content {
		    z-index: 1;
		    width: 204px;
		    height: 200px;
			display: none;
		    overflow-y: scroll;
		    position: absolute;
		    background-color: white;
		    border: 1px solid rgba(0,0,0,0.2);
		    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		    span {
			    color: black;
			    display: block;
			    cursor: pointer;
			    padding: 12px 16px;
			    text-decoration: none;
			    &:hover {background-color: #f1f1f1}
			}
		}
		&:hover &__content {
		    display: block;
		}
	}
</style>