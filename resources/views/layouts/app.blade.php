<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>

        <link rel="stylesheet" href="/css/basic.css">
        <link rel="stylesheet" href="/css/dropzone.css">

        <script src="/js/dropzone.js"></script>
        
        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <!-- Header Home -->
        <header class="header-with">
            <div class="container-fuild">
                <nav class="header-navbar container-fluid">
                    <a href="/"><img src="http://www.wimet.co/img/wimet_isologotipo.svg" alt="Wimet" width="200" /></a>
                    <div class="actions">
                        <ul>
                            <li>
                                <a href="{{ url('/publicar') }}" class="wt-btn-principal-search">Publica tu espacio</a>
                            </li>
                            @if(!Auth::check())
                                <li><a href="#" id="btn-login" class="text-bold">Ingresar</a></li>
                            @else
                                <li>
                                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <!-- main -->
        <main>
            @yield('content')
        </main>
    
        <!-- footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <h4>EMPRESA</h4>
                        <ul>
                            <li><a href="#">Sobre nosotros</a></li>
                            <li><a href="#">Equipo</a></li>
                            <li><a href="#">Términos y condiciones</a></li>
                            <li><a href="#">Políticas de privacidad</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <h4>COMUNIDAD</h4>
                        <ul>
                            <li><a href="#">Cómo funciona</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Prensa</a></li>
                            <li><a href="#">Ayuda</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3 border-redes">
                        <h4>ACTIVIDADES</h4>
                        <ul>
                            <li><a href="#">Reuniones</a></li>
                            <li><a href="#">Eventos</a></li>
                            <li><a href="#">Producciones</a></li>
                            <li><a href="#">Pop-Ups</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <h4>SEGUINOS</h4>
                        <div class="wt-m-top-3">
                            <i class="fa fa-instagram fa-lg"></i>
                            <i class="fa fa-facebook fa-lg"></i>
                            <i class="fa fa-linkedin fa-lg"></i>
                        </div>
                        <img class="img-responsive" src="{{url('/img/wimet_isologotipo_blanco.svg')}}" alt="Wimet">
                    </div>
                </div>
            </div>
        </footer>
        <script src="{{url('/js/app.js')}}"></script>
        @stack('scripts')
    </body>
</html>