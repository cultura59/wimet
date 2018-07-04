@extends('layouts.app')

@section('title', 'Gracias por su consulta')
@push("scripts")
    <!-- Google Code for Reserva de Espacio Conversion Page -->
    <script type="text/javascript">
        / <![CDATA[ /
        var google_conversion_id = 873274183;
        var google_conversion_language = "en";
        var google_conversion_format = "3";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "l11oCKTliXQQx7a0oAM";
        var google_remarketing_only = false;
        / ]]> /
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/873274183/?label=l11oCKTliXQQx7a0oAM&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
    <script>
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            var end =setInterval(function () {
                seconds = parseInt(timer % 60, 10);
                seconds = seconds < 10 ? + seconds : seconds;

                display.textContent = seconds;

                if (--timer < 0) {
                    window.location = "/dashboard#/mensaje/{{$id}}";
                }
            }, 1000);
        }

        window.onload = function () {
            var fiveMinutes = 4,
                display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        };
    </script>
@endpush

@section('content')
    <div id="home-espacio">
        <div class="header-thankyoupage">
            <h1>Tu consulta a sido enviada</h1>
            <h3>Será redireccionado en <span id="time">5</span> segundos...</h3>
        </div>
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
                        <li><a href="http://blog.wimet.co">Blog</a></li>
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