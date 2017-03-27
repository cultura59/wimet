@extends('layouts.app')

@section('title', 'Solicitud')

@push('scripts')
 <script>
 	var objDiv = document.getElementById("box-chat-body");
	objDiv.scrollTop = objDiv.scrollHeight;
 </script>
@endpush

@section('content')

	@include('dashboard.menue')

	<section class="container">
		<h1><b>Solicitud para</b> Area 3</h1>
		<!-- Tabla de ultimas consultas -->
		<div class="wt-m-bot-3">
			<div class="row">
				<div class="col-md-8">
					<div class="wt-m-bot-1 wt-space-block">
						<span><b>Número de reserva:</b> #123456</span>
						<span><b>Estado:</b> <span class="label label-info">Pendiente</span></span>
					</div>
					<div class="box-chat">
						<div id="box-chat-body" class="box-chat-body">
							<div class="alert alert-info" role="alert">
								<strong>Adrián</strong> 10/03/2016 10:30:00<br>Este es un mensaje de prueba! ...
							</div>
							<div class="alert alert-success text-right" role="alert">
								<strong>Federico</strong> 10/03/2016 13:15:00<br>Este es un mensaje de prueba respuesta! ...
							</div>
							<div class="alert alert-success text-right" role="alert">
								<strong>Federico</strong> 10/03/2016 13:15:00<br>Este es un mensaje de prueba respuesta! ...
							</div>
							<div class="alert alert-info" role="alert">
								<strong>Adrián</strong> 10/03/2016 10:30:00<br>Este es un mensaje de prueba! ...
							</div>
							<div class="alert alert-info" role="alert">
								<strong>Adrián</strong> 10/03/2016 10:30:00<br>Este es un mensaje de prueba! ...
							</div>
						</div>
						<div class="box-chat-footer">
							<form action="#" method="POST">
								<input type="text" name="menssage" placeholder="¿Cuál es tu pregunta?...">
								<label for="enviar" class="cursor-pointer"><i class="fa fa-paper-plane" aria-hidden="true"></i></label>
								<input type="submit" id="enviar" value="Enviar" style="display: none;">
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box-reserva" style="width: 95%">
						<div class="box-reserva__header">
							<div class="header__encabezados">
								<span>Desde</span>
							</div>
							<div class="header__precio">
								<p>$ 251.- ARS <span> por hora (mímino 5 hr)</span></p>
							</div>
						</div>
						<div class="box-reserva__body">
							<div class="row">
								<div class="col-sm-6 wt-center-column">
									<input type="hidden" ng-model="priceHs" ng-value="251" autocomplete="off" class="ng-pristine ng-untouched ng-valid ng-empty" value="251">
									<label for="fecha">Tipo de actividad</label>
									<select class="wt-select" name="categoria">
										<option selected="selected" value="">Selecciona</option>
										<option value="1">Reuniones</option>
										<option value="2">Eventos</option>
										<option value="3">Producciones</option>
										<option value="4">Pop-ups</option>
									</select>
								</div>
								<div class="col-sm-6 wt-center-column">
									<input type="hidden" ng-model="priceHs" ng-value="251" autocomplete="off" class="ng-pristine ng-untouched ng-valid ng-empty" value="251">
									<label for="fecha">Cantidad de invitados</label>
									<select class="wt-select" name="categoria">
										<option selected="selected" value="">Selecciona</option>
										<option value="1">Reuniones</option>
										<option value="2">Eventos</option>
										<option value="3">Producciones</option>
										<option value="4">Pop-ups</option>
									</select>
								</div>
							</div>
							<div class="row wt-m-top-2 wt-m-bot-2">
								<div class="col-sm-6 wt-center-column">
									<label for="fecha">Fecha</label>
									<input type="date" name="fecha" ng-model="date" class="wt-input ng-pristine ng-untouched ng-valid ng-empty">
								</div>
								<div class="col-sm-3 wt-center-column">
									<label for="fecha">Inicio</label>
									<select class="wt-select ng-pristine ng-untouched ng-valid ng-empty" ng-model="inicio" name="inicio"><option value="" selected="selected">Hr</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option></select>
								</div>
								<div class="col-sm-3 wt-center-column">
									<label for="fin">Fin</label>
									<select class="wt-select ng-pristine ng-untouched ng-valid ng-empty" ng-model="fin" ng-change="addDateTimes()" name="fin"><option value="" selected="selected">Hr</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option></select>
								</div>
							</div>
							<span class="body__add-date-time">Agregar fecha</span>
							<ul>
								<!-- ngRepeat: fecha in datesTimes -->
							</ul>
							<div class="box-reserva__totales">
								<p class="wt-m-top-2">PRECIO</p>
								<div class="wt-space-block">
									<span class="ng-binding">$251 X 1hs</span>
									<span class="ng-binding">$251.-</span>
								</div>
								<div class="wt-space-block">
									<span>Fee de administración (5%)</span>
									<span class="ng-binding">$12.55.-</span>
								</div>
								<hr>
								<div class="wt-space-block">
									<strong>Total</strong>
									<strong class="ng-binding">$263.55.-</strong>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection