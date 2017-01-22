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
			<div class="search-form">
				{!! Form::open(['url' => 'search', 'method' => 'GET', 'class' => 'wt-center-block-left']) !!}
                    
					{!! Form::select('ubicacion', 
						['Buenos aires' => 'Buenos aires'], 
						Request::input('ubicacion'), 
						['class' => 'wt-custom-select', 'placeholder' => 'Ubicación']
					) !!}

					{!! Form::select('categoria', 
						$categorias, 
						Request::input('categoria'), 
						['class' => 'wt-custom-select', 'placeholder' => 'Qué estás planificando?']
					) !!}

					{!! Form::select('invitados', 
						$categorias, 
						Request::input('invitados'), 
						['class' => 'wt-custom-select', 'placeholder' => 'Invitados']
					) !!}

					{!! Form::select('precio', 
						$categorias, 
						Request::input('precio'), 
						['class' => 'wt-custom-select', 'placeholder' => 'Precio / hr']
					) !!}
					{!! Form::input('search',
						null,
						null,
						['class' => 'wt-custom-input', 'placeholder' => 'Seleccione actividad']
					)!!}

				{!! Form::close() !!}
			</div>
			<div class="row">
				<div class="col-sm-7">
					<p class="search-result">{{$espacios->total()}} espacios encontrados</p>
					
					<div class="search-data">
						<div class="row">
							@foreach($espacios as $espacio)
							<div class="col-sm-6">
								<a href="{{ route('homespacio', ['categoriaId' => Request::input('categoria'), 'id' => $espacio->id]) }}">
									<img src="http://www.wimet.co/img/feature-2.jpg" alt="espacio 1" class="img-responsive">
									<div class="search-espacio">
										$ {{$espacio->priceByCategory[0]->price}} ARS
									</div>
									<p>{{$espacio->name}}</p>
									<span>
										<i class="fa fa-users" aria-hidden="true"></i> {{$espacio->quanty}}
									</span>
								</a>
							</div>
							@endforeach
							@foreach($espacios as $espacio)
							<div class="col-sm-6">
								<a href="{{ route('homespacio', ['categoriaId' => Request::input('categoria'), 'id' => $espacio->id]) }}">
									<img src="http://www.wimet.co/img/feature-2.jpg" alt="espacio 1" class="img-responsive">
									<div class="search-espacio">
										$ {{$espacio->priceByCategory[0]->price}} ARS
									</div>
									<p>{{$espacio->name}}</p>
									<span>
										<i class="fa fa-users" aria-hidden="true"></i> {{$espacio->quanty}}
									</span>
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