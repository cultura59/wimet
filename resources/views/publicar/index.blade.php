@extends('layouts.app')

@section('title', 'Publicar')

@push('scripts')
	<script>
		function showNextStep(progressbar) {
			if(progressbar == 1)
			{
				document.getElementById("progress").style.width = "10%";
			}else {
				document.getElementById("progress").style.width = "0%";
			}
			var firstStep 		= document.getElementById("first-step");
			var firstButtons 	= document.getElementById("first-buttons");
			var secondStep 		= document.getElementById("second-step");
			var secondButtons 	= document.getElementById("second-buttons");

			firstStep.style.display 	= firstStep.style.display === 'none' ? '' : 'none';
			firstButtons.style.display 	= firstButtons.style.display === 'none' ? '' : 'none';
			secondStep.style.display 	= secondStep.style.display === 'none' ? '' : 'none';
			secondButtons.style.display = secondButtons.style.display === 'none' ? '' : 'none';
		}
	</script>
@endpush

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		{!! Form::open(array('url' => 'saveespacio', 'method' => 'POST')) !!}
		<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
			</div>
		</div>

		<div class="container-center">
			<div id="first-step">
				<h2>¡Hola Adrián! Estas a pasos de</h2>
				<h2>ser anfitrión de tu espacio ;)</h2>
				<div class="wt-m-top-3 wt-m-bot-3">
					<span class="title-paso">PASO 1: DATOS BÁSICOS (descripción del lugar)</span>
				</div>

				<div class="wt-m-top-3 wt-m-bot-3">
					<h3>¿Qué estilo de espacio tienes?</h3>
					{!! Form::select('estilos', $estilos, null, array('class' => 'select-publica', 'placeholder' => 'Seleccionar', 'required'=> 'required')) !!}
				</div>
				<h4>¿Qué tipo de espacio es?</h4>
				<ul class="tipo-espacio">
					<li>
						<input type="radio" id="comercial" name="type" value="comercial" required style="display: none;">
						<label for="comercial" class="wt-publica-label">Comercial</label>
					</li>
					<li>
						<input type="radio" id="privado" name="type" value="privado" required style="display: none;">
						<label for="privado" class="wt-publica-label">Privado</label>
					</li>
				</ul>
			</div>
			<div id="second-step" style="display: none;">
				<h2>¡Cuéntale al mundo acerca de tu espacio!</h2>
				<div class="wt-m-top-4">
					<p class="text-bold">Título de tu espacio</p>
					<input type="text" class="wt-custom-input" name="name" placeholder="Ingrese el titulo de su espacio" required>
					<p>50 caracteres</p>
				</div>
				<div class="wt-m-top-4">
					<label class="text-bold">Descripción</label>
					<textarea name="description" name="description" rows="10" class="wt-textarea" placeholder="Escriba una breve descripción de su espacio, que lo caracteriza y cuales son sus mejores aspectos.">
					</textarea required>
				</div>
			</div>
		</div>

		<div class="buttons" id="first-buttons">
			<a href="{{ url()->previous() }}" class="btn">ATRÁS</a>
			<button class="btn wt-btn-primary" onclick="showNextStep(1)">CONTINUAR</button>
		</div>

		<div class="buttons" id="second-buttons" style="display: none;">
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