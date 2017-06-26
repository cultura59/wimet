@extends('layouts.notfix')

@section('title', 'Publicar categorias')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		</div>
	</div>
	<div class="container-left">
		<navbar-primero espacio-id="{{$espacio->id}}" url="categorias"></navbar-primero>
		{!! Form::open(array('url' => 'savecategories', 'method' => 'POST')) !!}
		<input type="hidden" name="id" value="{{$espacio->id}}">
		<div class="container-center">
			@include('errors/error-notification')
			<h3>¿Qué tipo de actividad se puede a cabo en tu espacio?</h3>
			<div class="container-center__list">
				@foreach($categorias as $categoria)
				<!-- Item -->
				<div class="container-center__list__item">
					<div class="left__item">
						<span>
							{{ Form::checkbox(
								'categorias[]', 
								$categoria->id, 
								$espacio->categorias->contains('id', $categoria->id), 
								array('id' => 'categoria_' . $categoria->id, 'style' => 'display:none')) 
							}}
							<label for="categoria_{{$categoria->id}}" class="wt-publica-label">{{$categoria->name}}</label>
						</span>
						<span class="item-description">(
							@foreach($categoria->subCategory as $cat)
							{{$cat->name}},
							@endforeach
						)</span>
					</div>
				</div>
				@endforeach
			</div>
		</div>

		<div class="buttons" id="second-buttons">
			<a href="{{ url('/publicar/espacio/'.$espacio->id) }}" class="btn-volver">
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
				<p>Las actividades definen las posibilidades de experiencias que permite tu espacio. Cada público tiene necesidades distintas. Ten tu espacio listo para cada potencial encuentro.</p>
			</div>
		</div>
	</div>
</section>
@endsection