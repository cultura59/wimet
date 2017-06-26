@extends('layouts.notfix')

@section('title', 'Publicar')

@push('scripts')
	<script>
		function incrementInput(nameInput, e) {
			event.preventDefault();
		    var value = parseInt(document.getElementById(nameInput).value, 10);
		    value = isNaN(value) ? 0 : value;
		    value++;
		    document.getElementById(nameInput).value = value;
		}
		function decrencrementInput(nameInput, e) {
			event.preventDefault();
			var value = parseInt(document.getElementById(nameInput).value, 10);
		    value = isNaN(value) ? 0 : value;
		    value--;
		    document.getElementById(nameInput).value = value;
		}
	</script>
@endpush

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		</div>
	</div>
	<div class="container-left">
		<navbar-tercero espacio-id="{{$espacio->id}}" url="cancelacion"></navbar-tercero>
		{!! Form::open(array('url' => 'savecancelacion', 'method' => 'POST')) !!}
		<input type="hidden" name="id" value="{{$espacio->id}}">
		<div class="container-center">
			<div id="first-step">
				<div class="wt-m-top-3 wt-m-bot-3">
					<h3>Política de cancelación</h3>
					<div class="container-center__list">
						<!-- Item -->
						<div class="container-center__list__item">
							<div class="left__item">
								<span>
									<input type="radio" id="flexible" name="cancellationflexibility" value="flexible" required style="display: none;" @if($espacio->cancellationflexibility== 'flexible') checked @endif>
									<label for="flexible" class="wt-publica-label">Flexible</label>
								</span>
								<span class="item-description">(Reembolso completo hasta 15 días antes del evento, excepto los gastos de procesamiento).</span>
							</div>
						</div>
						<!-- Item -->
						<div class="container-center__list__item">
							<div class="left__item">
								<span>
									<input type="radio" id="moderado" name="cancellationflexibility" value="moderado" required style="display: none;" @if($espacio->cancellationflexibility== 'moderado') checked @endif>
									<label for="moderado" class="wt-publica-label">Moderado</label>
								</span>
								<span class="item-description">(Reembolso completo hasta 30 días antes del evento, excepto los gastos de procesamiento).</span>
							</div>
						</div>
						<!-- Item -->
						<div class="container-center__list__item">
							<div class="left__item">
								<span>
									<input type="radio" id="estricto" name="cancellationflexibility" value="estricto" required style="display: none;" @if($espacio->cancellationflexibility== 'estricto') checked @endif>
									<label for="estricto" class="wt-publica-label">Estricto</label>
								</span>
								<span class="item-description">(50% de reembolso hasta 30 días antes del evento, excepto gastos de procesamiento).</span>
							</div>
						</div>
					</div>
				</div>
				<div class="wt-m-top-3 wt-m-bot-3">
					<h4>Deposito de garantía</h4>
					<div class="box-publica">
						<div class="box-publica__container">
							<input class="box-publica__container__input" type="text" id="securitydeposit" name="securitydeposit" value="{{$espacio->securitydeposit}}" placeholder="$0.-">
							<button class="box-publica__container__pointer-center" onclick="incrementInput('securitydeposit')">+</button>
							<button class="box-publica__container__pointer" onclick="decrencrementInput('securitydeposit')">-</button>
							<span class="box-publica__container__name">Ambientes</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="buttons">
			<a href="{{ url()->previous() }}" class="btn-volver">
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
				<p>Para tu tranquilidad, es importante que definas que tipo de política de pagos recibirás y si quieres un depósito de garantía.</p>
				<ul>
					<li>Flexible: Reembolso completo hasta 5 días antes del evento, excepto los gastos de procesamiento.</li>
					<li>Moderada: Reembolso completo hasta 10 días antes del evento, excepto los gastos de procesamiento.</li>
					<li>Estricta: 50% de reembolso hasta 10 días antes del evento, excepto gastos de procesamiento.</li>
				</ul>
			</div>
		</div>
	</div>
</section>
@endsection