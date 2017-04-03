@extends('layouts.app')

@section('title', 'Agregar precios')

@push('scripts')
	<script>
		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
		  acc[i].onclick = function() {
		    this.classList.toggle("active");
		    var panel = this.nextElementSibling;
		    if (panel.style.maxHeight){
		      panel.style.maxHeight = null;
		    } else {
		      panel.style.maxHeight = panel.scrollHeight + "px";
		    } 
		  }
		}
	</script>
@endpush

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
			</div>
		</div>

		<div class="container-center">
			@include('errors/error-notification')
			<h2>¿Qué precio tiene tu espacio por hora?</h2>
			<div class="row wt-m-top-4">
				@foreach($prices as $price)
				<div class="col-md-3">
					<div class="card-category">
						<div class="card-category-header">
							<i class="fa fa-users fa-4x" aria-hidden="true"></i>
							<h3>{{$price->name}}</h3>
						</div>
						<div class="card-category-body">
							{!! Form::open(array('url' => 'saveprice', 'method' => 'POST')) !!}
								<input type="hidden" name="priceId" value="{{$price->id}}">
								<input type="hidden" name="espacio_id" value="{{$price->espacio_id}}">
								<input type="hidden" name="categoria_id" value="{{$price->categoria_id}}">
								<input type="hidden" name="status" value="1">
								@if($price->price > 0)
								<input type="text" name="price" value="{{ $price->price }}" placeholder="Precio por hora" />
								@else
								<input type="text" name="price" placeholder="Precio por hora" />
								@endif
								@if($price->price > 0)
								<input type="text" name="minhours" value="{{ $price->minhours }}" placeholder="Mínimo de horas" />
								@else
								<input type="text" name="minhours" placeholder="Mínimo de horas" />
								@endif
								<input type="submit" value="Guardar" />
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>

		<div class="buttons" id="second-buttons">
			<a href="{{ url()->previous() }}" class="btn">ATRÁS</a>
			<a class="btn wt-btn-primary" href="{{route('publica-steps', array('espacioId' => $espacio->id, 'step' => 4))}}">CONTINUAR</a>
		</div>
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection