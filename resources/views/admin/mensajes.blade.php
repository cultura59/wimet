@extends('layouts.app')

@section('title', 'Mensajes')

@section('content')

	@include('admin.header')

	<section class="mensajes-main">
		<div class="container">
			<div class="wt-m-top-3">
				<a href="#" class="text-bold">Busco un espacio</a> | <a href="#" class="text-bold">Alquilo mi espacio</a>
			</div>
			<div class="box-container">
				<div class="row">
					<div class="col-sm-2">
						<img src="http://lorempixel.com/people/100/100" alt="" class="img-responsive img-circle">
					</div>
					<div class="col-sm-2">
						<p>Carloz Perez</p>
						<p>12-12-2016</p>
					</div>
					<div class="col-sm-6">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam voluptas ea, voluptatem quidem dolorem magni vero recusandae fuga nesciunt, nihil laudantium dolor sint nostrum quibusdam beatae nobis culpa saepe sed?</p>
					</div>
					<div class="col-sm-2">
						<a href="#" class="box__status">Consulta</a>
					</div>
				</div>
			</div>
			<div class="box-container">
				<div class="row">
					<div class="col-sm-2">
						<img src="http://lorempixel.com/people/100/100" alt="" class="img-responsive img-circle">
					</div>
					<div class="col-sm-2">
						<p>Carloz Perez</p>
						<p>12-12-2016</p>
					</div>
					<div class="col-sm-6">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam voluptas ea, voluptatem quidem dolorem magni vero recusandae fuga nesciunt, nihil laudantium dolor sint nostrum quibusdam beatae nobis culpa saepe sed?</p>
					</div>
					<div class="col-sm-2">
						<a href="#" class="box__status">Consulta</a>
					</div>
				</div>
			</div>
			<div class="box-container">
				<div class="row">
					<div class="col-sm-2">
						<img src="http://lorempixel.com/people/100/100" alt="" class="img-responsive img-circle">
					</div>
					<div class="col-sm-2">
						<p>Carloz Perez</p>
						<p>12-12-2016</p>
					</div>
					<div class="col-sm-6">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam voluptas ea, voluptatem quidem dolorem magni vero recusandae fuga nesciunt, nihil laudantium dolor sint nostrum quibusdam beatae nobis culpa saepe sed?</p>
					</div>
					<div class="col-sm-2">
						<a href="#" class="box__status">Consulta</a>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection