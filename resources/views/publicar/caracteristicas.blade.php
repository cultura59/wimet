@extends('layouts.notfix')

@section('title', 'Agregar caracteristicas')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
		</div>
	</div>
	<div class="container-left">
		<navbar-segundo espacio-id="{{$espacio->id}}" url="caracteristicas"></navbar-segundo>
		{!! Form::open(array('url' => 'savecaracteristicas', 'method' => 'POST')) !!}
		<div class="container-center">
			<h3>¿Qué características especiales tiene tu espacio?</h3>
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
			<a href="{{ url('/publicar/segundo-paso/espacio/'.$espacio->id.'/images') }}" class="btn-volver">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
				<span>ATRÁS</span>
			</a>
			<input class="btn-primary-pig" type="submit" value="GUARDAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<div class="container-right__dialog-box">
			<div>
				<p>Las actividades definen las posibilidades de experiencias que permite tu espacio. Cada público tiene necesidades distintas. Ten tu espacio listo para cada potencial encuentro.</p>
			</div>
		</div>
	</div>
</section>
@endsection