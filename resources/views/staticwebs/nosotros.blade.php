@extends('layouts.staticwebs')

@section('title', 'Nosotros')

@section('content')
<!--  Page Content, class footer-fixed if footer is fixed  -->
<div id="page-content" class="header-static footer-fixed">
    <!--  Slider  -->
    <div id="flexslider-nav" class="fullpage-wrap small">
        <ul class="">
            <li style="background-image:url(assets/img/wimet-espacios-creativos-eventos-reuniones-producciones-popups-nosotros.jpg)">
                <div class="text">
                    <h4 class="white big flex-animation">conectando personas con espacios creativos</h4>
                </div>
                <div class="gradient dark"></div>
            </li>
        </ul>
    </div>
    <!--  END Slider  -->
    <div id="post-wrap" class="content-section fullpage-wrap">
        <div class="row margin-leftright-null white-background">
            <div class="col-md-12 text-center">
                <a class="btn-alt2 wimet margin-null" href="/nosotros" data-mode="drawer_left">NOSOTROS</a>
                <a class="btn-alt2 wimet margin-null" href="/equipo" data-mode="drawer_left">EQUIPO</a>      
                <a class="btn-alt2 wimet margin-null" href="/prensa" data-mode="drawer_left">PRENSA</a>
            </div>
        </div>                  
        <!-- Section same Height. Child get the parent Height. Set the same id -->
        <div id="news" class="text grey-background">
            <div class="row padding-md-bottom">
                <div class="col-md-12 padding-leftright-null text-center">
                    <h2 class="margin-bottom-null title">MISIÓN</h2>
                    <div class="padding-md">
                        <p class="heading black margin-bottom ">Ayudamos a que profesionales, marcas y empresas encuentren <i>espacios creativos</i></br> para que sus eventos sean <i>experiencias memorables.</i></p>
                        <p class="heading black margin-bottom ">Nuestro marketplace te permite tener acceso a espacios curados, inexplorados y disponibles, ofreciendo extraordinarias instalaciones para reuniones, eventos, producciones y pop-ups.</p>
                        <p class="heading black">Incentivamos la creatividad, promovemos la interacción y creamos comunidad.</p>
                    </div>
                </div>
            </div>
        </div>                    
        <div class="row margin-leftright-null">
            <div class="col-md-6 padding-leftright-null">
                <div data-responsive="parent-height" data-responsive-id="dev" class="text">
                    <h5 class="margin-bottom-null title left black">Organiza tu próxima actividad</h5>
                    <div class="padding-onlytop-md content-post" >
                        <p class="heading left margin-bottom grey">Wimet es un marketplace dedicado a vincular propietarios de espacios creativos con profesionales, empresas y marcas que buscan brindar una experiencia única. Que el espacio no sea una condición, sino una oportunidad.</p>
                        <ul class="post">
                            <li>Reuniones (workshop, presentación, offsite, curso)</li>
                            <li>Eventos (cocktails, festejos, activaciones, privados)</li>
                            <li>Producciones (fotográfica, audiovisual, escénica, moda)</li>
                            <li>Pop-ups (pop-up store, pop-up dinner, muestra de arte)</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 padding-leftright-null">
                <div data-responsive="child-height" data-responsive-id="dev" class="bg-img" style="background-image:url(assets/img/wimet-espacios-creativos-eventos-reuniones-producciones-popups-feature-1.png)"></div>
            </div>
        </div>
        <!--  Section with background image and overlay  -->
        <!-- Section same Height. Child get the parent Height. Set the same id -->
        <div class="row margin-leftright-null flex-order-md">
            <div class="col-md-6 padding-leftright-null flex-column-push-md">
                <div data-responsive="child-height" data-responsive-id="dev" class="bg-img" style="background-image:url(assets/img/wimet-espacios-creativos-eventos-reuniones-producciones-popups-feature-2.jpg)"></div>
            </div>
            <div class="col-md-6 padding-leftright-null flex-column-pull-md">
                <div data-responsive="parent-height" data-responsive-id="dev" class="text">
                    <h5 class="margin-bottom-null title left black">Descubre y alquila espacios creativos.</h5>
                    <div class="padding-onlytop-md content-post">
                        <p class="heading left margin-bottom grey">La interacción define nuestras vidas y los espacios potencian esas relaciones. Nuestra plataforma te permite tener acceso a espacios inexplorados y disponibles, ofreciendo extraordinarias instalaciones para tu evento, activación, producción, taller y proyecto personal en todas sus dimensiones.</p>
                        <ul class="post">
                            <li>Fácil de usar y confiable.</li>
                            <li>Reservas On-Demand.</li>
                            <li>Más opciones!</li>
                        </ul>    
                    </div>
                </div>
            </div>
        </div>
        <!--  Latest News  -->
    </div>
</div>
<!--  END Page Content, class footer-fixed if footer is fixed  -->
@endsection