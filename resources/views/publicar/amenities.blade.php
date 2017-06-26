@extends('layouts.notfix')

@section('title', 'Agregar amenities')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
		</div>
	</div>
	<div class="container-left">
		<navbar-segundo espacio-id="{{$espacio->id}}" url="amenities"></navbar-segundo>
		{!! Form::open(array('url' => 'saveamenities', 'method' => 'POST')) !!}
		<div class="container-center">
			<h3>¿Con qué amenities cuenta tu espacio?</h3>
			<div class="row wt-m-top-4">
				<input type="hidden" name="id" value="{{$espacio->id}}">
				@foreach($amenities as $amenity)
				<div class="col-xs-6">
					{{ Form::checkbox(
						'servicios[]', 
						$amenity->id, 
						$espacio->servicios->contains('id', $amenity->id), 
						array('id' => 'amenity-' . $amenity->id, 'style' => 'display: none;')) 
					}}
					<label for="amenity-{{$amenity->id}}" class="wt-publica-label">{{$amenity->nombre}}</label>
				</div>
				@endforeach
			</div>
		</div>
		<div class="buttons" id="second-buttons">
			<a href="{{ url('/publicar/segundo-paso/espacio/'.$espacio->id.'/amenities') }}" class="btn-volver">
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
				<p>Los invitados se sentirán como en casa si les ofreces algunos elementos básicos durante su evento. Algunos anfitriones preparan el espacio para los requerimientos necesarios del organizador. Nada de esto es obligatorio, pero ayuda a dar una experiencia más cálida a los invitados.</p>
			</div>
		</div>
	</div>
</section>
@endsection