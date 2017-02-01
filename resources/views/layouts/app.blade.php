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
            <nav class="header-navbar container-fluid">
                <a href="/"><img src="{{url('img/wimet_logo_dark.svg')}}" alt="Wimet" width="168" /></a>
                <div class="actions">
                    <ul>
                        <li>
                            <a href="{{ url('/publicar') }}" class="wt-btn-principal-search">PUBLICA TU ESPACIO</a>
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
    
        <script src="{{url('/js/app.js')}}"></script>
        @stack('scripts')
    </body>
</html>