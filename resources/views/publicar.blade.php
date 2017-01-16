@extends('layouts.app')

@section('title', 'Publicar')

@push('scripts')
<script>
    Dropzone.options.myDropzone = {
        autoProcessQueue: false,
        uploadMultiple: true,
        maxFilezise: 10,
        maxFiles: 2,
        
        init: function() {
            var submitBtn = document.querySelector("#submitImages");
            myDropzone = this;
            
            submitBtn.addEventListener("click", function(e){
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });
            this.on("addedfile", function(file) {
                alert("file uploaded");
            });
            
            this.on("complete", function(file) {
                myDropzone.removeFile(file);
            });

            this.on("success", 
                myDropzone.processQueue.bind(myDropzone)
            );
        }
    };
</script>
@endpush

@section('content')
@include('admin.header')
<section class="section-publica" ng-app="appPublica">
	<div class="container" ng-controller="publicaCtrl">
		<div class="row">
			<div class="col-sm-2">
				<div class="section-publica__aside">
					<p>Datos básicos</p>
					<ul>
						<li ng-class="isActiveMenu('primer-paso')" ng-click="setStep('primer-paso')">Primer paso</li>
						<li ng-class="isActiveMenu('segundo-paso')" ng-click="setStep('segundo-paso')">Descripción</li>
						<li ng-class="isActiveMenu('tercer-paso')" ng-click="setStep('tercer-paso')">Ubicación</li>
						<li ng-class="isActiveMenu('cuarto-paso')" ng-click="setStep('cuarto-paso')">Fotos</li>
					</ul>
					<p>Tu espacio</p>
					<ul>
						<li>Ficha general</li>
						<li>Reserva</li>
						<li>Disponibilidad</li>
					</ul>
				</div>
			</div>
			
			<div class="col-sm-10">
				<h2>Publica tu espacio</h2><hr>
				<p>Wimet te permite ganar dinero alquilando tu espacio disponible. Completa los siguientes datos y recuerda que la publicación esta sujeta a aprobación.</p>

				<div class="primer-paso wt-m-bot-3" ng-if="(step == 'primer-paso')">
					<p class="title-tipo-espacio wt-m-top-3">Tipo de espacio</p>
					<ul class="list-tipo-espacio wt-m-bot-3">

						<li ng-repeat="categoria in categorias" ng-class="isCategorySelected(categoria)">
							<a href="#" ng-click="setCategoria(categoria)">@{{ categoria.name }}</a>
						</li>

					</ul>

					<div class="capacity-box">
						<div>
							<label for="capacidad">Capacidad Máx.</label>
							<input type="text" ng-model="espacio.capacidad" placeholder="Ingrese capacidad">
						</div>

						<div>
							<label for="ubicacion">Ubicación</label>
							<input type="text" ng-model="espacio.ubicacion" placeholder="Ingrese ubicación">
						</div>
					</div>

					<button ng-click="setStep('segundo-paso')" class="btn btn-danger">Siguiente</button>
				</div>

				<div class="segundo-paso wt-m-bot-3" ng-if="(step == 'segundo-paso')">
					<div class="capacity-box-column">
						<div>
							<label for="">Tipo de espacio</label>
							<input type="text" ng-model="espacio.tipo" placeholder="Define tu lugar. Ej: Rooftop elegante.">
						</div><br><br>
						<div>
							<label for="">Resumen</label>
							<textarea name="resumen" class="wt-textarea" cols="30" rows="10" ng-model="espacio.resumen" placeholder="Describe lo mejor que puedas como es el lugar, los servicios que incluye y la zona donde se encuentra."></textarea>
						</div>
					</div>

					<button ng-click="setStep('primer-paso')" class="btn btn-default">Volver</button>
					<button ng-click="setStep('tercer-paso')" class="btn btn-danger">Siguiente</button>
				</div>

				<div class="tercer-paso wt-m-bot-3" ng-if="(step == 'tercer-paso')">
					<div class="capacity-box">
						<div>
							<label for="pais">País</label>
							<input type="text" ng-model="espacio.pais" placeholder="Ingrese su país">
						</div>

						<div>
							<label for="provincia">Provincia</label>
							<input type="text" ng-model="espacio.provincia" placeholder="Ingrese su provincia">
						</div>
					</div>
					<div class="capacity-box">
						<div>
							<label for="ciudad">Ciudad</label>
							<input type="text" ng-model="espacio.cuidad" placeholder="Ingrese su ciudad">
						</div>

						<div>
							<label for="direccion">Dirección</label>
							<input type="text" ng-model="espacio.ubicacion" placeholder="Ingrese dirección">
						</div>
					</div>

					<button ng-click="setStep('segundo-paso')" class="btn btn-default">Volver</button>
					<button ng-click="setStep('cuarto-paso')" class="btn btn-danger">Siguiente</button>
				</div>

				<div class="cuarto-paso wt-m-bot-3" ng-show="(step == 'cuarto-paso')">
			        <form action="{{url('/avatars')}}" method="post" class="dropzone" id="my-awesome-dropzone" enctype="multipart/form-data">
			        {{csrf_field()}}
			            <input type="file" name="file" multiple />
			        </form>
					<button type="submit" id="submitImages" class="btn btn-danger">Publicar</button>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection