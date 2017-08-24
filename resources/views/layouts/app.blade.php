<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
        <meta name="google-site-verification" content="A6bEbj0anLR76S8r9y2oG_7UMuN6YUn4-hYL-ZZFLvs" />
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">

        <link rel="stylesheet" href="/css/basic.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <script src="https://apis.google.com/js/api:client.js"></script>
                
        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-77438674-1', 'auto');
            ga('send', 'pageview');
        </script>
    </head>
    <body>
        <div id="home-espacio">
            <!-- Header Home -->
            <header class="header-with">
                <nav class="header-navbar container-fluid">
                    <a href="/">
                        <img class="img-responsive" src="http://res.cloudinary.com/wimet/image/upload/v1503064340/wimet-logo_frbya5.svg" alt="Wimet" width="158" />
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
        <!-- Start of HubSpot Embed Code -->
        <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/2880578.js"></script>
        <!-- End of HubSpot Embed Code -->
    </body>
</html>