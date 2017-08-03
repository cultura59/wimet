@extends('layouts.app')

@section('title', $espacio->name)

@push('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="/js/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
	<script type="text/javascript">
	    $('#inicio').datetimepicker({
	        language:  'es',
	        format: "DD/MM/YYYY HH:mm a",
	        showMeridian: 1,
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1,
	        minuteStep: 30,
	        showMeridian: 1
	    }).on('changeDate', function(ev){
			localStorage.setItem("consultaInicio", ev.date);
			$('#fin').val('');
			localStorage.removeItem("consultaFin", ev.date);
		});
	    $('#fin').datetimepicker({
	        language:  'es',
	        format: "DD/MM/YYYY HH:mm a",
	        showMeridian: 1,
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1,
	        minuteStep: 30
	    }).on('changeDate', function(ev){
			localStorage.setItem("consultaFin", ev.date);
		});
	</script>
	<script>
		var map;
		function initMap() {
			map = new google.maps.Map(document.getElementById('map-espacio'), {
				center: new google.maps.LatLng({{$espacio->lat}}, {{$espacio->long}}),
				zoom: 14,
				disableDefaultUI: false,
				scrollwheel: false,
			    navigationControl: false,
			    mapTypeControl: true,
			    scaleControl: false,
			    draggable: false,
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng({{$espacio->lat}}, {{$espacio->long}}),
				icon: "{{url('/wimet-ic-espacio-marker.png')}}",
				map: map
			});
		}
		
		(function(){
			var isMobile = {
			    Android: function() {
			        return navigator.userAgent.match(/Android/i);
			    },
			    BlackBerry: function() {
			        return navigator.userAgent.match(/BlackBerry/i);
			    },
			    iOS: function() {
			        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
			    },
			    Opera: function() {
			        return navigator.userAgent.match(/Opera Mini/i);
			    },
			    Windows: function() {
			        return navigator.userAgent.match(/IEMobile/i);
			    },
			    any: function() {
			        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
			    }
			};
			if(!isMobile.any()) {
				$(window).scroll(function(){
					if ($(this).scrollTop() > 560 && $(this).scrollTop() < 1870) {
						$('#aside-reserva').removeClass('box-reserva');
						$('#aside-reserva').addClass('box-reserva--active');
					} else {
						$('#aside-reserva').removeClass('box-reserva--active');
						$('#aside-reserva').addClass('box-reserva');
					}
				});	
			}
		})();
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUp-A4EcLNbPonxHhbySVWpP9kzZQQUw&callback=initMap" async defer></script>
@endpush

@section('content')

	<div id="home-espacio">
		<aside-reserva 
			espacio-id="{{$espacio->id}}"
			avatar-url="{{$espacio->user->imagesource}}"
			nombre-anfitrion="{{$espacio->user->firstname}}"
			price="{{$price->price}}"
			minhours="{{$price->minhours}}"
			category-id="{{$categoryId}}">
		</aside-reserva>

		<header-espacio espacio-id="{{$espacio->id}}"></header-espacio>
	
		<main class="home-espacio-body">
			<div class="center-title">
				<h3 class="title">{{$espacio->name}}</h3>
				@if($espacio->status == 1)
					<img src="{{url('/img/wimet_ic_verified_user_black_24px.svg')}}" alt="Espacio verificado" class="verified">
				@else
					<img src="{{url('/img/wimet_ic_verified_user_black_24px.svg')}}" alt="Espacio verificado" class="verified">
				@endif
			</div>
			<div class="direccion">
				<span>{{$espacio->city}}, {{$espacio->state}}</span>
			</div>
			<div class="wt-m-top-1">
				<img src="/img/wimet_ic_group_black_24px.svg" alt="" class="icon-people"> {{$espacio->quanty}} Máx
			</div>
			<button class="btn-primary-pig-mobile-lg"><a href="/consulta/{{$categoryId}}/espacio/{{$espacio->id}}">CONTACTAR AL ANFITRIÓN</a></button>
			<div class="box-descripcion">
				<div class="box-descripcion__titulo">
					<span>Espacio</span>
				</div>
				<div class="box-descripcion__contenido">
					<p>{!! $espacio->description !!}</p>
				</div>
			</div>
			<div class="box-descripcion">
				<div class="box-descripcion__titulo">
					<span>Precio</span>
				</div>
				<div class="box-descripcion__contenido">
					<div class="wt-center-column">
						<span class="price"><b><i class="fa fa-clock-o" aria-hidden="true"></i></b> ${{$price->price}}.-</span>
						<span class="min-hours">mínimo {{$price->minhours}} horas</span>
						<span class="min-hours">NOTA: El precio se encuentra sujeto a modificaciones en función de la temporada/ época del año.</span>
					</div>
				</div>
			</div>
			<div class="box-descripcion">
				<div class="box-descripcion__titulo">
					<span>Disponibilidad</span>
				</div>
				<div class="box-descripcion__contenido">
					@foreach($espacio->disponibilidad as $disponibilidad)
					<div class="wt-space-block">
						<span>{{$disponibilidad->dia}}</span>
						<span><hr class="box-descripcion__contenido__separador"></span>
						@if($disponibilidad->inicio == '0' && $disponibilidad->fin == 0)
							<span>No disponible</span>
						@elseif($disponibilidad->inicio == '0' && $disponibilidad->fin == 24)
							<span>Abierto 24hs</span>
						@else
							<span>{{$disponibilidad->inicio}} - {{$disponibilidad->fin}}</span>
						@endif
					</div>
					@endforeach
				</div>
			</div>
			<div class="box-amenities wt-m-top-2 wt-m-bot-2">
				<p class="box-amenities__title">Amenities</p>
				<div class="row">
					@foreach($espacio->servicios as $servicio)
						<div class="col-xs-6 col-md-4">
							<div class="pull-left">
								<i class="fa fa-check" aria-hidden="true"></i>
								<span>{{$servicio->nombre}}</span>
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<div class="wt-m-top-2 wt-m-bot-2 box-access">
				<div class="row">
					<div class="col-md-6">
						<p class="box-access__title">Acceso</p>
						@foreach($espacio->access as $access)
						<div>
							<i class="fa fa-check" aria-hidden="true"></i>
							<span>{{$access->nombre}}</span>
						</div>
						@endforeach
					</div>
					<div class="col-md-6">
						<p class="box-access__title">Normas del espacio</p>
						@foreach($espacio->rules as $rules)
						<div>
							<i class="fa fa-ban" aria-hidden="true"></i>
							<span>{{$rules->nombre}}</span>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			<div id="map-espacio" class="wt-m-top-2"></div>
			<div class="box-descripcion">
				<div class="box-descripcion__titulo">
					<span>Cancelación y depósito de garantía</span>
				</div>
				<div class="box-descripcion__contenido">
					<div class="wt-center-column">
						<span>Cancelación: {{$espacio->cancellationflexibility}}.</span>
						@if($espacio->cancellationflexibility == 'flexible')
						<span>
							Reembolso completo hasta 15 días antes del evento, excepto los gastos de procesamiento.
						</span>
						@elseif ($espacio->cancellationflexibility == 'moderado')
						<span>
							Reembolso completo hasta 30 días antes del evento, excepto los gastos de procesamiento.
						</span>
						@else
						<span>
							50% de reembolso hasta 30 días antes del evento, excepto gastos de procesamiento.
						</span>
						@endif<br>
						<span>Depósito de garantia: ${{$espacio->securitydeposit}}.</span>
					</div>
				</div>
			</div>
			@if($espacio->user->personaldescription != "")
			<div class="box-descripcion">
				<div class="box-descripcion__titulo">
					<span>Anfitrión</span>
				</div>
				<div class="box-descripcion__contenido">
					<p>{{$espacio->user->personaldescription}}</p>
				</div>
			</div>
			@endif
		</main>
	</div>

    <!-- footer -->
    <footer>
        <div class="container">
            <div class="row">
               <div class="col-xs-12 col-sm-4">
                <img class="img-responsive" src="{{url('img/wimet_footer_logo_light.svg')}}" alt="Wimet" width="163">
                <p class="main-footer">
                    Wimet es un marketplace para eventos dedicado a vincular propietarios de espacios creativos con organizadores que buscan brindar una experiencia memorable.
                </p>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <p class="col-footer">Empresa</p>
                    <ul>
                        <li><a href="{{url('/nosotros')}}">Nosotros</a></li>
                        <li><a href="{{url('/nosotros')}}">Cómo funciona</a></li>
                        <li><a href="{{url('/nosotros')}}">Ayuda</a></li>
                        <li><a href="{{url('/nosotros')}}">Términos y condiciones</a></li>
                        <li><a href="{{url('/nosotros')}}">Políticas de privacidad</a></li>
                    </ul>
                </div>
                 <div class="col-xs-12 col-sm-2">
                    <p class="col-footer">Actividades</p>
                    <ul>
                        <li>
                            <a href="{{url('/search?ubicacion=&categoria=1&quanty=0-1000&price=100-10000')}}">Reuniones</a>
                        </li>
                        <li>
                            <a href="{{url('/search?ubicacion=&categoria=2&quanty=0-1000&price=100-10000')}}">Eventos</a>
                        </li>
                        <li>
                            <a href="{{url('/search?ubicacion=&categoria=3&quanty=0-1000&price=100-10000')}}">Producciones</a>
                        </li>
                        <li>
                            <a href="{{url('/search?ubicacion=&categoria=4&quanty=0-1000&price=100-10000')}}">Pop-Ups</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <p class="col-footer">Contacto</p>
                    <ul>
                        <li><a href="#">hola@wimet.co</a></li>
                        <li><a href="#">El Salvador 5218, CABA</a></li>
                        <li><a href="#">Buenos Aires, Argentina</a></li>
                    </ul>
                    <div class="wt-m-top-3 follow">
                        <a href="https://www.facebook.com/wimet.co/">
                            <img src="{{url('img/wimet_icon_facebook.svg')}}" alt="Wimet" class="img-responsive">
                        </a>
                        <a href="https://www.instagram.com/wimet.co/">
                            <img src="{{url('img/wimet_icon_instagram.svg')}}" alt="Wimet" class="img-responsive">
                        </a>
                        <a href="https://www.linkedin.com/company/wimet">
                            <img src="{{url('img/wimet_icon_linkedin.svg')}}" alt="Wimet" class="img-responsive">
                        </a>
                        <a href="https://twitter.com/wimetco">
                            <img src="{{url('img/wimet_icon_twitter.svg')}}" alt="Wimet" class="img-responsive">
                        </a>
                    </div>
                
                </div>
            </div>
        </div>
    </footer>

@endsection