@extends('layouts.notfix')

@section('title', 'Agregar reglas')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
		</div>
	</div>
	<div class="container-left">
		{!! Form::open(array('url' => 'savereglas', 'method' => 'POST')) !!}
		<div class="container-center">
			<h2>Establece reglas sobre el espacio</h2>
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
			<a href="{{ url()->previous() }}" class="btn">ATRÁS</a>
			<input class="btn wt-btn-primary" type="submit" value="CONTINUAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<div class="container-right__dialog-box">
			<div>
				<p>Las reglas delimitan lo que se puede hacer o no en tu espacio. Tomate un momento para dejar bien en claro lo que se puede hacer y lo que no.</p>
			</div>
		</div>
	</div>
</section>
@endsection