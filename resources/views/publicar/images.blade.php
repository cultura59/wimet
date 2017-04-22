@extends('layouts.app')

@section('title', 'Agregar imagenes')

@push('scripts')
<script>
	document.getElementById('imagenes').onchange = function () {
		var files = document.getElementById("imagenes").files;
		var ul = document.getElementById("list-files");
		for (var i = 0; i < files.length; i++)
		{
			var li = document.createElement("li");
			li.appendChild(document.createTextNode(files[i].name));
		 	ul.appendChild(li);
		}
		document.getElementById('files').style.display = "none";
	};
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
				<input type="hidden" name="espacio_id" value="{{$id}}">
				<label for="imagenes">Inserte todas sus imagenes</label>
				<input type="file" id="imagenes" name="imagenes[]" multiple required>
			</div>
			<ul id="list-files" class="list wt-m-top-2"></ul>
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