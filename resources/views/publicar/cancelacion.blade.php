@extends('layouts.notfix')

@section('title', 'Publicar')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		</div>
	</div>
	<div class="container-left">
		{!! Form::open(array('url' => 'savecancelacion', 'method' => 'POST')) !!}
		<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
		<input type="hidden" name="id" value="{{$espacio->id}}">
		<div class="container-center">
			<div id="first-step">
				<div class="wt-m-top-3 wt-m-bot-3">
					<h2>¿Cuál es el depósito de garantía?</h2>
					<input type="text" name="securitydeposit" class="input-publica" placeholder="Ingrese un valor de depósito" value="{{$espacio->securitydeposit}}">
				</div>
				<div class="wt-m-top-3 wt-m-bot-3">
					<h3>¿Qué tipo de política de cancelación tienes?</h3>
					<ul class="tipo-espacio">
						<li class="typespace">
							<input type="radio" id="flexible" name="cancellationflexibility" value="flexible" required style="display: none;" @if($espacio->cancellationflexibility== 'flexible') checked @endif>
							<label for="flexible" class="wt-publica-first-label">Flexible</label>
						</li>
						<li class="typespace">
							<input type="radio" id="moderado" name="cancellationflexibility" value="moderado" required style="display: none;" @if($espacio->cancellationflexibility== 'moderado') checked @endif>
							<label for="moderado" class="wt-publica-first-label">Moderado</label>
						</li>
						<li class="typespace">
							<input type="radio" id="estricto" name="cancellationflexibility" value="estricto" required style="display: none;" @if($espacio->cancellationflexibility== 'estricto') checked @endif>
							<label for="estricto" class="wt-publica-first-label">Estricto</label>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="buttons">
			<button class="btn" onclick="showNextStep(0)">ATRÁS</button>
			<input class="btn wt-btn-primary" type="submit" value="CONTINUAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection