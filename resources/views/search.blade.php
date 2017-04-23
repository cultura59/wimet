@extends('layouts.app')

@section('title', 'Buscador')

@push('scripts')
<script>
	var map;
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: new google.maps.LatLng(-34.5969302, -58.5159385),
			zoom: 11,
		    zoomControl: true,
		    zoomControlOptions: {
		        position: google.maps.ControlPosition.LEFT_TOP
		    },
			disableDefaultUI: false,
			scrollwheel: false,
		    navigationControl: false,
		    mapTypeControl: false,
		    scaleControl: false,
		    draggable: true,
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

						{!! Form::selectRange('quanty', 
							10,
							400, 
							Request::input('quanty'), 
							['class' => 'wt-custom-select', 'placeholder' => 'Invitados', 'required' => 'required']
						) !!}

						{!! Form::selectRange('price', 
							100,
							1000, 
							Request::input('price'), 
							['class' => 'wt-custom-select', 'placeholder' => 'Precio / hr', 'required' => 'required']
						) !!}
			
						{!! Form::submit('BUSCAR', ['class' => 'btn wt-btn-primary']) !!}
					{!! Form::close() !!}
			</div>

			<section class="section-main">
				<div class="section-main__chield-1">
					<p class="search-result">{{$espacios->total()}} espacios encontrados</p>
					
					<div class="search-data">
						<div class="row">
							@foreach($espacios as $espacio)
							<div class="col-xs-12 col-sm-6">
								<a href="{{ route('homespacio', ['categoriaId' => Request::input('categoria'), 'id' => $espacio->id]) }}">
									<img src="{{url($espacio->images[0]->name)}}" tile="{{$espacio->name}}" class="img-responsive">
									<div class="search-espacio">
										$ {{$espacio->priceByCategory[0]->price}} ARS
									</div>
									<div class="card-footer-search">
										<div class="">
											<p>{{$espacio->name}}</p>
											<span>
												<img class="icon-people" src="{{url('img/wimet_ic_group_black_24px.svg')}}" alt=""> {{$espacio->quanty}}
											</span>
										</div>
										<div>
											<span class="card-avatar-search"></span>
											<div class="star-row">
												<i class="fa fa-star" aria-hidden="true"></i>
												<i class="fa fa-star" aria-hidden="true"></i>
												<i class="fa fa-star" aria-hidden="true"></i>
												<i class="fa fa-star" aria-hidden="true"></i>
												<i class="fa fa-star" aria-hidden="true"></i>
											</div>										
										</div>
									</div>
								</a>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="section-main__chield-2">
					<div id="map"></div>
				</div>
			</section>

			</div>
		</div>
	</div>
@endsection