<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="google-site-verification" content="A6bEbj0anLR76S8r9y2oG_7UMuN6YUn4-hYL-ZZFLvs" />
        <meta content="Que el espacio no sea una condición sino una oportunidad. Descubre en Wimet espacios únicos que potencian tu creatividad." name="description">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#FC5289">
        <!-- Styles -->
        <link async defer href="/css/app.css" rel="stylesheet">

        <link async defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '346994115731020');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=346994115731020&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->

        <meta content="www.wimet.co" property="og:url">
        <meta content="Wimet.co | RE-IMAGINA TU ENCUENTRO" property="og:title">
        <meta content="Que el espacio no sea una condición sino una oportunidad. Descubre en Wimet espacios únicos que potencian tu creatividad." property="og:description">
        <meta content="https://res.cloudinary.com/wimet/image/upload/fotosespacios/MkC1QOAt_Salondelbajo-06.jpg" property="og:image">
    </head>
    <body>
        <div id="home-espacio">
            <!-- Header Home -->
            <wimet-login fixed="false" shadow="false"></wimet-login>
            <div class="container">
                <!-- Title Header -->
                <section class="texto-header">
                    <h2 class="text-header__title">RE-IMAGINA TU <title-home></title-home></h2>
                    <h3 class="text-header__sub-title">Descubre y reserva un espacio creativo para tu próxima actividad</h3>
                    <div class="wt-m-top-3">
                    <div class="wt-m-top-3">
                        <img src="https://res.cloudinary.com/wimet/image/upload/v1515443747/icons/wimet-icon-espacios.svg" class="img-responsive">
                    </div>
                    <!-- Footer Header -->
                    <section class="header-footer">
                        <search-home></search-home>
                    </section>
                </section>
            </div>
            <!-- main -->
            <main>
                <!-- Categories -->
                <section class="categories">
                    <div class="container">
                        <div class="content-wt">
                            <h2>ESPACIOS ÚNICOS QUE INSPIRAN</h2>
                        </div>
                        <div class="categorias-desktop">
                            <!-- container images primary-->
                            <div class="row">
                                <div class="col-md-3 img-hov">
                                    <a href="/search?ubicacion=&categoria=1&quanty=0-1000&price=100-100000">
                                        <h3>REUNIONES</h3>
                                        <img src="{{url('https://res.cloudinary.com/wimet/image/upload/wimet_espacio_reunion.jpg')}}" alt="Retail" class="img-responsive img-home-principal">
                                    </a>
                                </div>
                                <div class="col-md-3 img-hov">
                                    <a href="/search?ubicacion=&categoria=2&quanty=0-1000&price=100-100000">
                                        <h3>EVENTOS</h3>
                                        <img src="{{url('https://res.cloudinary.com/wimet/image/upload/wimet_espacio_evento.jpg')}}" alt="Retail" class="img-responsive img-home-principal">
                                    </a>
                                </div>
                                <div class="col-md-3 img-hov">
                                    <a href="/search?ubicacion=&categoria=3&quanty=0-1000&price=100-100000">
                                        <h3>PRODUCCIONES</h3>
                                        <img src="{{url('https://res.cloudinary.com/wimet/image/upload/wimet_espacio_produccion.jpg')}}" alt="Retail" class="img-responsive img-home-principal">
                                    </a>
                                </div>
                                <div class="col-md-3 img-hov">
                                    <a href="/search?ubicacion=&categoria=4&quanty=0-1000&price=100-100000">
                                        <h3>RETAIL</h3>
                                        <img src="{{url('https://res.cloudinary.com/wimet/image/upload/wimet_espacio_retail.jpg')}}" alt="Retail" class="img-responsive img-home-principal">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row categorias-mobile">
                            <div class="col-xs-12 wt-m-top-1">
                                <a href="/search?ubicacion=&categoria=1&quanty=0-1000&price=100-100000">
                                    <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-mobile1.svg')}}" alt="Reuniones" class="img-responsive img-home-principal">
                                </a>
                            </div>
                            <div class="col-xs-12 wt-m-top-1">
                                <a href="/search?ubicacion=&categoria=2&quanty=0-1000&price=100-100000">
                                    <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-mobile2.svg')}}" alt="Eventos" class="img-responsive img-home-principal">
                                </a>
                            </div>
                            <div class="col-xs-12 wt-m-top-1">
                                <a href="/search?ubicacion=&categoria=3&quanty=0-1000&price=100-100000">
                                    <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-mobile3.svg')}}" alt="Producciones" class="img-responsive img-home-principal">
                                </a>
                            </div>
                            <div class="col-xs-12 wt-m-top-1">
                                <a href="/search?ubicacion=&categoria=4&quanty=0-1000&price=100-100000">
                                    <img src="{{url('https://res.cloudinary.com/wimet/image/upload/q_60/wimet-espacios-creativos-reunion-evento-produccion-popup-mobile4.svg')}}" alt="Retail" class="img-responsive img-home-principal">
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Comunity -->
                <section id="como-funciona" class="how-work wt-m-top-3 wt-m-bot-1">
                    <div class="container">
                        <h1 class="title-black">Cada espacio, un estilo que potencia tu creatividad.</h1>
                        <div class="row wt-m-top-5 ">
                            <div class="col-sm-4">
                                <div class="paso-a-paso">
                                    <div class="paso-a-paso__left">
                                        <h1>1</h1>
                                    </div>
                                    <div class="paso-a-paso__right">
                                        <strong class="title">Encuentra el espacio ideal</strong>
                                        <span>Descubre espacios privados y comerciales únicos! Desde una galería de arte o una terraza magnífica todo es posible.</span>
                                    </div>
                                </div>
                                <img src="https://res.cloudinary.com/wimet/image/upload/ilustraciones/home_contacta.gif" alt="Contacta dueños" class="img-responsive">
                            </div>
                            <div class="col-sm-4">
                                <div class="paso-a-paso">
                                    <div class="paso-a-paso__left">
                                        <h1>2</h1>
                                    </div>
                                    <div class="paso-a-paso__right">
                                        <strong class="title">Contacta al anfitrión</strong>
                                        <span>Puedes conversar directamente con el anfitrión para arreglar todos los detalles de tu evento.</span>
                                    </div>
                                </div>
                                <img src="https://res.cloudinary.com/wimet/image/upload/v1515447634/ilustraciones/home_encuentra.gif" alt="Encuentra espacios" class="img-responsive">
                            </div>
                            <div class="col-sm-4">
                                <div class="paso-a-paso">
                                    <div class="paso-a-paso__left">
                                        <h1>3</h1>
                                    </div>
                                    <div class="paso-a-paso__right">
                                        <strong class="title">Reserva tu lugar</strong>
                                        <span>Wimet te brinda la seguridad y transparencia que te permitirá reservar online tu espacio ideal</span>
                                    </div>
                                </div>
                                <img src="https://res.cloudinary.com/wimet/image/upload/ilustraciones/home_reserva.gif" alt="Reserva tu espacio" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sponsors -->
                <section class="container wt-m-bot-1">
                    <div class="row">
                        <h3 class="title-black">Profesionales y empresas con la innovación como ADN.</h3>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w1.png" alt="Increase"></div>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w2.png" alt="startup buenos aires"></div>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w3.png" alt="google"></div>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w4.png" alt="visa"></div>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w5.png" alt="a3"></div>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w6.png" alt="startup chile"></div>
                    </div>
                </section>

                <!-- Sponsors -->
                <section class="container wt-m-bot-1">
                    <div class="row">
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w7.png" alt="Increase"></div>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w8.png" alt="startup buenos aires"></div>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w9.png" alt="google"></div>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w10.png" alt="visa"></div>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w11.png" alt="a3"></div>
                        <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w12.png" alt="startup chile"></div>
                    </div>
                </section>

                <section class="referidos">
                    <div class="container">
                        <div class="referidos__content">
                            <img src="https://res.cloudinary.com/wimet/image/upload/ilustraciones/home_hi5.svg" alt=" Programa de referidos" class="img-responsive">
                            <div class="referidos__content__textos">
                                <h3 class="title">Invita a tus amigos! Regala $500 y recibe $500.</h3>
                                <span class="wt-m-top-1">Comparte tu espiritu de #WimetHunter y dale un acceso a tus amigos a un mundo de posibilidades. Recibirán $500 en créditos se registren y tu obtendrás $500 cuando hayan su primer reserva.</span>
                            </div>
                            <button class="referidos__btn-send">Enviar Invitaciones</button>
                        </div>
                    </div>
                </section>

            </main>
            <!-- footer -->
            <footer>
                <div class="container">
                    <div class="row">
                       <div class="col-xs-12 col-sm-4">
                        <img class="img-responsive" src="https://res.cloudinary.com/wimet/image/upload/wimet-logo_frbya5.svg" alt="Wimet" width="163">
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <p class="col-footer">Empresa</p>
                            <ul>
                                <li><a href="{{url('/nosotros')}}">Nosotros</a></li>
                                <li><a href="https://blog.wimet.co">Blog</a></li>
                                <li><a href="{{url('/nosotros')}}">Ayuda</a></li>
                                <li><a href="{{url('/nosotros')}}">Términos y condiciones</a></li>
                                <li><a href="{{url('/nosotros')}}">Políticas de privacidad</a></li>
                            </ul>
                        </div>
                         <div class="col-xs-12 col-sm-2">
                            <p class="col-footer">Actividades</p>
                            <ul>
                                <li>
                                    <a href="{{url('/search?ubicacion=&categoria=1&quanty=0-1000&price=100-100000')}}">REUNIONES</a>
                                </li>
                                <li>
                                    <a href="{{url('/search?ubicacion=&categoria=2&quanty=0-1000&price=100-100000')}}">EVENTOS</a>
                                </li>
                                <li>
                                    <a href="{{url('/search?ubicacion=&categoria=3&quanty=0-1000&price=100-100000')}}">PRODUCCIONES</a>
                                </li>
                                <li>
                                    <a href="{{url('/search?ubicacion=&categoria=4&quanty=0-1000&price=100-100000')}}">RETAIL</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <p class="col-footer">Contacto</p>
                            <ul>
                                <li><a href="#">hola@wimet.co</a></li>
                                <li><a href="#">El Salvador 5218, CABA</a></li>
                                <li><a href="#">Buenos Aires, Argentina</a></li>
                            </ul>
                            <div class="wt-m-top-3 follow">
                                <a href="https://www.instagram.com/wimet.co/" target="_blanck">
                                    <img src="https://res.cloudinary.com/wimet/image/upload/c_scale,h_30,w_30/icons/wimet-icon-instagram.svg" alt="Wimet" class="img-responsive">
                                </a>
                                <a href="https://www.facebook.com/wimet.co/" target="_blanck">
                                    <img src="https://res.cloudinary.com/wimet/image/upload/c_scale,h_30,w_30/v1515518301/icons/wimet-icon-facebook.svg" alt="Wimet" class="img-responsive">
                                </a>
                                <a href="https://www.linkedin.com/company/wimet" target="_blanck">
                                    <img src="https://res.cloudinary.com/wimet/image/upload/c_scale,h_30,w_30/icons/wimet-icon-linkedin.svg" alt="Wimet" class="img-responsive">
                                </a>
                                <a href="https://twitter.com/wimetco" target="_blanck">
                                    <img src="https://res.cloudinary.com/wimet/image/upload/c_scale,h_30,w_30/v1515518302/icons/wimet-icon-twitter.svg" alt="Wimet" class="img-responsive">
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="terminos-copyright">
                        <div>
                            <span>&#169 Wimet SAS. Todos los derechos reservados.</span>
                        </div>
                        <div>
                            <a href="#">Politicas de privacidad</a>
                            <a href="#" class="wt-m-lf-2">Términos y condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
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
        <script async defer src="/js/app.js"></script>
        <!-- Start of HubSpot Embed Code -->
        <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/2880578.js"></script>
        <!-- End of HubSpot Embed Code -->
    </body>
</html>