@extends('layouts.staticwebs')

@section('title', 'Prensa')

@section('content')
<!--  Page Content, class footer-fixed if footer is fixed  -->
<div id="page-content" class="header-static footer-fixed">
    <!--  Slider  -->
    <div id="flexslider-nav" class="fullpage-wrap small">
        <ul class="">
            <li style="background-image:url(assets/img/wimet-espacios-creativos-eventos-reuniones-producciones-popups-partner-workshops-bg.jpg)">
                <div class="text">
                    <h4 class="white big flex-animation">dejemos de ser extraños</h4>
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
        <!--  Latest News  -->
        <div id="news" class="text white-background">
            <div class="row padding-md-bottom">
                <div class="col-md-12 padding-leftright-null text-center">
                    <h2 class="margin-bottom-null title">PRENSA</h2>
                    <div class="padding-md">
                        <p class="heading ">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime veniam voluptatibus, illo aliquid magni itaque dolorum laborum temporibus.</p>
                        <a href="blog-masonry-sidebar" class="btn-alt active shadow small margin-null">Descargar Kit de Prensa </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END Page Content, class footer-fixed if footer is fixed  -->
@endsection