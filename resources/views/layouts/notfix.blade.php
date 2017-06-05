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
            <header class="header-with-not-fix">
                <nav class="header-navbar container-fluid">
                    <a href="/">
                        <img class="img-responsive" src="{{url('img/wimet_logo_dark.svg')}}" alt="Wimet" width="158" />
                    </a>
                    <wimet-login type-login="btn-login link-hov" type-svg="dark" userloged="link-user-dark"></wimet-login>
                </nav>
            </header>

            <!-- main -->
            <main>
                @yield('content')
            </main>
        </div>
        <script src="{{url('/js/app.js')}}"></script>
        @stack('scripts')
    </body>
</html>