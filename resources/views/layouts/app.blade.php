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

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>

        <link rel="stylesheet" href="/css/basic.css">
        <link rel="stylesheet" href="/css/dropzone.css">
        
        <link rel="stylesheet" href="{{url('swipebox/src/css/swipebox.css')}}">

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
            <nav class="header-navbar container-fluid">
                <a href="/">
                    <img class="img-responsive" src="{{url('img/wimet_logo_dark.svg')}}" alt="Wimet" width="168" />
                </a>
                <div class="actions">
                    <ul>
                        <li>
                            <a href="{{ url('/publicar/primer-paso') }}" class="wt-btn-principal-search">PUBLICA TU ESPACIO</a>
                        </li>
                        @if(!Auth::check())
                            <li><a href="{{url('/login')}}" id="btn-login" class="text-bold">Ingresar</a></li>
                        @else
                            <li>
                                {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </header>

        <!-- main -->
        <main>
            @yield('content')
        </main>
        <script src="{{url('swipebox/lib/jquery-2.1.0.min.js')}}"></script>
        <script src="{{url('swipebox/src/js/jquery.swipebox.js')}}"></script>
        <script type="text/javascript">
            var jq210 = jQuery.noConflict();
            jq210(document).ready(function() {
                jq210( '.swipebox' ).swipebox();

            });
        </script>
        <script src="{{url('/js/app.js')}}"></script>
        @stack('scripts')
    </body>
</html>