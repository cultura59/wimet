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
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
			</div>
		</div>

		<div class="container-center">
			<h2>¿Qué precio tiene tu espacio por hora?</h2>
			@foreach($espacio->categorias as $cat)
				<div class="wt-m-top-4">
					<button class="accordion">{{$cat->name}}</button>
					<div class="panel">
						{!! Form::open(array('url' => 'saveprice', 'method' => 'POST', 'class' => 'wt-m-top-2 wt-m-bot-2')) !!}
							<input type="hidden" name="espacio_id" value="{{$espacio->id}}">
							<input type="hidden" name="categoria_id" value="{{$cat->id}}">
							<label for="price" class="text-bold">Precio del espacio por hora</label><br>
							<input type="text" id="price" name="price" class="wt-input" placeholder="Ingrese precio por hora">
							<input type="text" id="minhours" name="minhours" class="wt-input" placeholder="Ingrese mínimo horas">
							<input type="submit" value="Guardar" class="btn wt-btn-primary"/>
						{!! Form::close() !!}
					</div>
				</div>
			@endforeach
		</div>

		<div class="buttons" id="second-buttons">
			<a href="{{ url()->previous() }}" class="btn">ATRÁS</a>
			<a class="btn wt-btn-primary" href="{{route('publica-rules', array('id' => $espacio->id))}}">CONTINUAR</a>
		</div>
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection