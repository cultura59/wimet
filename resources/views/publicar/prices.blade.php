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
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 66%">
		</div>
	</div>
	<div class="container-left">

		<publica-price espacio-id="{{$espacio->id}}" prices="{{$prices}}"></publica-price>

	</div>
	<div class="container-right">
		<div class="container-right__dialog-box">
			<div class="wt-m-bot-4">
				<i class="fa fa-usd fa-3x" aria-hidden="true"></i>
			</div>
			<div>
				<p>El precio es fundamental para poder filtrar a los potenciales organizadores. Por favor, incluye el valor estimado que consideres para alquilar tu espacio. Toma en cuenta que el espacio se mide por hora y con un mínimo de horas que representen la rentabilidad que esperas recibir.
Sólo números, sin comas ni puntos.
Ahh si! guarda uno por vez ;)</p>
			</div>
		</div>
	</div>
</section>
@endsection