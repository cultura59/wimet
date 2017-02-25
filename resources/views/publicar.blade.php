@extends('layouts.app')

@section('title', 'Publicar')

@section('content')
<section class="section-publica">
	<div class="container-left" ng-app="appPublica">
		<div ng-controller="publicaCtrl">
			<div class="wt-progress">
				<div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
				aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" ng-style="{width: cols + '%'}">
				</div>
			</div>
			<div class="buttons">
				<button class="btn" ng-click="previewStep()">ATRAS</button>
				<button class="btn wt-btn-primary" ng-click="nextStep()">CONTINUAR</button>
			</div>
			<div class="container-center">
				<!-- primer paso -->
				<div class="primer-paso" ng-if="(step === 'primer-paso')">
					<h2>¡Hola Adrián! Estas a pasos de</h2>
					<h2>ser anfitrión de tu espacio ;)</h2>

					<div class="wt-m-top-3 wt-m-bot-3">
						<span class="title-paso">PASO 1: DATOS BÁSICOS (descripción del lugar)</span>
					</div>
					<div class="wt-m-top-3 wt-m-bot-3">
						<h3>¿Qué estilo de espacio tienes?</h3>
						<select 
							name="estilos" 
							class="select-publica" 
							ng-model="espacio.estilos_espacio"
							ng-options="estilo as estilo.nombre for estilo in estiloespacio track by estiloespacio.id" 
							placeholder="Seleccionar">
						</select>
					</div>

					<div class="wt-m-top-3 wt-m-bot-3">
						<h4>¿Qué tipo de espacio es?</h4>
						<ul class="tipo-espacio">
							<li ng-click="setType('comercial')">
								<span>Comercial</span>
								<img ng-show="isTypeSelected('comercial')" src="{{url('img/ic_done_black_16dp_1x.png')}}">
							</li>
							<li ng-click="setType('privado')">
								<span>Privado</span>
								<img ng-show="isTypeSelected('privado')" src="{{url('img/ic_done_black_16dp_1x.png')}}">
							</li>
						</ul>
					</div>
				</div>

				<!-- Segundo paso -->
				<div class="segundo-paso" ng-if="(step === 'segundo-paso')">
					<h2>¡Cuéntale al mundo acerca de tu espacio!</h2>
					<div class="wt-m-top-4">
						<p class="text-bold">Título de tu espacio</p>
						<input type="text" class="wt-custom-input" ng-model="espacio.name" placeholder="Ingrese el titulo de su espacio">
						<p>50 caracteres</p>
					</div>
					<div class="wt-m-top-4">
						<label class="text-bold">Descripción</label>
						<textarea name="description" ng-model="espacio.description" rows="10" class="wt-textarea" placeholder="Escriba una breve descripción de su espacio, que lo caracteriza y cuales son sus mejores aspectos.">
						</textarea>
					</div>
				</div>

				<!-- Tercer paso -->
				<div class="tercer-paso" ng-if="(step === 'tercer-paso')">
					<h2>¿Qué tipo de actividad se puede a cabo en tu espacio?</h2>
					<div class="container-center__list">
						<!-- Item -->
						<div class="container-center__list__item" ng-repeat="categoria in categorias">
							<div>
								<input type="checkbox" ng-click="setCategoria(categoria)">
							</div>
							<div class="left__item">
								<span>@{{categoria.name}}</span>
								<span class="item-description">(@{{categoria.sub_category[0].name}}, Off-site, Lanzamiento, etc)</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Cuarto paso -->
				<div class="cuarto-paso" ng-if="(step === 'cuarto-paso')">
					<div class="detalles-espacios">
						<h2>Detalles del espacio y accesibilidad</h2>
						<div class="box-publica">
							<div class="box-publica__container">
								<input class="box-publica__container__input" type="text" ng-model="espacio.quantyrooms">
								<span class="box-publica__container__pointer" ng-click="incrementQuantyrooms()">+</span>
								<span class="box-publica__container__pointer" ng-click="decrementQuantyrooms()">-</span>
								<span class="box-publica__container__name">Ambientes</span>
							</div>
							<div class="box-publica__description">
								<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
							</div>
						</div>
						<div class="box-publica">
							<div class="box-publica__container">
								<input class="box-publica__container__input" type="text" ng-model="espacio.quantybathrooms">
								<span class="box-publica__container__pointer" ng-click="incrementQuantybathrooms()">+</span>
								<span class="box-publica__container__pointer" ng-click="decrementQuantybathrooms()">-</span>
								<span class="box-publica__container__name">Baños</span>
							</div>
							<div class="box-publica__description">
								<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
							</div>
						</div>
						<div class="box-publica">
							<div class="box-publica__container">
								<input class="box-publica__container__input" type="text" ng-model="espacio.floor">
								<span class="box-publica__container__pointer" ng-click="incrementFloor()">+</span>
								<span class="box-publica__container__pointer" ng-click="decrementFloor()">-</span>
								<span class="box-publica__container__name">Piso</span>
							</div>
							<div class="box-publica__description">
								<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
							</div>
						</div>
						<div class="box-publica">
							<div class="box-publica__container">
								<input class="box-publica__container__input" type="text" ng-model="espacio.surface">
								<span class="box-publica__container__pointer" ng-click="incrementSurface()">+</span>
								<span class="box-publica__container__pointer" ng-click="decrementSurface()">-</span>
								<span class="box-publica__container__name">Superficie</span>
							</div>
							<div class="box-publica__description">
								<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
							</div>
						</div>
					</div>
					<div class="detalles-accesos wt-m-bot-5">
						<h2>¿Cómo se accede al lugar?</h2>
						<div class="row wt-m-top-3">
							<div class="col-xs-6" ng-repeat="acces in access">
								<input id="id-access-@{{acces.id}}" type="checkbox" ng-click="setAccess(acces)">
								<label for="id-access-@{{acces.id}}">@{{acces.nombre}}.</label>
							</div>
						</div>
					</div>
				</div>

				<!-- Quinto paso -->
				<div class="quinto-paso" ng-if="(step === 'quinto-paso')">
					<h2>¿Qué capacidad de asistentes / invitados tiene tu espacio?</h2>

					<div class="box-publica">
						<div class="box-publica__container">
							<input class="box-publica__container__input" type="text" ng-model="espacio.quanty">
							<span class="box-publica__container__name">Máximo de asistentes</span>
						</div>
						<div class="box-publica__description">
							<span class="description-text">(sólo los disponibles para el uso de invitados)</span>
						</div>
					</div>

					<div class="box-publica">
						<div class="box-publica__container">
							<input class="box-publica__container__input" type="text" ng-model="espacio.foot">
							<span class="box-publica__container__name">De pie (Opcional)</span>
						</div>
						<div class="box-publica__description">
							<span class="description-text">(Actividad informal tipo cocktail, etc)</span>
						</div>
					</div>

					<div class="box-publica">
						<div class="box-publica__container">
							<input class="box-publica__container__input" type="text" ng-model="espacio.seated">
							<span class="box-publica__container__name">Sentados</span>
						</div>
						<div class="box-publica__description">
							<span class="description-text">(Actividad formal con mesas y/o sillas, etc)</span>
						</div>
					</div>
				</div>

				<!-- Sexto paso -->
				<div class="sexto-paso" ng-show="(step === 'sexto-paso')">
					<h2>¿Cual es la dirección exacta?</h2>
					<div class="row">
						<div class="col-md-6">
							<input class="wt-custom-input" id="address" type="text" ng-model="espacio.adress" placeholder="Dirección" ng-change="getLongLat(espacio.adress)">
						</div>
						<div class="col-md-6">
							<input class="wt-custom-input" id="city" type="text" ng-model="espacio.city" placeholder="Localidad">
						</div>
					</div>
					<div class="row wt-m-top-2">
						<div class="col-md-6">
							<input class="wt-custom-input" id="state" type="text" ng-model="espacio.state" placeholder="Provincia">
						</div>
						<div class="col-md-6">
							<input class="wt-custom-input" id="country" type="text" ng-model="espacio.country" placeholder="País">
						</div>
					</div>
					<div class="box-publica">
						<div class="box-publica__container">
							<input class="box-publica__container__input" type="text" value="0">
							<span class="box-publica__container__name">Piso y número (Opcional)</span>
						</div>
						<div class="box-publica__description">
							<span class="description-text">(Si corresponde)</span>
						</div>
					</div>
				</div>

				<!-- Septimo paso -->
				<div class="septimo-paso" ng-if="(step === 'septimo-paso')">
					<h2>¿Con qué amenities cuenta tu espacio?</h2>
					<div class="row wt-m-top-4">
						<div class="col-xs-6" ng-repeat="amenity in amenities">
							<input id="amenity-@{{amenity.id}}" type="checkbox" ng-click="setServicios(amenity)">
							<label for="amenity-@{{amenity.id}}">@{{amenity.nombre}}</label>
						</div>
					</div>
				</div>

				<!-- Octavo paso -->
				<div class="octavo-paso" ng-if="(step === 'octavo-paso')">
					<h2>¿Qué características especiales tiene tu espacio?</h2>
					<div class="row wt-m-top-4">
						<div class="col-xs-6" ng-repeat="characteristic in characteristics">
							<input id="characteristic-@{{characteristic.id}}" type="checkbox" ng-click="setCharacteristics(characteristic)">
							<label for="characteristic-@{{characteristic.id}}">@{{characteristic.nombre}}</label>
						</div>
					</div>
				</div>

				<!-- Noveno paso -->
				<div class="noveno-paso" ng-if="(step === 'noveno-paso')">
					<h2>Establece reglas sobre el espacio</h2>
					<div class="row wt-m-top-4">
						<div class="col-xs-6" ng-repeat="rule in rules">
							<input id="rule-@{{rule.id}}" type="checkbox" ng-click="setRules(rule)"> 
							<label for="rule-@{{rule.id}}">@{{rule.nombre}}</label>
						</div>
					</div>
				</div>

				<!-- Decimo paso -->
				<div class="decimo-paso" ng-if="(step === 'decimo-paso')">
					<h2>Ingrese sus imagenes</h2>
					<label for="imagenes">Inserte todas sus imagenes</label>
					<input type="file" id="imagenes">
				</div>
			</div>
		</div>
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection