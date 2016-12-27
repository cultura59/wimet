<!DOCTYPE html>
<html lang="en">
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
                            <li><a href="#" class="wt-btn-principal">Publica tu espacio</a></li>
                            <li><a class="actions__options" href="#">Ingresar</a></li>
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
                        <img class="img-responsive" src="{{ url('img/wimet_isologotipo_blanco.svg') }}" alt="Wimet">
                        <ul>
                            <li><a href="#">Cómo funciona</a></li>
                            <li><a href="#">Términos y condiciones</a></li>
                            <li><a href="#">Políticas de privacidad</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <h3>EMPRESA</h3>
                        <ul>
                            <li><a href="#">Sobre nosotros</a></li>
                            <li><a href="#">Equipo</a></li>
                            <li><a href="#">Prensa</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Ayuda</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <h3>CATEGORÍAS</h3>
                        <ul>
                            <li><a href="#">Reuniones de trabajo</a></li>
                            <li><a href="#">Cocktails</a></li>
                            <li><a href="#">Producciones</a></li>
                            <li><a href="#">Pop-Ups</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <h3>SEGUINOS</h3>
                        <ul>
                            <li><a href="#">Sobre nosotros</a></li>
                            <li><a href="#">Equipo</a></li>
                            <li><a href="#">Prensa</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Ayuda</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <script src="{{url('/js/app.js')}}"></script>
        @stack('scripts')
    </body>
</html>