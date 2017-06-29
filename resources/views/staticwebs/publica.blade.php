<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') . ' - Publica tu espacio' }}</title>

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
    <body class="page-publica">
        <div id="home-espacio">
            <!-- Header Home -->
            <header class="header-publica">
                <!-- navbar -->
                <nav class="header-navbar container-fluid">
                    <a href="/"><img src="{{url('img/wimet_logo_white.svg')}}" alt="Wimet" width="158"/></a>
                    <wimet-login type-login="link-hov" type-svg="white" userloged="link-user-white"></wimet-login>
                </nav>
                <div class="header-publica__main">
                	<h2>Publica tu espacio</h2>
    				<h2>y conviértete en anfitrión</h2>
    				<p>es gratis : )</p>
    				<button-publica type-btn="btn-primary-pig-lg"></button-publica>
                </div>
            </header>
            
            <!-- main -->
            <main>
                <!-- Sponsors -->
                <section class="section-sponsors">
                	<div class="container">
    	                <div class="row">
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w1.png" alt="Increase"></div>
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w2.png" alt="startup buenos aires"></div>
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w3.png" alt="google"></div>
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w4.png" alt="visa"></div>
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w5.png" alt="a3"></div>
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="img/w6.png" alt="startup chile"></div>
    	                </div>
                    </div>
                </section>
                <!-- Seccion de pasos -->
                <section class="container wt-m-top-5 wt-m-bot-5">
                	<h2 class="text-center">¿Tienes un espacio disponible?</h2>
                	<div class="row">
    					<div class="col-sm-4"> 
    						<img src="img/wimet_anfitrion_1.svg" alt="benefits of product" width="140" height="110" class="center-block">
    						<h4 class="text-center">Publica tu espacio</h4>
    						<p class="text-center">Cuéntale al mundo que tienes un espacio creativo para el tipo de actividad que elijas.</p>
    					</div>
    					<div class="col-sm-4"> 
    						<img src="img/wimet_anfitrion_2.svg" alt="benefits of product" width="140" height="110" class="center-block">
    						<h4 class="text-center">Logra visibilidad</h4>
    						<p class="text-center">Alcanza una gran audiencia interesada en reservar un espacio como el tuyo.</p>
    					</div>
    					<div class="col-sm-4"> 
    						<img src="img/wimet_anfitrion_3.svg" alt="benefits of product" width="140" height="110" class="center-block">
    						<h4 class="text-center">Aumenta tus ventas</h4>
    						<p class="text-center">Recibe contactos calificados de clientes potenciales, y genera ingresos extras.</p>
    					</div>
                	</div>
                </section>

                <!-- Descripciones -->
                <section class="section-espacios-1">
                	<div class="section-espacios-1__descripcion">
                		<h4 class="wt-m-bot-3">ESPACIOS COMERCIALES</h4>
                		<h5 class="wt-m-bot-3">Amplía las posibilidades de tu negocio y forma parte de nuestros espacios curados. Gestiona tus clientes potenciales desde nuestra plataforma.</h5>
                		<ul>
    						<li>Bares / Cafés / Restaurants</li>
    						<li>Centros culturales / Museos</li>
    						<li>Espacios de Co-working</li>
    						<li>Depósitos / Galpones</li>
    						<li>Estudios audiovisuales</li>
    						<li>Galerías de arte</li>
    						<li>Locales con vidriera</li>
                		</ul>
                	</div>
                	<div class="section-espacios-1__banner"></div>
                </section>
                <section class="section-espacios-2">
                	<div class="section-espacios-2__banner"></div>
                	<div class="section-espacios-2__descripcion">
                		<h4 class="wt-m-bot-3">ESPACIOS PRIVADOS</h4>
                		<h5 class="wt-m-bot-3">Utiliza el espacio disponible que tienes para generar ingresos extra, y forma parte de una comunidad creativa. La interacción define nuestras vidas y los espacios potencian esas relaciones.</h5>
                		<ul>
    						<li>Casas / Lofts / Departamentos</li>
    						<li>Clubs</li>
    						<li>Estancias / Chacras / Campos</li>
    						<li>Jardines / Parques</li>
    						<li>Oficinas</li>
    						<li>Rooftops</li>
    						<li>Showrooms</li>
                		</ul>
                	</div>
                </section>
                
                <!-- Sumar espacio -->
                <section class="summar-espacio">
                	<h2 class="wt-m-bot-3">¿Listo para sumar tu espacio?</h2>
                    <button-publica type-btn="btn-sumar-espacio"></button-publica>
                	<p class="wt-m-top-3">Si tienes alguna duda puedes consultar nuestras<span class="preguntas-freguentes"> preguntas frecuentes</span></p>
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
        </div>
        <script src="{{url('/js/app.js')}}"></script>
    </body>
</html>