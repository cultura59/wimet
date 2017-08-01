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
				<p>Comprender en que días y horarios estará disponible tu espacio, permite que las solicitudes de alquiler no se superpongan con tus propias actividades/ agenda.</p>
				<p>Registra cada día en orden y desde el horario inicial que tu espacio estaría disponible en ese día hasta en que horario la actividad podría terminar.</p>
				<p>Ejemplo:</p>
				<p>Viernes de 9AM a 5AM</p>
			</div>
		</div>
	</div>
</section>
@endsection