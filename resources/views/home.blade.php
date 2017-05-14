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
        <header class="header-principal">
            <!-- navbar -->
            <nav class="header-navbar container-fluid">
                <a href="/"><img src="{{url('img/wimet_logo_white.svg')}}" alt="Wimet" width="158"/></a>
                <div class="actions">
                    <ul>
                        <li>
                            <a href="{{ url('/publicar/primer-paso')}}" class="wt-btn-transparent btn-hov">
                                PUBLICA TU ESPACIO
                                <svg class="white">
                                    <rect x="0" y="0" fill="none" width="100%" height="100%"/>
                                </svg>
                            </a>
                        </li>
                        @if(!Auth::check())
                           
                        <li>
                            <a href="{{url('/login')}}" id="btn-login" class="link-hov">Ingresar</a>
                        </li>
                        @else
                            <li>
                                <a href="#" id="menu-user">
                                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                </a>
                                <ul class="menue-list">
                                    <li class="menue-list__item">
                                        <a href="{{url('/dashboard/user/'.Auth::user()->id.'/datos')}}" style="color: #333;">Editar perfil</a>
                                    </li>
                                    <li class="menue-list__item">
                                        <a href="{{url('/dashboard/user/'.Auth::user()->id.'/misespacios')}}" style="color: #333;">Mi cuenta</a>
                                    </li>
                                    <li class="menue-list__item active">
                                        <a href="{{url('/publicar/primer-paso')}}" style="color: #333;">PUBLICAR TU ESPACIO</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/logout')}}" style="color: #333;">Salir</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
            <!-- Title Header -->
            <section class="texto-header container">
                <h2 class="text-header__title">RE-IMAGINA TU ENCUENTRO</h2>
                <h3 class="text-header__sub-title">Descubre y reserva un espacio creativo para tu próxima actividad</h3>
            </section>
            <!-- Footer Header -->
            <section class="header-footer">         
                <div class="container" id="home-espacio">
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
                            <img class="center-block brd-round" src="/avatars/default.png" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">
                                Es una solución para cualquier productora que se encuentra con el desafio de localizar el lugar perfecto para una filmación. 
                            </p>
                            <p>Juan Perez - Cuatro Cabezas</p>
                        </div>
                        <div class="col-sm-4 padder-comments">
                            <img class="center-block brd-round" src="/avatars/default.png" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">
                                Es una solución para cualquier productora que se encuentra con el desafio de localizar el lugar perfecto para una filmación. 
                            </p>
                            <p>Juan Perez - Cuatro Cabezas</p>
                        </div>
                        <div class="col-sm-4 padder-comments">
                            <img class="center-block brd-round" src="/avatars/default.png" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">
                                Es una solución para cualquier productora que se encuentra con el desafio de localizar el lugar perfecto para una filmación. 
                            </p>
                            <p>Juan Perez - Cuatro Cabezas</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sponsors -->
            <section class="container wt-m-bot-4">
                <div class="row">
                    <div class="col-sm-3"><img class="img-responsive center-block" src="img/site-2.png" alt="startup buenos aires"></div>
                    <div class="col-sm-3"><img class="img-responsive center-block" src="img/site-3.png" alt="shock your cocktail"></div>
                    <div class="col-sm-3"><img class="img-responsive center-block" src="img/site-4.png" alt="shock your cocktail"></div>
                    <div class="col-sm-3"><img class="img-responsive center-block" src="img/site-5.png" alt="startup buenos aires"></div>
                </div>
            </section>

        </main>

        <!-- footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <p>EMPRESA</p>
                        <ul>
                            <li><a href="{{url('/nosotros')}}">Sobre nosotros</a></li>
                            <li><a href="{{url('/equipo')}}">Equipo</a></li>
                            <li><a href="{{url('/nosotros')}}">Términos y condiciones</a></li>
                            <li><a href="{{url('/nosotros')}}">Políticas de privacidad</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <p>COMUNIDAD</p>
                        <ul>
                            <li><a href="#">Cómo funciona</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="{{url('/prensa')}}">Prensa</a></li>
                            <li><a href="#">Ayuda</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-2 border-redes">
                        <p>ACTIVIDADES</p>
                        <ul>
                            <li><a href="#">Reuniones</a></li>
                            <li><a href="#">Eventos</a></li>
                            <li><a href="#">Producciones</a></li>
                            <li><a href="#">Pop-Ups</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-5">
                        <p>SEGUINOS</p>
                        <div class="wt-m-top-3 follow">
                            <img src="{{url('img/wimet_icon_instagram.svg')}}" alt="Wimet" class="img-responsive">
                            <img src="{{url('img/wimet_icon_facebook.svg')}}" alt="Wimet" class="img-responsive">
                            <img src="{{url('img/wimet_icon_linkedin.svg')}}" alt="Wimet" class="img-responsive">
                            <img src="{{url('img/wimet_icon_twitter.svg')}}" alt="Wimet" class="img-responsive">
                        </div><br>
                        <img class="img-responsive wt-m-top-3" src="{{url('img/wimet_footer_logo_light.svg')}}" alt="Wimet" width="163">
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{url('/js/app.js')}}"></script>
    </body>
</html>