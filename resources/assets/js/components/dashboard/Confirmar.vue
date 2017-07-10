<template>
	<div>
		<div>
			<h3>1. Datos de contacto</h3>
			<div class="wt-space-block">
				<div class="wt-center-column">
					<label for="nombre">Nombre</label>
					<input id="nombre" type="text" v-model="user.firstname" class="input-confirmar" placeholder="Ingrese nombre"/>
				</div>
				<div class="wt-center-column">
					<label for="apellido">Apellido</label>
					<input id="apellido" type="text" v-model="user.lastname" class="input-confirmar" placeholder="Ingrese apellido"/>
				</div>
			</div>
			<div class="wt-space-block wt-m-top-2">
				<div class="wt-center-column">
					<label for="nombre">Email</label>
					<input id="email" type="text" v-model="user.email" class="input-confirmar" placeholder="Ingrese email"/>
				</div>
				<div class="wt-center-column">
					<label for="telefono">Teléfono</label>
					<input id="telefono" type="text" v-model="user.phone" class="input-confirmar" placeholder="Ingrese teléfono"/>
				</div>
			</div>
			<button class="btn-primary-pig wt-m-top-2" @click="confirmarPago()">GUARDAR</button>
		</div>
		<div class="wt-m-top-4">
			<h3>2. Detalles de pago</h3>
			<button class="btn-primary-pig" @click="confirmarPago()">PAGAR</button>
		</div>
	</div>
</template>
<script>
	export default {
		props: [
			'propuestaId',
			'url'
		],
		data() {
			return {
				user: {}
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
				}
			},
			confirmarPago() {
				if(this.user.phone == "") {
					swal('Campo requerido', 'Debe ingresar un teléfono para avanzar', 'error');
					return;
				}
				window.location.href = this.url;
			}
		}
	}
</script>
<style>
	.input-confirmar {
	    width: 240px;
	    height: 40px;
	    background-color: #ffffff;
	    border: solid 1px #979797;
	    padding: .5em;
	}
</style>