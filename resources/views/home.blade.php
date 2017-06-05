<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <!-- Header Home -->
        <header id="home-espacio" class="header-principal">
            <!-- navbar -->
            <nav class="header-navbar container-fluid">
                <a href="/"><img src="{{url('img/wimet_logo_white.svg')}}" alt="Wimet" width="158"/></a>
                <wimet-login type-login="link-hov" type-svg="white" userloged="link-user-white"></wimet-login>
            </nav>
            <!-- Title Header -->
            <section class="texto-header container">
                <h2 class="text-header__title">RE-IMAGINA TU ENCUENTRO</h2>
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
                        <p class="text-center">Wimet te permite alquilar espacios únicos que inspiran reuniones, eventos, producciones y pop-ups.</p>
                    </div>
                    <!-- container images primary-->
                    <div class="row">
                        <div class="col-xs-12 col-sm-8">
                            <div class="row">
                                <div class="col-xs-12 wt-m-bot-3 img-hov">
                                    <img src="{{url('img/5_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                                <div class="col-xs-12 col-sm-6 img-hov">
                                    <img src="{{url('img/2_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                                <div class="col-xs-12 col-sm-6 img-hov">
                                    <img src="{{url('img/1_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 img-hov">
                            <img src="{{url('img/7_col.svg')}}" alt="" class="img-responsive img-home-principal">
                        </div>
                    </div>
                    <!-- container images second-->
                    <div class="row wt-m-top-3">
                        <div class="col-xs-12 col-sm-4 img-hov">
                            <img src="{{url('img/8_col.svg')}}" alt="" class="img-responsive img-home-principal">
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            <div class="row">
                                <div class="col-xs-12 wt-m-bot-3 img-hov">
                                    <img src="{{url('img/6_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                                <div class="col-xs-12 col-sm-6 img-hov">
                                    <img src="{{url('img/3_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                                <div class="col-xs-12 col-sm-6 img-hov">
                                    <img src="{{url('img/4_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Comunity -->
            <section class="how-work wt-m-top-5 wt-m-bot-5">
                <div class="container">
                    <h2 class="text-center dark-grey">Conoce nuestra comunidad</h2>
                    <h3 class="text-center dark-grey">Wimet te permite alquilar espacios únicos que inspiran</h3>

                    <div class="row">
                        <div class="col-sm-4 padder-comments">
                            <img class="center-block brd-round" src="img/testi1.jpg" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">
                                Fue un placer trabajar con el equipo de Wimet. Tuvimos una muy buena experiencia, pudimos organizar nuestra fiesta de fin de año en un lugar diferente y de manera muy rápida. El evento estuvo genial y recibimos felicitaciones de nuestros invitados, especialmente por el lugar.
                            </p>
                            <p class="signature">Michelle Faerman | CMO - Increase</p>
                        </div>
                        <div class="col-sm-4 padder-comments">
                            <img class="center-block brd-round" src="img/testi2.jpg" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">
                                We were early adopters and first clients of Wimet's platform. From the moment we learned about their model, we knew they had great potential to scale the business and create a sustainable company. Moving forward, we will continue to use Wimet's platform for any future events we host.
                            </p>
                            <p class="signature">Lisa Besserman | CEO - Startup Buenos Aires</p>
                        </div>
                        <div class="col-sm-4 padder-comments">
                            <img class="center-block brd-round" src="/avatars/default.png" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">
                                Es una solución para cualquier productora que se encuentra con el desafio de localizar el lugar perfecto para una filmación.
                            </p>
                            <p class="signature">Juan Perez - Cuatro Cabezas</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sponsors -->
            <section class="container wt-m-bot-4">
                <div class="row">
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w1.png" alt="Increase"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w2.png" alt="startup buenos aires"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w3.png" alt="google"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w4.png" alt="visa"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w5.png" alt="a3"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w6.png" alt="startup chile"></div>
                </div>
            </section>

        </main>

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
                            <li><a href="#">Reuniones</a></li>
                            <li><a href="#">Eventos</a></li>
                            <li><a href="#">Producciones</a></li>
                            <li><a href="#">Pop-Ups</a></li>
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
                            <img src="{{url('img/wimet_icon_instagram.svg')}}" alt="Wimet" class="img-responsive">
                            <img src="{{url('img/wimet_icon_facebook.svg')}}" alt="Wimet" class="img-responsive">
                            <img src="{{url('img/wimet_icon_linkedin.svg')}}" alt="Wimet" class="img-responsive">
                            <img src="{{url('img/wimet_icon_twitter.svg')}}" alt="Wimet" class="img-responsive">
                        </div>
                    
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{url('/js/app.js')}}"></script>
    </body>
</html>