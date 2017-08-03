@extends('layouts.notfix')

@section('title', 'Publicar invitados')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
		</div>
	</div>
	<div class="container-left">
		<navbar-primero espacio-id="{{$espacio->id}}" url="invitados"></navbar-primero>
		{!! Form::open(array('url' => 'saveinvitados', 'method' => 'POST')) !!}
		<input type="hidden" name="id" value="{{$espacio->id}}">

		<div class="container-center">
			<div class="detalles-espacios">
				<h3>¿Qué capacidad de asistentes / invitados tiene tu espacio?</h3>
				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" name="quanty" value="{{$espacio->quanty}}" placeholder="0">
						<span class="box-publica__container__name">Máximo de asistentes</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
					</div>
				</div>

				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" name="foot" value="{{$espacio->foot}}" placeholder="0">
						<span class="box-publica__container__name">De pie (opcional)</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(Actividad informal tipo cocktail)</span>
					</div>
				</div>

				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" name="seated" value="{{$espacio->seated}}" placeholder="0">
						<span class="box-publica__container__name">Sentados (opcional)</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(Actividad formal con mesas y/o sillas)</span>
					</div>
				</div>
			</div>
		</div>

		<div class="buttons" id="second-buttons">
			<a href="{{ url('/publicar/primer-paso/espacio/'.$espacio->id.'/detalles') }}" class="btn-volver">
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
				<p>La capacidad de carga que incluyas determinará la cantidad de invitados que pueden alojarse cómodamente en tu espacio.</p>
			</div>
		</div>
	</div>
</section>
@endsection