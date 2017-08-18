<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" name="viewport">
        <meta name="google-site-verification" content="A6bEbj0anLR76S8r9y2oG_7UMuN6YUn4-hYL-ZZFLvs" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link async defer href="/css/app.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">

        <link async defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <!-- Header Home -->
        <header id="home-espacio" class="header-principal">
            <!-- navbar -->
            <nav class="header-navbar container-fluid">
                <a href="/"><img src="http://res.cloudinary.com/wimet/image/upload/v1503064340/wimet-logo-white_z3tlgh.svg" alt="Wimet" width="158"/></a>
                <wimet-login type-login="link-hov" type-svg="white" userloged="link-user-white"></wimet-login>
            </nav>
            <!-- Title Header -->
            <section class="texto-header container">
                <h2 class="text-header__title">RE-IMAGINA TU <title-home></title-home></h2>
                <h3 class="text-header__sub-title">Descubre y reserva un espacio creativo para tu próxima actividad</h3>
            </section>
            <!-- Footer Header -->
            <section class="header-footer">         
                <div class="container">
                    <search-home></search-home>
                </div> 
            </section>
        </header>
        
        <!-- main -->
        <main>
            <!-- Categories -->
            <section class="categories">
                <div class="container">
                    <div class="content-wt">
                        <h2 class="text-center">¿Qué tipo de actividad vas a organizar?</h2>
                        <p class="text-center">Wimet te permite alquilar espacios únicos que inspiran</p>
                    </div>
                    <div class="categorias-desktop">
                        <!-- container images primary-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-12 wt-m-bot-3 img-hov">
                                        <a href="{{url('/search?ubicacion=&categoria=1&quanty=0-1000&price=100-10000')}}">
                                            <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-1.svg')}}" alt="Cocktail" class="img-responsive img-home-principal">
                                        </a>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 img-hov">
                                        <a href="{{url('/search?ubicacion=&categoria=3&quanty=0-1000&price=100-10000')}}">
                                            <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-3.svg')}}" alt="Workshops" class="img-responsive img-home-principal">
                                        </a>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 img-hov">
                                        <a href="{{url('/search?ubicacion=&categoria=2&quanty=0-1000&price=100-10000')}}">
                                            <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-4.svg')}}" alt="Eventos" class="img-responsive img-home-principal">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 img-hov">
                                <a href="{{url('/search?ubicacion=&categoria=3&quanty=0-1000&price=100-10000')}}">
                                    <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-2.svg')}}" alt="Producción" class="img-responsive img-home-principal">
                                </a>
                            </div>
                        </div>
                        <!-- container images second-->
                        <div class="row wt-m-top-3">
                            <div class="col-xs-12 col-sm-4 img-hov">
                                <a href="{{url('/search?ubicacion=&categoria=4&quanty=0-1000&price=100-10000')}}">
                                    <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-5.svg')}}" alt="Pop-ups" class="img-responsive img-home-principal">
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-12 wt-m-bot-3 img-hov">
                                        <a href="{{url('/search?ubicacion=&categoria=4&quanty=0-1000&price=100-10000')}}">
                                            <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-6.svg')}}" alt="Pop-ups Dinner" class="img-responsive img-home-principal">
                                        </a>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 img-hov">
                                        <a href="{{url('/search?ubicacion=&categoria=1&quanty=0-1000&price=100-10000')}}">
                                            <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-7.svg')}}" alt="Curso" class="img-responsive img-home-principal">
                                        </a>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 img-hov">
                                        <a href="{{url('/search?ubicacion=&categoria=2&quanty=0-1000&price=100-10000')}}">
                                            <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-8.svg')}}" alt="Exposicióm" class="img-responsive img-home-principal">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row categorias-mobile">
                        <div class="col-xs-12 wt-m-top-1">
                            <a href="{{url('/search?ubicacion=&categoria=1&quanty=0-1000&price=100-10000')}}">
                                <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-mobile1.svg')}}" alt="Reuniones" class="img-responsive img-home-principal">
                            </a>
                        </div>
                        <div class="col-xs-12 wt-m-top-1">
                            <a href="{{url('/search?ubicacion=&categoria=2&quanty=0-1000&price=100-10000')}}">
                                <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-mobile2.svg')}}" alt="Eventos" class="img-responsive img-home-principal">
                            </a>
                        </div>
                        <div class="col-xs-12 wt-m-top-1">
                            <a href="{{url('/search?ubicacion=&categoria=3&quanty=0-1000&price=100-10000')}}">
                                <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-mobile3.svg')}}" alt="Producciones" class="img-responsive img-home-principal">
                            </a>
                        </div>
                        <div class="col-xs-12 wt-m-top-1">
                            <a href="{{url('/search?ubicacion=&categoria=4&quanty=0-1000&price=100-10000')}}">
                                <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-mobile4.svg')}}" alt="Pop-ups" class="img-responsive img-home-principal">
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Comunity -->
            <section class="how-work wt-m-top-5 wt-m-bot-1">
                <div class="container">
                    <h2 class="text-center dark-grey">Conoce a nuestra comunidad</h2>
                    <div class="row wt-m-top-5 ">
                        <div class="col-sm-4 padder-comments">
                            <img class="center-block brd-round" src="https://res.cloudinary.com/wimet/image/upload/q_60/testi-1.jpg" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">
                                "Fue un placer trabajar con el equipo de Wimet. Tuvimos una muy buena experiencia, pudimos organizar nuestra fiesta de fin de año en un lugar diferente y de manera muy rápida. El evento estuvo genial y recibimos felicitaciones de nuestros invitados, especialmente por el lugar."
                            </p>
                            <p class="signature">Matias Doublier | COO - Increase</p>
                        </div>
                        <div class="col-sm-4 padder-comments">
                            <img class="center-block brd-round" src="https://res.cloudinary.com/wimet/image/upload/q_60/testi2.jpg" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">
                                "We were early adopters and first clients of Wimet's platform. From the moment we learned about their model, we knew they had great potential to scale the business and create a sustainable company. Moving forward, we will continue to use Wimet's platform for any future events we host."
                            </p>
                            <p class="signature">Lisa Besserman | CEO - Startup Buenos Aires</p>
                        </div>
                        <div class="col-sm-4 padder-comments">
                            <img class="center-block brd-round" src="https://res.cloudinary.com/wimet/image/upload/q_60/testi1.jpg" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">
                                "Recurrimos a Wimet porque estábamos a 3 días de una capacitación y nos habíamos quedado sin lugar. Los contactamos, recibimos distintas propuestas acordes a la necesidad y al budget, elegimos y cerramos el evento en menos de 24hs. No tengo dudas de que va a ser nuestra primera opción para organizar los eventos que vengan."
                            </p>
                            <p class="signature">Lucía Armendáriz | Business Developer - ‎AB InBev</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sponsors -->
            <section class="container wt-m-bot-1">
                <div class="row">
                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w1.png" alt="Increase"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w2.png" alt="startup buenos aires"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w3.png" alt="google"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w4.png" alt="visa"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w5.png" alt="a3"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w6.png" alt="startup chile"></div>
                </div>
            </section>
        </main>

        <!-- footer -->
        <footer>
            <div class="container">
                <div class="row">
                   <div class="col-xs-12 col-sm-4">
                    <img class="img-responsive" src="http://res.cloudinary.com/wimet/image/upload/v1503064340/wimet-logo-redwhite_scy9a1.svg" alt="Wimet" width="163">
                    <p class="main-footer">
                        Wimet es un marketplace para eventos dedicado a vincular propietarios de espacios creativos con organizadores que buscan brindar una experiencia memorable.
                    </p>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <p class="col-footer">Empresa</p>
                        <ul>
                            <li><a href="{{url('/nosotros')}}">Nosotros</a></li>
                            <li><a href="{{url('/nosotros')}}">Cómo funciona</a></li>
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
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-77438674-1', 'auto');
            ga('send', 'pageview');
        </script>
        <script async defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script async defer src="https://apis.google.com/js/api:client.js"></script>
        <script async defer src="{{url('/js/app.js')}}"></script>
    </body>
</html>