@extends('layouts.app')

@section('title', 'Publicar categorias')

@push('scripts')
	<script>
		function incrementInput(nameInput) {
		    var value = parseInt(document.getElementById(nameInput).value, 10);
		    value = isNaN(value) ? 0 : value;
		    value++;
		    document.getElementById(nameInput).value = value;
		}
		function decrencrementInput(nameInput) {
			var value = parseInt(document.getElementById(nameInput).value, 10);
		    value = isNaN(value) ? 0 : value;
		    value--;
		    document.getElementById(nameInput).value = value;
		}
	</script>
@endpush

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		{!! Form::open(array('url' => 'saveaccess', 'method' => 'POST')) !!}
		<input type="hidden" name="id" value="{{$id}}">
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
			</div>
		</div>

		<div class="container-center">
			<div class="detalles-espacios">
				<h2>Detalles del espacio y accesibilidad</h2>
				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" id="quantyrooms" name="quantyrooms" value="0">
						<span class="box-publica__container__pointer" onclick="incrementInput('quantyrooms')">+</span>
						<span class="box-publica__container__pointer" onclick="decrencrementInput('quantyrooms')">-</span>
						<span class="box-publica__container__name">Ambientes</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
					</div>
				</div>
				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" id="quantybathrooms" name="quantybathrooms" value="0">
						<span class="box-publica__container__pointer" onclick="incrementInput('quantybathrooms')">+</span>
						<span class="box-publica__container__pointer" onclick="decrencrementInput('quantybathrooms')">-</span>
						<span class="box-publica__container__name">Baños</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
					</div>
				</div>
				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" id="floor" name="floor" value="0">
						<span class="box-publica__container__pointer" onclick="incrementInput('floor')">+</span>
						<span class="box-publica__container__pointer" onclick="decrencrementInput('floor')">-</span>
						<span class="box-publica__container__name">Piso</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
					</div>
				</div>
				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" id="surface" name="surface" value="0">
						<span class="box-publica__container__pointer" onclick="incrementInput('surface')">+</span>
						<span class="box-publica__container__pointer" onclick="decrencrementInput('surface')">-</span>
						<span class="box-publica__container__name">Superficie</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
					</div>
				</div>
			</div>
			<div class="detalles-accesos wt-m-bot-5">
				<h2>¿Cómo se accede al lugar?</h2>
				<div class="row wt-m-top-3">
					@foreach($access as $as)
					<div class="col-xs-6">
						<input 
							type="checkbox" 
							id="id-access-{{$as->id}}" 
							name="access[]" 
							value="{{$as->id}}" 
							style="display: none;">
						<label for="id-access-{{$as->id}}" class="wt-publica-label">{{$as->nombre}}.</label>
					</div>
					@endforeach
				</div>
			</div>
		</div>

		<div class="buttons" id="second-buttons">
			<a href="{{ url()->previous() }}" class="btn">ATRÁS</a>
			<input class="btn wt-btn-primary" type="submit" value="CONTINUAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection