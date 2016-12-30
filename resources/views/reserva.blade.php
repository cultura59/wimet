@extends('layouts.app')

@section('title', 'reserva')

@push('scripts')
<script>
	// Get the modal
	var modal = document.getElementById('reservaModal');

	// Get the button that opens the modal
	var btn = document.getElementById("reservaBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
	    modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	    modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	    if (event.target == modal) {
	        modal.style.display = "none";
	    }
	}
</script>
@endpush

@section('content')
<section class="reserva wt-m-3">
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
							<input type="text" class="wt-input" name="cantidad-invitados" placeholder="Cantidad personas">
							<i class="fa fa-users fa-2x" aria-hidden="true"></i>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="wt-center-center">
							<p>Todos ellos contarán con la cobertura de Responsabilidad Civil gracias a un acuerdo exclusivo con</p>
							<img src="{{url('/img/AIG_logo.png')}}" alt="AIG" height="40">
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
					<textarea name="consulta" cols="30" rows="10" placeholder="Cuentale lo mejor que puedas, sobre el evento que quieres realizar al dueño del espacio." class="wt-m-bot-3 wt-textarea"></textarea>
					<a href="#" id="reservaBtn" class="wt-btn-principal">Solicitar la reserva</a>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="resumen">
					<h2>Resumen</h2>
					<img class="img-responsive" src="http://mla-s2-p.mlstatic.com/salon-de-fiesta-avellaneda-centro-gba-zona-sur--5325-MLA4368913831_052013-F.jpg" alt="salon 1">
					<p class="wt-m-top-2 reserva__title">LOFT CANCHERO EN SOHO</p>
					<p class="wt-m-top-2 reserva__title">FECHA Y HORARIOS</p>
					<p>21 de Octubre de 2016, de 9:30 a 20:30 hs.</p>
					<div class="box-reserva__totales">
						<p class="wt-m-top-2 reserva__title">PRECIO</p>
						<div class="wt-space-block">
							<span>$143 X 11hs</span>
							<span>$1573.-</span>
						</div>
						<div class="wt-space-block">
							<span>Fee de administración (5%)</span>
							<span>$78,65.-</span>
						</div>
						<hr>
						<div class="wt-space-block">
							<strong>Total</strong>
							<strong>$1651,65.-</strong>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- The Modal -->
	<div id="reservaModal" class="modal">
		<!-- Modal content -->
		<div class="modal-content">
			<span class="close">&times;</span>
			<img src="{{ url('/img/wimet_isologotipo.svg') }}" alt="Wimet" class="img-responsive center-block" width="50%">
			<p class="text-center">Tu solicitud de reserva ha sido enviada.</p>
			<p class="text-center">El propietario tiene 48 horas para responder.</p>
			<p class="text-center">Recuerda que por disponibilidad, o tipo de actividad la reserva puede ser confirmada o rechazada.</p>
		</div>
	</div>
</section>
@endsection