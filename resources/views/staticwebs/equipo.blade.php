@extends('layouts.staticwebs')

@section('title', 'Equipo')

@section('content')
<!--  Page Content, class footer-fixed if footer is fixed  -->
<div id="page-content" class="header-static footer-fixed">
    <!--  Slider  -->
    <div id="flexslider-nav" class="fullpage-wrap small">
        <ul class="">
            <li style="background-image:url(assets/img/wimet-espacios-creativos-eventos-reuniones-producciones-popups-equipo.jpg)">
                <div class="text">
                    <h4 class="white big flex-animation">de Buenos Aires a Latinoamérica</h4>
                </div>
                <div class="gradient dark"></div>
            </li>
        </ul>
    </div>
    <!--  END Slider  -->
    <div id="home-wrap" class="content-section fullpage-wrap">
        <div class="row margin-leftright-null white-background">
            <div class="col-md-12 text-center">
                <a class="btn-alt2 wimet margin-null" href="/nosotros" data-mode="drawer_left">NOSOTROS</a>
                <a class="btn-alt2 wimet margin-null" href="/equipo" data-mode="drawer_left">EQUIPO</a>      
                <a class="btn-alt2 wimet margin-null" href="/prensa" data-mode="drawer_left">PRENSA</a>
            </div>
        </div>                  
        <!--  Team  -->
        <div id="team" class="text">
            <div class="row">
                <div class="col-md-12 padding-leftright-null text-center">
                    <h2 class="margin-bottom-null title">Management Team</h2>
                    <div class="padding-md">
                        <p class="heading margin-bottom">Apasionados por las posibilidades de diversas experiencias y con más de 10 años de know-how en eventos, nos encontramos a disposición a través de <i>Wimet Concierge</i> para asistirte en todos tus detalles.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alt-services text-center">
                        <img src="assets/img/wimet-espacios-creativos-eventos-reuniones-producciones-popups-federico-bianchi.jpg" alt="Espacios Creativos Reunion Evento Produccion Popup " width="215" height="215">
                        <div class="service">
                            <h5 class="heading black">Federico Bianchi</br><h6 class="grey margin-bottom-extrasmall"><i>Co-Founder & CEO</i></h6></h5>
                            <p style="font-size:12px" align="justify">Emprendedor. Especialista en Event Managment y Marketing Digital. Miembro del directorio en una reconocida empresa de organización de eventos. Federico aporta a Wimet su creatividad, conocimiento en desarrollo de negocios y habilidades de investigación. Apasionado por la arquitectura, el diseño y las economías colaborativas. <i>Con un pie en la montaña y otro en el mar.</i></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alt-services text-center">
                        <img src="assets/img/wimet-espacios-creativos-eventos-reuniones-producciones-popups-alejandro-storni.jpg" alt="Espacios Creativos Reunion Evento Produccion Popup " width="215" height="215">
                         <div class="service">
                            <h5 class="heading black">Alejandro Storni</br><h6 class="grey margin-bottom-extrasmall"><i>Co-Founder & COO</i></h6></h5>
                            <p style="font-size:12px" align="justify">Emprendedor. Especialista en Industrias Culturales y Marketing & Comunicación. Docente universitario. Creador de experiencias para marcas como Shell, DHL, Chandon, Lucky Strike, Jaeger Le-Coultre, L´Oréal, entre otras. Alejandro aporta a Wimet su conocimiento en gestión, producción y dirección artística. Apasionado por proyectos creativos y experienciales. <i>Soñando despierto.</i></p>    
                        </div>       
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="alt-services text-center">
                        <img src="assets/img/wimet-espacios-creativos-eventos-reuniones-producciones-popups-adrian-rojas.jpg" alt="Espacios Creativos Reunion Evento Produccion Popup " width="215" height="215">
                        <div class="service">
                            <h5 class="heading black">Adrian Rojas</br><h6 class="grey margin-bottom-extrasmall"><i>CTO</i></h6></h5>
                            <p style="font-size:12px" align="justify">Full Stack Developer. Especialista en desarrollo de programación, coordinación y ejecución de sistemas de software. Cuenta con más de 9 años de experiencia en empresas como IBM, Artear y startups. Adrián aporta a Wimet su conocimiento liderando el desarrollo de nuestra plataforma. Apasionado por la tecnología y su alcance. <i>Amante de la cocina y una buena stout.</i></p>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <!--  END Team  -->
    </div>
</div>
<!--  END Page Content, class footer-fixed if footer is fixed  -->
@endsection