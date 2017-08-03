@extends('layouts.notfix')

@section('title', 'Agregar reglas')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 25%%">
		</div>
	</div>
	<div class="container-left">
		<navbar-tercero espacio-id="{{$espacio->id}}" url="reglas"></navbar-tercero>
		{!! Form::open(array('url' => 'savereglas', 'method' => 'POST')) !!}
		<div class="container-center">
			<h3>Establece las reglas sobre el espacio</h3>
			<div class="row wt-m-top-4">
				<input type="hidden" name="id" value="{{$espacio->id}}">
				@foreach($reglas as $regla)
				<div class="col-xs-6">
					{{ Form::checkbox(
						'rules[]', 
						$regla->id, 
						$espacio->rules->contains('id', $regla->id), 
						array('id' => 'regla-' . $regla->id, 'style' => 'display: none;')) 
					}}
					<label for="regla-{{$regla->id}}" class="wt-publica-label">{{$regla->nombre}}</label>
				</div>
				@endforeach
			</div>
		</div>

		<div class="buttons" id="second-buttons">
			<a href="{{ url('/publicar/espacio/'.$espacio->id) }}" class="btn-volver">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
				<span>ATRÁS</span>
			</a>
			<input class="btn-primary-pig" type="submit" value="GUARDAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<div class="container-right__dialog-box">
			<img class="img-responsive" src="https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-reglas" style="width: 100px; margin-bottom: 50px;">
			<div>
				<p>Las reglas delimitan lo que se puede hacer o no en tu espacio. Tomate un momento para dejar bien en claro lo que se puede hacer y lo que no.</p>
			</div>
		</div>
	</div>
</section>
@endsection