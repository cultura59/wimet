@extends('layouts.notfix')

@section('title', 'Publicar categorias')

@push('scripts')
	<script>
		function incrementInput(nameInput, e) {
			event.preventDefault();
		    var value = parseInt(document.getElementById(nameInput).value, 10);
		    value = isNaN(value) ? 0 : value;
		    value++;
		    document.getElementById(nameInput).value = value;
		}
		function decrencrementInput(nameInput, e) {
			event.preventDefault();
			var value = parseInt(document.getElementById(nameInput).value, 10);
		    value = isNaN(value) ? 0 : value;
		    value--;
		    document.getElementById(nameInput).value = value;
		}
	</script>
@endpush

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
		</div>
	</div>
	<div class="container-left">
		<navbar-primero espacio-id="{{$espacio->id}}" url="detalles"></navbar-primero>
		{!! Form::open(array('url' => 'saveaccess', 'method' => 'POST')) !!}
		<input type="hidden" name="id" value="{{$espacio->id}}">

		<div class="container-center">
			<div class="detalles-espacios">
				<h3>Detalles del espacio y accesibilidad</h3>
				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" id="quantyrooms" name="quantyrooms" value="{{$espacio->quantyrooms}}">
						<button class="box-publica__container__pointer-center" onclick="incrementInput('quantyrooms')">+</button>
						<button class="box-publica__container__pointer" onclick="decrencrementInput('quantyrooms')">-</button>
						<span class="box-publica__container__name">Ambientes</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(sólo los disponibles para el uso de invitados).</span>
					</div>
				</div>
				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" id="quantybathrooms" name="quantybathrooms" value="{{$espacio->quantybathrooms}}">
						<button class="box-publica__container__pointer-center" onclick="incrementInput('quantybathrooms')">+</button>
						<button class="box-publica__container__pointer" onclick="decrencrementInput('quantybathrooms')">-</button>
						<span class="box-publica__container__name">Baños</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(sólo los disponibles para el uso de invitados).</span>
					</div>
				</div>
				<div class="box-publica" style="display: none;">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" id="floor" name="floor" value="0">
						<button class="box-publica__container__pointer-center" onclick="incrementInput('floor')">+</button>
						<button class="box-publica__container__pointer" onclick="decrencrementInput('floor')">-</button>
						<span class="box-publica__container__name">Piso</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(sólo los disponibles para el uso de invitados).</span>
					</div>
				</div>
				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" id="surface" name="surface" value="{{$espacio->surface}}">
						<button class="box-publica__container__pointer-center" onclick="incrementInput('surface')">+</button>
						<button class="box-publica__container__pointer" onclick="decrencrementInput('surface')">-</button>
						<span class="box-publica__container__name">Superficie</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(sólo los disponibles para el uso de invitados).</span>
					</div>
				</div>
			</div>
			<div class="detalles-accesos wt-m-bot-5">
				<h3>¿Cómo se accede al lugar?</h3>
				<div class="row wt-m-top-3">
					@foreach($access as $as)
					<div class="col-xs-6">
						{{ Form::checkbox(
							'access[]', 
							$as->id, 
							$espacio->access->contains('id', $as->id), 
							array('id' => 'id-access-' . $as->id, 'style' => 'display: none;')) 
						}}
						<label for="id-access-{{$as->id}}" class="wt-publica-label">{{$as->nombre}}.</label>
					</div>
					@endforeach
				</div>
			</div>
		</div>

		<div class="buttons" id="second-buttons">
			<a href="{{ url('/publicar/primer-paso/espacio/'.$espacio->id.'/categorias') }}" class="btn-volver">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
				<span>ATRÁS</span>
			</a>
			<input class="btn-primary-pig" type="submit" value="CONTINUAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<div class="container-right__dialog-box">
			<div>
				<p>Cada organizador debe saber con que cuenta para poder ir imaginando su evento. Estos recursos ayudan a comprender como está organizado tu espacio. El ingreso es el comienzo de la experiencia y fundamental para comenzarla con el pie derecho.</p>
			</div>
		</div>
	</div>
</section>
@endsection