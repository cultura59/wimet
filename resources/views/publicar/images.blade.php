@extends('layouts.notfix')

@section('title', 'Agregar imagenes')

@push('scripts')
<script>
	$(function() {
	    // Multiple images preview in browser
	    var imagesPreview = function(input, placeToInsertImagePreview) {

	        if (input.files) {
	            var filesAmount = input.files.length;

	            for (i = 0; i < filesAmount; i++) {
	                var reader = new FileReader();

	                reader.onload = function(event) {
	                    $($.parseHTML('<img>'))
	                    .attr('src', event.target.result)
	                    .attr('style', 'width: 25%;height: 150px;')
	                    .appendTo(placeToInsertImagePreview);
	                }

	                reader.readAsDataURL(input.files[i]);
	            }
	        }
	    };

	    $('#imagenes').on('change', function() {
	        imagesPreview(this, '#list-files');
	    });
	});
</script>
@endpush

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
		</div>
	</div>
	<div class="container-left">
		<div class="container-center">
			<publica-image espacio-id="{{$espacio->id}}"></publica-image>
			<list-images espacio-id="{{$espacio->id}}"></list-images>
		</div>

		<div class="buttons" id="second-buttons">
			<a href="{{ url()->previous() }}" class="btn">ATRÁS</a>
			<a href="{{route('publica-caracteristicas', array('id' => $espacio->id))}}">
				<button class="btn wt-btn-primary">CONTINUAR</button>
			</a>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<div class="container-right__dialog-box">
			<div>
				<p>Muchos anfitriones cuentan con al menos 5 fotos. Puedes empezar con una y añadir más en otro momento. Incluir fotos de todos los ambientes a los que tendrán acceso los invitados les ayudará a hacerse una idea de cómo podría ser su evento. Las imágenes deben tener una calidad superior en dimensiones a 1920 x 1080px.</p>
				<p>Importante: Por carga puedes subir 2MB por imagen y hasta 20 MB en total.</p>
				<p>Tips: Asegúrate de que haya bastante luz en el espacio. A veces, hacer fotos desde una esquina puede darte una mejor perspectiva que hacerlas desde un ángulo frontal.</p>
			</div>
		</div>
	</div>
</section>
@endsection