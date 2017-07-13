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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
                
        <script>
            (function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
        </script>
        <script src="https://apis.google.com/js/api:client.js"></script>
        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <div id="home-espacio">
            <!-- Header Home -->
            <header class="header-dashboard">
                <nav class="header-navbar container-fluid">
                    <a href="/">
                        <img class="img-responsive" src="{{url('img/wimet_logo_dark.svg')}}" alt="Wimet" width="158" />
                    </a>
                    <wimet-login type-login="btn-login link-hov" type-svg="dark" userloged="link-user-dark"></wimet-login>
                </nav>
            </header>

            <!-- main -->
            <main class="main-dashboard">
                @yield('content')
            </main>
        </div>
        <script src="{{url('/js/app.js')}}"></script>
        @stack('scripts')
    </body>
</html>