@extends('layouts.notfix')

@section('title', 'Agregar precios')

@push('scripts')
	<script>
		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
		  acc[i].onclick = function() {
		    this.classList.toggle("active");
		    var panel = this.nextElementSibling;
		    if (panel.style.maxHeight){
		      panel.style.maxHeight = null;
		    } else {
		      panel.style.maxHeight = panel.scrollHeight + "px";
		    } 
		  }
		}
	</script>
@endpush

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
		</div>
	</div>
	<div class="container-left">
		<navbar-tercero espacio-id="{{$espacio->id}}" url="prices"></navbar-tercero>
		<publica-price espacio-id="{{$espacio->id}}" prices="{{$prices}}"></publica-price>
	</div>
	<div class="container-right">
		<div class="container-right__dialog-box">
			<img class="img-responsive" src="https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-precio" style="width: 100px; margin-bottom: 40px;">
			<div>
				<p>El precio es fundamental para poder filtrar a los potenciales organizadores. Por favor, incluye el valor estimado que consideres para alquilar tu espacio. Toma en cuenta que el espacio se mide por hora y con un mínimo de horas que representen la rentabilidad que esperas recibir. Sólo números, sin comas ni puntos.</p>
				<p>Ahh si! llena uno por vez presionando sobre la actividad elegida.</p>
			</div>
		</div>
	</div>
</section>
@endsection