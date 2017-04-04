@extends('layouts.app')

@section('title', 'Publicar categorias')

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		{!! Form::open(array('url' => 'savecategories', 'method' => 'POST')) !!}
		<input type="hidden" name="id" value="{{$espacio->id}}">
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
			</div>
		</div>

		<div class="container-center">
			@include('errors/error-notification')
			<h2>¿Qué tipo de actividad se puede a cabo en tu espacio?</h2>
			<div class="container-center__list">
				@foreach($categorias as $categoria)
				<!-- Item -->
				<div class="container-center__list__item">
					<div>
						{{ Form::checkbox(
							'categorias[]', 
							$categoria->id, 
							$espacio->categorias->contains('id', $categoria->id), 
							array('id' => 'categoria_' . $categoria->id)) 
						}}
					</div>
					<div class="left__item">
						<span><label for="categoria_{{$categoria->id}}">{{$categoria->name}}</label></span>
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