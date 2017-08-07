<template>
	<div>
		<div class="container-center">
			<div>
				<h3>¡Cuéntale al mundo acerca de tu espacio!</h3>
				<div class="wt-m-top-4">
					<p>Título de tu espacio</p>
					<input v-model="espacio.name" type="text" class="wt-custom-input" placeholder="Ingrese el titulo de su espacio">
					<p>{{fntCountName}} caracteres</p>
				</div>
				<div class="wt-m-top-4">
					<label class="text-bold">Descripción</label>
					<textarea v-model="espacio.description" class="wt-textarea" rows="7" placeholder="Escriba una breve descripción de su espacio, que lo caracteriza y cuales son sus mejores aspectos."></textarea>
					<p>{{fntCountDescription}} caracteres</p>
				</div>
			</div>
		</div>

		<div class="buttons">
			<a :href="`/publicar/segundo-paso/espacio/${this.espacioId}/amenities`" class="btn-volver">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
				<span>ATRÁS</span>
			</a>
			<button class="btn-primary-pig" @click="saveEspacio()">GUARDAR</button>
		</div>
	</div>
</template>
<script>
	import swal from 'sweetalert';
	export default {
		props: [
			'espacioId'
		],
		data(){
			return {
				espacio: {},
				countName: 50,
				countDescription: 500
			}
		},
		mounted() {
			this.getEspacio();
		},
		computed: {
			fntCountName() {
				return this.countName - this.espacio.name.length;
			},
			fntCountDescription() {
				return this.countDescription - this.espacio.description.length;
			}
		},
		methods: {
			getEspacio() {
				this.$http.get(`api/espacio/${this.espacioId}`)
				.then((res) => {
					this.espacio = res.body;
					let name = parseInt(this.espacio.name);
					this.espacio.name = (Number.isInteger(name)) ? '' : this.espacio.name;
				});
			},
			saveEspacio() {
				this.espacio.step = 3;
				this.$http.post(`saveespacio`, this.espacio)
				.then((res) => {
					if(res.status == 200) {
						location.href = `/publicar/espacio/${this.espacioId}`;
					}else {
						swal('Ups, algo salio mal', 'Los datos ingresados no son correctos.', 'error');
					}
				});
			}
		}
	}
</script>