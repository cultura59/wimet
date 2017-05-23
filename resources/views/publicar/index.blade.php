@extends('layouts.notfix')

@section('title', 'Publicar')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
		</div>
	</div>
	<div class="container-left">
		<publica-index></publica-index>
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>

@endsection