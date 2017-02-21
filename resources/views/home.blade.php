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
                <a href="/"><img src="{{url('img/wimet_logo_white.svg')}}" alt="Wimet" width="200" /></a>
                <div class="actions">
                    <ul>
                        <li><a href="{{ url('/publicar')}}" class="wt-btn-transparent">PUBLICA TU ESPACIO</a></li>
                        @if(!Auth::check())
                            <li><a href="{{url('/login')}}" id="btn-login" style="color: #fff">Ingresar</a></li>
                        @else
                            <li>
                                {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
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
                <div class="container">
                    {!! Form::open(['url' => 'search', 'method' => 'GET', 'class' => 'wt-center-block']) !!}

                        <select name="ubicacion" class="wt-custom-select">
                            <option value="">Ubicación</option>
                        </select>

                        <select name="categoria" class="wt-custom-select" required>
                            <option value="">Qué estás planificando?</option>
                            @foreach($categorias as $categoria)
                            <option value="{{$categoria->id}}">{{$categoria->name}}</option>
                            @endforeach
                        </select>

                        <button class="btn wt-btn-primary">BUSCAR</button>

                    {!! Form::close() !!}
                </div> 
            </section>
        </header>
        
        <!-- main -->
        <main>
            <!-- Categories -->
            <section class="categories">
                <div class="container">
                    <h2 class="text-center">Vivi tu experiencia</h2>
                    <p class="text-center">Wimet te permite alquilar espacios únicos que inspiran</p>

                    <!-- container images primary-->
                    <div class="row wt-m-top-3">
                        <div class="col-xs-12 col-sm-8">
                            <div class="row">
                                <div class="col-xs-12 wt-m-bot-3">
                                    <img src="{{url('img/5_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <img src="{{url('img/2_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <img src="{{url('img/1_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <img src="{{url('img/7_col.svg')}}" alt="" class="img-responsive img-home-principal">
                        </div>
                    </div>
                    <!-- container images second-->
                    <div class="row wt-m-top-3">
                        <div class="col-xs-12 col-sm-4">
                            <img src="{{url('img/8_col.svg')}}" alt="" class="img-responsive img-home-principal">
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            <div class="row">
                                <div class="col-xs-12 wt-m-bot-3">
                                    <img src="{{url('img/6_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <img src="{{url('img/3_col.svg')}}" alt="" class="img-responsive img-home-principal">
                                </div>
                                <div class="col-xs-12 col-sm-6">
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
                    <h2 class="text-center">Conoce nuestra comunidad</h2>
                    <h3 class="text-center">Wimet te permite alquilar espacios únicos que inspiran</h3>

                    <div class="row">
                        <div class="col-sm-4">
                            <img class="center-block" src="img/wimet_organizador_1.svg" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">Descubre en tu ciudad lugares inspiradores, creativos y previamente curados por nuestros scouts.</p>
                            <p class="text-center">Busca un espacio único</p>
                        </div>
                        <div class="col-sm-4">
                            <img class="center-block" src="img/wimet_organizador_2.svg" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">Conversa con el anfitrión y termina de cerrar los detalles en forma segura a través de nuestro sistema.</p>
                            <p class="text-center">Ponte en contacto</p>
                        </div>
                        <div class="col-sm-4">
                            <img class="center-block" src="img/wimet_organizador_3.svg" alt="benefits of product" width="126" height="126">
                            <p class="wt-m-top-3">Finaliza tu reserva en nuestro sistema y aprovechar al máximo este espacio creativo. Tendrás un evento memorable!</p>
                            <p class="text-center">Confirma tu reserva</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sponsors -->
            <section class="container wt-m-bot-4">
                <div class="row">
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/site-1.png" alt="codamotion"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/site-2.png" alt="startup buenos aires"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/site-3.png" alt="shock your cocktail"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/site-4.png" alt="IAE Business school"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/site-4.png" alt="IAE Business school"></div>
                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/site-4.png" alt="IAE Business school"></div>
                </div>
            </section>

            <!-- Newsletter -->
            <section class="newsletter">
                <div class="container">
                    <div class="newsletter-content">
                        <div class="newsletter-content__title">
                            <h2>¿Querés recibir novedades y descuentos especiales?</h2>
                            <p>Suscribite a Wimet News</p>
                        </div>
                        <div class="newsletter-content__email">
                            <input type="text" class="form-control" placeholder="Ingresá tu email...">
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <h4>EMPRESA</h4>
                        <ul>
                            <li><a href="#">Sobre nosotros</a></li>
                            <li><a href="#">Equipo</a></li>
                            <li><a href="#">Términos y condiciones</a></li>
                            <li><a href="#">Políticas de privacidad</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <h4>COMUNIDAD</h4>
                        <ul>
                            <li><a href="#">Cómo funciona</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Prensa</a></li>
                            <li><a href="#">Ayuda</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3 border-redes">
                        <h4>ACTIVIDADES</h4>
                        <ul>
                            <li><a href="#">Reuniones</a></li>
                            <li><a href="#">Eventos</a></li>
                            <li><a href="#">Producciones</a></li>
                            <li><a href="#">Pop-Ups</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <h4>SEGUINOS</h4>
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
        
    </body>
</html>