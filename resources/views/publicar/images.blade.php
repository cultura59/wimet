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
		{!! Form::open(array('url' => 'saveimages', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'novalidate' => 'novalidate')) !!}
		<div class="container-center">
			<h2>Ingrese sus imagenes</h2>
			<div id="files" class="wt-custom-input-file">
				<input type="hidden" name="espacio_id" value="{{$espacio->id}}">
				<label for="imagenes">Inserte todas sus imagenes</label>
				<input type="file" id="imagenes" name="imagenes[]" multiple required>
			</div>
			<ul id="list-files" class="gallery"></ul>

			<div id="home-espacio">
				<list-images espacio-id="{{$espacio->id}}"></list-images>
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