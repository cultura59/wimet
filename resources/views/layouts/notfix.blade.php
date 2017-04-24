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

        <link rel="stylesheet" href="/css/basic.css">
                
        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <!-- Header Home -->
        <header class="header-with-not-fix">
            <nav class="header-navbar container-fluid">
                <a href="/">
                    <img class="img-responsive" src="{{url('img/wimet_logo_dark.svg')}}" alt="Wimet" width="158" />
                </a>
                <div class="actions">
                    <ul>
                        <li>
                            <a href="{{ url('/publicar/primer-paso') }}" class="wt-btn-transparent btn-hov">PUBLICA TU ESPACIO
                                <svg class="dark">
                                    <rect x="0" y="0" fill="none" width="100%" height="100%"/>
                                </svg>
                            </a>
                        </li>
                        @if(!Auth::check())
                            <li><a href="{{url('/login')}}" id="btn-login" class="text-bold">Ingresar</a></li>
                        @else
                            <li>
                                <a href="{{url('/dashboard/user/'.Auth::user()->id)}}">
                                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                </a>
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