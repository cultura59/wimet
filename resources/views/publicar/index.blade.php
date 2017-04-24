@extends('layouts.notfix')

@section('title', 'Publicar')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
		</div>
	</div>
	<div class="container-left">
		{!! Form::open(array('url' => 'saveEspaciowithoutdata', 'method' => 'POST')) !!}
		<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
		<input type="hidden" name="name" value="{{Auth::user()->id}}_{{date('d-m-y')}}">
		<input type="hidden" name="description" value="">

		<div class="container-center">
			<div id="first-step">
				<h2>¡Hola {{Auth::user()->firstname}}! Estas a pasos de</h2>
				<h2>ser anfitrión de tu espacio ;)</h2>
				<div class="wt-m-top-3 wt-m-bot-3">
					<span class="title-paso">PASO 1: DATOS BÁSICOS (descripción del lugar)</span>
				</div>

				<div class="wt-m-top-3 wt-m-bot-3">
					<h3>¿Qué estilo de espacio tienes?</h3>
					{!! Form::select('estilos[]', $estilos, null, array('class' => 'select-publica', 'placeholder' => 'Seleccionar', 'required'=> 'required')) !!}
				</div>
				<h4>¿Qué tipo de espacio es?</h4>
				<ul class="tipo-espacio">
					<li class="typespace">
						<input type="radio" id="comercial" name="type" value="comercial" required style="display: none;">
						<label for="comercial" class="wt-publica-first-label">Comercial</label>
					</li>
					<li class="typespace">
						<input type="radio" id="privado" name="type" value="privado" required style="display: none;">
						<label for="privado" class="wt-publica-first-label">Privado</label>
					</li>
				</ul>
			</div>
		</div>

		<div class="buttons">
			<button class="btn" onclick="showNextStep(0)">ATRÁS</button>
			<input class="btn wt-btn-primary" type="submit" value="CONTINUAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection