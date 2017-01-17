@extends('layouts.app')

@section('title', 'Buscador')

@push('scripts')
<script>
	var map;
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: new google.maps.LatLng(-34.5969302, -58.5159385),
			zoom: 11,
			disableDefaultUI: false,
			scrollwheel: false,
		    navigationControl: false,
		    mapTypeControl: true,
		    scaleControl: false,
		    draggable: false,
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(-34.5860955, -58.4341036),
			icon: 'http://www.wimet.co/img/favicon.ico',
			map: map
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArSoMrIsnDeERvlCOGJ2WVd36zO2SBTMo&callback=initMap" async defer></script>
@endpush

@section('content')
    <div class="search">
		<div class="container-fuild">
			<div class="row">
				<div class="col-sm-7">
					<div class="search-form">
						{!! Form::open(['url' => 'search', 'method' => 'GET', 'class' => 'wt-center-block-left']) !!}
	                        
							{!! Form::select('ubicacion', 
								['Buenos aires' => 'Buenos aires'], 
								Request::input('ubicacion'), 
								['class' => 'wt-custom-select', 'placeholder' => 'Seleccione ubicación']
							) !!}

							{!! Form::select('categoria', 
								$categorias, 
								Request::input('categoria'), 
								['class' => 'wt-custom-select', 'placeholder' => 'Seleccione actividad']
							) !!}

	                        <button class="btn btn-danger">Buscar</button>
						{!! Form::close() !!}
					</div>
					
					<p class="search-result">Se encontraron {{$espacios->total()}} resultados con los filtros utilizados</p>
					
					<div class="search-data">
						<div class="row">
							@foreach($espacios as $espacio)
							<div class="col-sm-6">
								<a href="{{ route('homespacio', ['categoriaId' => Request::input('categoria'), 'id' => $espacio->id]) }}">
									<img src="http://www.wimet.co/img/feature-2.jpg" alt="espacio 1" class="img-responsive">
									<button class="btn wt-btn-principal search-espacio">${{$espacio->priceByCategory[0]->price}} / hora</button>
									<p>{{$espacio->name}}</p>
									<span>hasta {{$espacio->quanty}} personas</span>
								</a>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="col-sm-5" style="padding: 10px">
					<div id="map"></div>
				</div>
			</div>
		</div>
	</div>
@endsection