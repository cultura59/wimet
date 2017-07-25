<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="A6bEbj0anLR76S8r9y2oG_7UMuN6YUn4-hYL-ZZFLvs" />
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="assets/css/bootstrap/bootstrap-theme.min.css">

        <!-- Custom css -->
        <link rel="stylesheet" href="assets/css/style.css">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        
        <link rel="stylesheet" href="assets/css/ionicons.min.css">
        
        <!-- Flexslider -->
        <link rel="stylesheet" href="assets/css/flexslider.css">
        
        <!-- Owl -->
        <link rel="stylesheet" href="assets/css/owl.carousel.css">
        
        <!-- Magnific Popup -->
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        
        <link rel="stylesheet" href="assets/css/jquery.fullPage.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
      
        <!--  loader  -->
        <div id="myloader">
            <span class="loader">
                <img src="assets/img/logo.png" class="normal" alt="logo">
                <img src="assets/img/logo@2x.png" class="retina" alt="logo">
            </span>
        </div>
        
        <!--  Main Wrap  -->
        <div id="main-wrap">
            <!--  Header & Menu  -->
            <header id="header" class="fixed transparent">
                <nav class="navbar navbar-default white">
                    <!--  Header Logo  -->
                    <div id="logo">
                        <a class="navbar-brand" href="{{url('/')}}">
                            <img src="assets/img/logo.png" class="normal" alt="logo">
                            <img src="assets/img/logo@2x.png" class="retina" alt="logo">
                            <img src="assets/img/logo_white.png" class="normal white-logo" alt="logo">
                            <img src="assets/img/logo_white@2x.png" class="retina white-logo" alt="logo">
                        </a>
                    </div>
                    <!--  END Header Logo  -->
                    <!--  Classic menu, responsive menu classic  -->
                    <div id="menu-classic">
                        <div class="menu-holder">
                            <ul>
                                <li class="submenu">
                                    <a href="#">PUBLICA TU ESPACIO</a>
                                </li>
                                <li class="submenu">
                                    <a href="#">Ingresa</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--  END Classic menu, responsive menu classic  -->
                    <!--  Button for Responsive Menu Classic  -->
                    <div id="menu-responsive-classic">
                        <div class="menu-button">
                            <span class="bar bar-1"></span>
                            <span class="bar bar-2"></span>
                            <span class="bar bar-3"></span>
                        </div>
                    </div>
                    <!--  END Button for Responsive Menu Classic  -->
                </nav>
            </header>
            <!--  END Header & Menu  -->

            @yield('content')
            
            <!--  Footer. Class fixed for fixed footer  -->
            <footer class="fixed">
                <div class="row">
                    <div class="col-md-4">
                        <div class="logo">
                            <img src="assets/img/logo_white.png" class="normal" alt="logo">
                            <img src="assets/img/logo_white@2x.png" class="retina" alt="logo">
                        </div>
                        <p class="grey-light">Wimet es un marketplace para eventos dedicado a vincular propietarios de espacios creativos con organizadores que buscan brindar una experiencia memorable.</p>
                    </div>
                    <div class="col-md-2">
                        <h6 class="heading white margin-bottom-extrasmall">Empresa</h6>
                        <ul class="sitemap">
                            <li><a href="nosotros">Nosotros</a></li>
                            <li><a href="{{url('/prensa')}}">Cómo funciona</a></li>
                            <li><a href="ayuda">Ayuda</a></li>
                            <li><a href="">Términos y Condiciones</a></li>
                            <li><a href="">Políticas de Privacidad</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h6 class="heading white margin-bottom-extrasmall">Actividades</h6>
                        <ul class="sitemap">
                            <li><a href="">Reuniones</a></li>
                            <li><a href="">Eventos</a></li>
                            <li><a href="">Producciones</a></li>
                            <li><a href="">Pop-ups</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h6 class="heading white margin-bottom-extrasmall">Contacto</h6>
                        <ul class="sitemap">
                            <li><a href="">hola@wimet.co</a></li>
                            <li><a href="">El Salvador 5218, CABA<br>
                                Buenos Aires, Argentina</a></li>
                            <td>
                               <a href="https://www.facebook.com/wimet.co" target="_blank" width="50"><i class="white icon ion-social-facebook"></i></a>
                               <a style="padding-left:20px;" href="https://www.instagram.com/wimet.co" target="_blank"><i class="white icon ion-social-instagram"></i></a>
                               <a style="padding-left:20px;" href="https://www.linkedin.com/company/wimet" target="_blank"><i class="white icon ion-social-linkedin"></i></a>
                               <a style="padding-left:20px;" href="https://www.twitter.com/wimetco" target="_blank"><i class="white icon ion-social-twitter"></i></a>
                            </td>
                        </ul>
                    </div>
                </div>
                <div class="copy col-md-12 padding-leftright-null">
                    &copy; 2017 Wimet - Todos los derechos reservados.</a>
                    <a href="#main-wrap" class="anchor" id="backtotop">Back to top</a>
                </div>
            </footer>
            <!--  END Footer. Class fixed for fixed footer  -->
        </div>
        <!--  Main Wrap  -->
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="assets/js/jquery.min.js"></script>
        <!-- All js library -->
        <script src="assets/js/bootstrap/bootstrap.min.js"></script>
        <script src="assets/js/jquery.flexslider-min.js"></script>
        <script src="assets/js/jquery.fullPage.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/isotope.min.js"></script>
        <script src="assets/js/jquery.magnific-popup.min.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/smooth.scroll.min.js"></script>
        <script src="assets/js/jquery.appear.js"></script>
        <script src="assets/js/jquery.countTo.js"></script>
        <script src="assets/js/jquery.scrolly.js"></script>
        <script src="assets/js/plugins-scroll.js"></script>
        <script src="assets/js/imagesloaded.min.js"></script>
        <script src="assets/js/pace.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>