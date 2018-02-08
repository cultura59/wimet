<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="A6bEbj0anLR76S8r9y2oG_7UMuN6YUn4-hYL-ZZFLvs" />
        <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/basic.css">
        <script src="https://apis.google.com/js/api:client.js"></script>
    </head>
    <body class="body-dashboard">
        <div id="dashboard">
            <dasboard-index></dasboard-index>
            <section v-if="$route.name == 'Dashboard'" class="referidos">
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
                                    <a href="{{url('/search?ubicacion=&categoria=1&quanty=0-1000&price=100-100000')}}">Reuniones</a>
                                </li>
                                <li>
                                    <a href="{{url('/search?ubicacion=&categoria=2&quanty=0-1000&price=100-100000')}}">Eventos</a>
                                </li>
                                <li>
                                    <a href="{{url('/search?ubicacion=&categoria=3&quanty=0-1000&price=100-100000')}}">Producciones</a>
                                </li>
                                <li>
                                    <a href="{{url('/search?ubicacion=&categoria=4&quanty=0-1000&price=100-100000')}}">Pop-Ups</a>
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
                            <span>&#169 Wimet SAS. Todos los derechos reservados.<span>
                        </div>
                        <div>
                            <a href="#">Politicas de privacidad</span>
                            <a href="#" class="wt-m-lf-2">Términos y condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUp-A4EcLNbPonxHhbySVWpP9kzZQQUw"></script>
        <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
        <script async defer src="/js/dashboard.js"></script>
        <!-- Start of HubSpot Embed Code -->
        <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/2880578.js"></script>
        <!-- End of HubSpot Embed Code -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-77438674-1', 'auto');
            ga('send', 'pageview');
        </script>
        <!--
        <script>
        window.intercomSettings = {
            app_id: "p30rgvxn"
        };
        </script>
        <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/p30rgvxn';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
        -->
    </body>
</html>