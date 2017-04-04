@extends('layouts.app')

@section('title', 'Agregar caracteristicas')

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		{!! Form::open(array('url' => 'savecaracteristicas', 'method' => 'POST')) !!}
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
			</div>
		</div>

		<div class="container-center">
			<h2>¿Qué características especiales tiene tu espacio?</h2>
			<div class="row wt-m-top-4">
				<input type="hidden" name="id" value="{{$espacio->id}}">
				@foreach($characteristics as $characteristic)
				<div class="col-xs-6">
					{{ Form::checkbox(
						'characteristics[]', 
						$characteristic->id, 
						$espacio->characteristics->contains('id', $characteristic->id), 
						array('id' => 'characteristic-' . $characteristic->id, 'style' => 'display: none;')) 
					}}
					<label for="characteristic-{{$characteristic->id}}" class="wt-publica-label">{{$characteristic->nombre}}</label>
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
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection