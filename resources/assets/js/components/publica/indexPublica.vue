<template>
	<div>
		<div class="container-left">
			<div class="content-publica">
				<div v-if="step == 2">
					<h1>¡Lo estas haciendo muy bien, {{user.firstname}}!</h1>
					<p class="sub-title-info">
						Es momento de añadir información descriptiva sobre tu espacio para que puedas publicarlo.
					</p>
				</div>
				<div v-if="step == 3">
					<h1>¡Excelente trabajo!</h1>
					<p class="sub-title-info">
						Define la política y reglas de tu espacio para poder ofrecerlo.
					</p>
				</div>
				<div v-if="step == 4">
					<h1>¡Felicitaciones, {{user.firstname}}!</h1>
					<p class="sub-title-info">
						Tu espacio será publicado en la plataforma una vez aprobado por nuestro equipo. Este proceso puede demorar hasta 48 hs.<br>
						Si falta alguna información, por favor, accede a tu espacio y edita lo que consideres relevante.
					</p>
					<div v-if="enviarValidacion">
						<a href="#" @click="enviarAprobacion($event, espacioId)">
							<button class="btn-primary-pig-lg">ENVIAR PARA APROBACIÓN</button>
						</a>
					</div>
					<div v-if="!enviarValidacion">
						<p class="sub-title-info">Para que el espacio sea revisado debe completar Superficie, Accesos, Asistentes de pie, Asistentes sentados, reglas y precio.</p>
					</div>
				</div>
				
				<div class="box-step">
					<div>
						<img v-if="step >= 1" src="/img/wimet_ic_check_24px_accent.svg" style="width: 30px" alt="Primer paso" class="pull-right">
						<h2 class="Sub-title">Paso 1: Lo esencial</h2>
					</div>
					<p class="sub-title-info">Tipo de espacio, accesibilidad, capacidad y dirección.</p>
					<a :href="`/publicar/primer-paso/espacio/${espacioId}/categorias`" class="link">EDITAR</a>
				</div>
				
				<div class="box-step">
					<div>
						<img v-if="step > 2" src="/img/wimet_ic_check_24px_accent.svg" style="width: 30px" alt="Primer paso" class="pull-right">
						<h2 class="Sub-title">Paso 2: Exhibe tu lugar</h2>
					</div>
					<p class="sub-title-info">Imágenes, características, amenities y descripción.</p>
					<a v-if="step == 2" :href="`/publicar/segundo-paso/espacio/${espacioId}/images`">
						<button class="btn-primary-pig">CONTINUAR</button>
					</a>
					<a v-if="step > 2" :href="`/publicar/segundo-paso/espacio/${espacioId}/images`" class="link">EDITAR</a>
				</div>
				
				<div class="box-step">
					<div>
						<img v-if="step == 4" src="/img/wimet_ic_check_24px_accent.svg" style="width: 30px" alt="Primer paso" class="pull-right">
						<h2 class="Sub-title">Paso 3: Prepárate para alquilar</h2>
					</div>
					<p class="sub-title-info">Reglas, precio, disponibilidad y políticas del espacio.</p>
					<a v-if="step == 3" :href="`/publicar/tercer-paso/espacio/${espacioId}/reglas`">
						<button class="btn-primary-pig">CONTINUAR</button>
					</a>
					<a v-if="step == 4" :href="`/publicar/tercer-paso/espacio/${espacioId}/reglas`" class="link">EDITAR</a>
				</div>
			</div>
		</div>
		<div class="container-right">
			<div class="container-right__dialog-box">
			<div>
				<p v-if="step == 1">Un pequeño paso para ti, un gran paso para la comunidad.</p>
				<p v-if="step == 2">Un pequeño paso para ti, un gran paso para la comunidad.</p>
				<p v-if="step == 3">¡A un paso de ser parte de la comunidad!</p>
				<p v-if="step == 4">¡Wow, lo lograste! Muy pronto tu espacio estará online para que puedas compartirlo a nuestra comunidad.</p>
				<p v-if="step == 4">Re-imagina tu encuentro</p>
			</div>
		</div>
		</div>
	</div>
</template>
<script>
	export default {
		props: [
			'step',
			'espacioId',
			'enviarValidacion'
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
                if(this.$auth.isAuthenticated()) {
                    this.user = this.$auth.getUser();
                }else {
                	location.href = `/`;
                }
            },
            enviarAprobacion(e, id) {
            	e.preventDefault();
            	this.$http.get(`api/enviaraprobacion/${id}`)
                .then(res => {
                    window.location.href = `/dashboard/user/${this.user.id}/misespacios`;
                }, err => {
                    this.btnSend = true;
                    swal(err.message);
                });
            }
		}
	}
</script>