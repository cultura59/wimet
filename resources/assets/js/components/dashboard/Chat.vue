<template>
	<div>
		<ul>
			<li><a :href="`/dashboard/user/${user.id}/evento/${eventoId}`">Detalles evento</a></li>
		</ul>
		<div>
			<textarea cols="30" rows="10" v-model="mensajeEnviar"></textarea>
			<div>
				<button @click="enviarPropuesta()">Enviar presupuesto</button>
				<button @click="sendMensaje()">Enviar</button>
			</div>
		</div>
		<div class="mensajes">
			<div v-for="mensaje in mensajes" :class="mensaje.nombre">
				<img :src="mensaje.imagesource" :alt="mensaje.firstname">
				<div class="mensaje-cliente__header">
					<span>{{mensaje.firstname}}</span>
					<span>{{mensaje.created_at}}</span>
				</div>
				<p>{{mensaje.mensaje}}</p>
			</div>
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
				mensajeEnviar: '',
				mensajes: ''
			}
		},
		mounted() {
            this.getUserAuthenticated();
            this.getMensajes();
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
					});
				}
			},
			getMensajes() {
				this.$http.get(`api/mensaje/${this.eventoId}`)
				.then(res => {
					this.mensajes = res.body;
				});
			},
			enviarPropuesta() {
				window.location.href=`/dashboard/user/${this.user.id}/evento/${this.eventoId}/nuevapropuesta`;
			},
			sendMensaje(){
				let data = {
					evento_id: this.eventoId,
					user_id: this.user.id,
					mensaje: this.mensajeEnviar
				}
				this.$http.post('api/mensaje', data)
				.then(res => {
					if(res.status == 204) {
						this.getMensajes();
						this.mensajeEnviar = '';
						swal("Mensaje enviado!", "Ya falta poco, felicitaciones!", "success");
					}else {
						swal("Mensaje no enviado!", "Revisa los datos envíados", "error");
					}
				});
			}
		}
	}
</script>
<style>
	
</style>