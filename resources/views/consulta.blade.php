@extends('layouts.app')

@section('title', $espacio->name . ' consulta')

@push('scripts')
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
@endpush

@section('content')

	<div id="home-espacio">
        <main class="home-espacio-body">
            <div class="center-title">
                <h3 class="title-m-top-7">{{$espacio->name}}</h3>
                @if($espacio->status == 1)
                    <img src="{{url('/img/wimet_ic_verified_user_black_24px.svg')}}" alt="Espacio verificado" class="verified">
                @else
                    <img src="{{url('/img/wimet_ic_verified_user_black_24px.svg')}}" alt="Espacio verificado" class="verified">
                @endif
            </div>
            <div class="direccion">
                <span>{{$espacio->city}}, {{$espacio->state}}</span>
                <span></span>
            </div>
    		<consulta-reserva 
    			espacio-id="{{$espacio->id}}"
    			avatar-url="{{$espacio->user->imagesource}}"
    			nombre-anfitrion="{{$espacio->user->firstname}}"
    			price="{{$price->price}}"
    			minhours="{{$price->minhours}}"
    			category-id="{{$categoryId}}">
    		</consulta-reserva>
        </main>
	</div>

    <!-- footer -->
    <footer id="footer">
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
                        <li><a href="www.blog.wimet.com">Blog</a></li>
                        <li><a href="{{url('/nosotros')}}">Ayuda</a></li>
                        <li><a href="{{url('/nosotros')}}">Términos y condiciones</a></li>
                        <li><a href="{{url('/nosotros')}}">Políticas de privacidad</a></li>
                    </ul>
                </div>
                 <div class="col-xs-12 col-sm-2">
                    <p class="col-footer">Actividades</p>
                    <ul>
                        <li><a href="#">Reuniones</a></li>
                        <li><a href="#">Eventos</a></li>
                        <li><a href="#">Producciones</a></li>
                        <li><a href="#">Pop-Ups</a></li>
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
                        <img src="{{url('img/wimet_icon_instagram.svg')}}" alt="Wimet" class="img-responsive">
                        <img src="{{url('img/wimet_icon_facebook.svg')}}" alt="Wimet" class="img-responsive">
                        <img src="{{url('img/wimet_icon_linkedin.svg')}}" alt="Wimet" class="img-responsive">
                        <img src="{{url('img/wimet_icon_twitter.svg')}}" alt="Wimet" class="img-responsive">
                    </div>
                
                </div>
            </div>
        </div>
    </footer>

@endsection