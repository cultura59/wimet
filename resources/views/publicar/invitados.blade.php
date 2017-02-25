@extends('layouts.app')

@section('title', 'Publicar invitados')

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		{!! Form::open(array('url' => 'api/espacio', 'method' => 'POST')) !!}
		<input type="hidden" name="id" value="{$id}}">
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
			</div>
		</div>

		<div class="container-center">
			<div class="detalles-espacios">
				<h2>¿Qué capacidad de asistentes / invitados tiene tu espacio?</h2>
				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" name="quanty" value="0">
						<span class="box-publica__container__name">Máximo de asistentes</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
					</div>
				</div>

				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" name="foot" value="0">
						<span class="box-publica__container__name">De pie (Opcional)</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(Actividad informal tipo cocktail, etc)</span>
					</div>
				</div>

				<div class="box-publica">
					<div class="box-publica__container">
						<input class="box-publica__container__input" type="text" name="seated" value="0">
						<span class="box-publica__container__name">Sentados</span>
					</div>
					<div class="box-publica__description">
						<span class="description-text">(Actividad formal con mesas y/o sillas, etc)</span>
					</div>
				</div>
			</div>
		</div>

		<div class="buttons" id="second-buttons">
			<button class="btn" onclick="goBack()">ATRÁS</button>
			<input class="btn wt-btn-primary" type="submit" value="CONTINUAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection