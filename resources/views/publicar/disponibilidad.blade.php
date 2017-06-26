@extends('layouts.notfix')

@section('title', 'Disponibilidad')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
		</div>
	</div>
	<div class="container-left">
		<navbar-tercero espacio-id="{{$espacio->id}}" url="disponibilidad"></navbar-tercero>
		<publica-disponibilidad espacio-id="{{$espacio->id}}"></publica-disponibilidad>
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