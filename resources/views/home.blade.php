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
                <a href="/"><img src="http://www.wimet.co/img/wimet_isologotipo_blanco.svg" alt="Wimet" width="200" /></a>
                <div class="actions">
                    <ul>
                        <li><a href="{{ url('/publicar')}}" class="wt-btn-transparent">Publica tu espacio</a></li>
                        @if(!Auth::check())
                            <li><a href="#" id="btn-login" style="color: #fff">Ingresar</a></li>
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
                <h3 class="text-header__sub-title">Publica, descubre y reserva un espacio creativo para tu próxima actividad.</h3>
                <div class="texto-header__container-btn">
                    <a href="#" class="wt-btn-transparent">CÓMO FUNCIONA</a>
                </div>
            </section>
            <!-- Footer Header -->
            <section class="header-footer">         
                <div class="container">
                    {!! Form::open(['url' => 'search', 'method' => 'GET', 'class' => 'wt-center-block']) !!}
                        
                        <select name="ubicacion" class="wt-custom-select">
                            <option value="">Ubicación</option>
                        </select>

                        <select name="categoria" class="wt-custom-select" required>
                            <option value="">Tipo de actividad</option>
                            @foreach($categorias as $categoria)
                            <option value="{{$categoria->id}}">{{$categoria->name}}</option>
                            @endforeach
                        </select>

                        <button class="btn btn-danger">Buscar</button>

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
                    <div>
                        <a href="#"><img src="http://lorempixel.com/people/800/400/" alt="" class="img-responsive"></a>
                        <a href="#"><img src="http://lorempixel.com/people/400/800/" alt="" class="img-responsive"></a>
                        <a href="#"><img src="http://lorempixel.com/people/400/400/" alt="" class="img-responsive"></a>
                        <a href="#"><img src="http://lorempixel.com/people/400/400/" alt="" class="img-responsive"></a>
                    </div>
                </div>
            </section>

            <!-- Comunity -->
            <section class="comunity">
                <div class="container">
                    <h2 class="text-center">Conoce a nuestra comunidad</h2>
                    <h3 class="text-center">Mira lo que dice la gente sobre Wimet</h3>
                    <div class="comunity__container">
                        <div>
                            <img class="img-circle img-responsive center-block" src="http://m.alo.co/sites/default/files/imagecache/Main_Galeria_Vertical_433_570/jason-statham-2012-2.jpg" alt="Jason Statham"  width="200" height="200">
                            <p class="text-center">Jason Statham</p>
                        </div>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit voluptates unde itaque dignissimos id quis atque quos optio harum a magnam, dolores, vel amet molestiae ipsam numquam rerum perferendis quas.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- how does it work -->
            <section class="how-work">
                <div class="container">
                    <h2 class="text-center">¿Cómo funciona?</h2>
                    <h3 class="text-center">Planifica tu workshop, reunión de trabajo o cocktail en solo 3 pasos.</h3>

                    <div class="row">
                        <div class="col-sm-4">
                            <img class="center-block" src="img/wimet_organizador_1.svg" alt="benefits of product" width="140" height="110">
                            <h4 class="text-center">Busca un espacio único</h4>
                            <p class="text-center">Descubre en tu ciudad lugares inspiradores, creativos y previamente curados por nuestros scouts.</p>
                        </div>
                        <div class="col-sm-4">
                            <img class="center-block" src="img/wimet_organizador_2.svg" alt="benefits of product" width="140" height="110">
                            <h4 class="text-center">Ponte en contacto</h4>
                            <p class="text-center">Conversa con el anfitrión y termina de cerrar los detalles en forma segura a través de nuestro sistema.</p>
                        </div>
                        <div class="col-sm-4">
                            <img class="center-block" src="img/wimet_organizador_3.svg" alt="benefits of product" width="140" height="110">
                            <h4 class="text-center">Confirma tu reserva</h4>
                            <p class="text-center">Finaliza tu reserva en nuestro sistema y aprovechar al máximo este espacio creativo. Tendrás un evento memorable!</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- how does it work -->
            <section class="how-work">
                <div class="container">
                    <h2 class="text-center">¿Tienes un espacio creativo disponible?</h2>
                    <h3 class="text-center">Te damos la plataforma donde podrás alquilarlo.</h3>

                    <div class="row">
                        <div class="col-sm-4">
                            <img class="center-block" src="img/wimet_anfitrion_1.svg" alt="benefits of product" width="140" height="110">
                            <h4 class="text-center">Publica tu espacio</h4>
                            <p class="text-center">Brinda características que definen la unicidad de tu lugar.</p>
                        </div>
                        <div class="col-sm-4">
                            <img class="center-block" src="img/wimet_anfitrion_2.svg" alt="benefits of product" width="140" height="110">
                            <h4 class="text-center">Promociónalo</h4>
                            <p class="text-center">Alcanza una gran audiencia interesada en reservar la locación.</p>
                        </div>
                        <div class="col-sm-4">
                            <img class="center-block" src="img/wimet_anfitrion_3.svg" alt="benefits of product" width="140" height="110">
                            <h4 class="text-center">Aumenta tus ventas</h4>
                            <p class="text-center">Recibe contactos genuinos de potenciales clientes, desarrolla tu espacio y genera utilidades.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sponsors -->
            <section class="sponsors">
                <img class="img-responsive" src="img/site-1.png" alt="codamotion">
                <img class="img-responsive" src="img/site-2.png" alt="startup buenos aires">
                <img class="img-responsive" src="img/site-3.png" alt="shock your cocktail">
                <img class="img-responsive" src="img/site-4.png" alt="IAE Business school">
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
                        <img class="img-responsive" src="img/wimet_isologotipo_blanco.svg" alt="Wimet">
                        <ul>
                            <li><a href="#">Cómo funciona</a></li>
                            <li><a href="#">Términos y condiciones</a></li>
                            <li><a href="#">Políticas de privacidad</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <h3>EMPRESA</h3>
                        <ul>
                            <li><a href="#">Sobre nosotros</a></li>
                            <li><a href="#">Equipo</a></li>
                            <li><a href="#">Prensa</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Ayuda</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <h3>CATEGORÍAS</h3>
                        <ul>
                            <li><a href="#">Reuniones de trabajo</a></li>
                            <li><a href="#">Cocktails</a></li>
                            <li><a href="#">Producciones</a></li>
                            <li><a href="#">Pop-Ups</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <h3>SEGUINOS</h3>
                        <ul>
                            <li><a href="#">Sobre nosotros</a></li>
                            <li><a href="#">Equipo</a></li>
                            <li><a href="#">Prensa</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Ayuda</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Modal -->
        <div id="loginModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                @include('auth.login2')
            </div>
        </div>
        <script>
            // Get the modal
            var modal = document.getElementById('loginModal');

            // Get the button that opens the modal
            var btn = document.getElementById("btn-login");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal 
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
    </body>
</html>