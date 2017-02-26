@extends('layouts.app')

@section('title', 'Agregar amenities')

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		{!! Form::open(array('url' => 'saveamenities', 'method' => 'POST')) !!}
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
			</div>
		</div>

		<div class="container-center">
			<h2>¿Con qué amenities cuenta tu espacio?</h2>
			<div class="row wt-m-top-4">
				<input type="hidden" name="id" value="{{$id}}">
				@foreach($amenities as $amenity)
				<div class="col-xs-6">
					<input 
						type="checkbox" 
						id="amenity-{{$amenity->id}}" 
						name="servicios[]"
						value="{{$amenity->id}}"
						style="display: none;">
					<label for="amenity-{{$amenity->id}}" class="wt-publica-label">{{$amenity->nombre}}</label>
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