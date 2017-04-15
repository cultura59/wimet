<template>
	<div>
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<h2>Resumen de reserva</h2><hr>
					<p>Wimet te permite ganar dinero alguilando tu espacio disponible. Completa los siguientes datos.
					Wimet te recuerda que la publicación está sujecta a aprobación.</p>

					<div class="row wt-m-top-3">
						<div class="col-sm-5">
							<strong>¿Cuántos invitados tienes?</strong>
							<div class="box-cantidad-invitados">
								<input type="text" class="wt-input" name="cantidad-invitados" placeholder="Cantidad personas" v-model="people">
								<i class="fa fa-users fa-2x" aria-hidden="true"></i>
							</div>
						</div>
						<div class="col-sm-7">
							<div class="wt-center-center">
								<p>Todos ellos contarán con la cobertura de Responsabilidad Civil gracias a un acuerdo exclusivo con</p>
								<img src="/img/AIG_logo.png" alt="AIG" height="40">
							</div>
						</div>
					</div>

					<div class="wt-m-top-3 wt-m-bot-3">
						<strong>Envíale un mensaje al propietario</strong>
						<div class="row wt-m-top-1 wt-m-bot-2">
							<div class="col-sm-2">
								<img class="img-circle img-responsive center-block" src="http://m.alo.co/sites/default/files/imagecache/Main_Galeria_Vertical_433_570/jason-statham-2012-2.jpg" alt="Jason Statham"  width="200" height="200">
							</div>
							<div class="col-sm-10">
								<p>Cuentale al propietario quién eres y para qué utilizarás el lugar. Ser detallista te permitirá tener una confirmacion inmediata para alquilar el espacio. Seguramente sean la misma información que querrías saber si se tratara de tu espacio.</p>
							</div>
						</div>
						<textarea name="consulta" cols="30" rows="10" placeholder="Cuentale lo mejor que puedas, sobre el evento que quieres realizar al dueño del espacio." class="wt-m-bot-3 wt-textarea" v-model="mensaje"></textarea>
						<button class="btn wt-btn-primary" @click="sendReserva()">Solicitar la reserva</button>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="resumen">
						<h2>Resumen</h2>
						<img class="img-responsive" src="http://mla-s2-p.mlstatic.com/salon-de-fiesta-avellaneda-centro-gba-zona-sur--5325-MLA4368913831_052013-F.jpg" alt="salon 1">
						<p class="wt-m-top-2 reserva__title">LOFT CANCHERO EN SOHO</p>
						<p class="wt-m-top-2 reserva__title">FECHA Y HORARIOS</p>
						<p v-for="item in totalFechas">
							{{item.fecha}} desde {{item.inicio}}hs hasta {{item.fin}}hs.
						</p>
						<div class="box-reserva__totales">
							<p class="wt-m-top-2 reserva__title">PRECIO</p>
							<div class="wt-space-block">
								<span>${{price}} X {{totalHoras}}hs</span>
								<span>${{subTotal}}.-</span>
							</div>
							<div class="wt-space-block">
								<span>Fee de administración (5%)</span>
								<span>${{fee}}.-</span>
							</div>
							<hr>
							<div class="wt-space-block">
								<strong>Total</strong>
								<strong>{{total}}.-</strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- The Modal -->
		<div id="reservaModal" class="wt-modal" v-if="showModal">
			<!-- Modal content -->
			<div class="modal-content">
				<span class="close" @click="closeModal()">&times;</span>
				<img src="/img/wimet_isologotipo.svg" alt="Wimet" class="img-responsive center-block" width="50%">
				<p class="text-center">Tu solicitud de reserva ha sido enviada.</p>
				<p class="text-center">El propietario tiene 48 horas para responder.</p>
				<p class="text-center">Recuerda que por disponibilidad, o tipo de actividad la reserva puede ser confirmada o rechazada.</p>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		props: [
			'clientId'
		],
		data() {
			return {
				showModal: false,
				espacioId: '',
				price: '',
				people: '',
				category: '',
				mensaje: '',
				totalFechas: '',
				totalHoras: '',
				fee: '',
				subTotal: '',
				total: ''
			}
		},
		mounted() {
			this.getAllInfo();
		},
		methods: {
			getAllInfo() {
				this.espacioId = sessionStorage.getItem('espacioId');
				this.price = sessionStorage.getItem('price');
    			this.people = sessionStorage.getItem('people');
    			this.category = sessionStorage.getItem('category');
    			this.totalFechas = JSON.parse(sessionStorage.getItem('totalFechas'));
    			this.totalHoras = sessionStorage.getItem('totalHoras');
    			this.fee = sessionStorage.getItem('fee');
    			this.subTotal = sessionStorage.getItem('subTotal');
    			this.total = sessionStorage.getItem('total');
			},
			sendReserva() {
				let body = {
					'clientId': this.clientId,
					'espacioId': this.espacioId,
					'price': this.price,
					'totalFechas': this.totalFechas,
					'totalHoras': this.totalHoras,
					'mensaje': this.mensaje,
					'fee': this.fee,
					'subTotal': this.subTotal,
					'total': this.total

				}
				this.$http.post(`/api/sendreserva`, body)
                .then(res => {
                	this.showModal = true;
                }, err => {
                    console.log(err);
                });
			},
			closeModal() {
				this.showModal = false;
			}
		}
	}
</script>