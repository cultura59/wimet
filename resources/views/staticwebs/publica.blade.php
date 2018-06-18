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
    </head>
    <body class="page-publica">
        <div id="home-espacio">
            <!-- Header Home -->
            <header class="header-publica">
                <!-- navbar -->
                <wimet-login fixed="false" shadow="false" transparent="true"></wimet-login>
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
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w1.png" alt="Increase"></div>
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w2.png" alt="startup buenos aires"></div>
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w3.png" alt="google"></div>
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w4.png" alt="visa"></div>
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w5.png" alt="a3"></div>
    	                    <div class="col-sm-2"><img class="img-responsive center-block" src="https://res.cloudinary.com/wimet/image/upload/q_60/w6.png" alt="startup chile"></div>
    	                </div>
                    </div>
                </section>
                <!-- Seccion de pasos -->
                <section class="container wt-m-top-5 wt-m-bot-5">
                	<h2 class="text-center publica-titles">¿Tienes un espacio disponible?</h2>
                	<div class="row">
    					<div class="col-sm-4"> 
    						<img src="img/wimet_anfitrion_1.svg" alt="benefits of product" width="140" height="110" class="center-block">
    						<h4 class="text-center publica-titles">Publica tu espacio</h4>
    						<p class="text-center">Cuéntale al mundo que tienes un espacio creativo para el tipo de actividad que elijas.</p>
    					</div>
    					<div class="col-sm-4"> 
    						<img src="img/wimet_anfitrion_2.svg" alt="benefits of product" width="140" height="110" class="center-block">
    						<h4 class="text-center publica-titles">Logra visibilidad</h4>
    						<p class="text-center">Alcanza una gran audiencia interesada en reservar un espacio como el tuyo.</p>
    					</div>
    					<div class="col-sm-4"> 
    						<img src="img/wimet_anfitrion_3.svg" alt="benefits of product" width="140" height="110" class="center-block">
    						<h4 class="text-center publica-titles">Aumenta tus ventas</h4>
    						<p class="text-center">Recibe contactos calificados de clientes potenciales, y genera ingresos extras.</p>
    					</div>
                	</div>
                </section>

                <!-- Descripciones -->
                <section class="section-espacios-1">
                	<div class="section-espacios-1__descripcion">
                		<h4 class="wt-m-bot-3 publica-titles">ESPACIOS COMERCIALES</h4>
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
                		<h4 class="wt-m-bot-3 publica-titles">ESPACIOS PRIVADOS</h4>
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
                	<p class="wt-m-top-3">Si tienes alguna duda puedes consultar nuestras
                        <a href="https://wimet.zendesk.com/hc/es" target="_blank"><span class="preguntas-freguentes">preguntas frecuentes</span></a>
                    </p>
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
        <!-- Start of wimet Zendesk Widget script -->
        <script>/*<![CDATA[*/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(e){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var e=this.createElement("script");n&&(this.domain=n),e.id="js-iframe-async",e.src="https://assets.zendesk.com/embeddable_framework/main.js",this.t=+new Date,this.zendeskHost="wimet.zendesk.com",this.zEQueue=a,this.body.appendChild(e)},o.write('<body onload="document._l();">'),o.close()}();
/*]]>*/</script>
<!-- End of wimet Zendesk Widget script -->
        <script async="" defer="" src="https://apis.google.com/js/api:client.js" gapi_processed="true"></script>
        <script src="/js/app.js"></script>
    </body>
</html>