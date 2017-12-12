<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
        <meta name="google-site-verification" content="A6bEbj0anLR76S8r9y2oG_7UMuN6YUn4-hYL-ZZFLvs" />

        <title>{{ config('app.name', 'Laravel') }} - Publica tu espacio</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">

        <link rel="stylesheet" href="/css/basic.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <script src="https://apis.google.com/js/api:client.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUp-A4EcLNbPonxHhbySVWpP9kzZQQUw&callback&libraries=places"></script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-77438674-1', 'auto');
            ga('send', 'pageview');
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
    </head>
    <body>
        <div id="publica-espacio">
            <!-- Header Home -->
            <wimet-login fixed="false"></wimet-login>
            <!-- main -->
            <main>
                <publica-index></publica-index>
            </main>
        </div>
        <script type="text/javascript">
            goog_snippet_vars = function() {
                var w = window;
                w.google_conversion_id = 873274183;
                w.google_conversion_label = "l11oCKTliXQQx7a0oAM";
                w.google_remarketing_only = false;
            }
            // DO NOT CHANGE THE CODE BELOW.
            goog_report_conversion = function(url) {
                goog_snippet_vars();
                window.google_conversion_format = "3";
                var opt = new Object();
                opt.onload_callback = function() {
                    if (typeof(url) != 'undefined') {
                        window.location = url;
                    }
                }
                var conv_handler = window['google_trackConversion'];
                if (typeof(conv_handler) == 'function') {
                    conv_handler(opt);
                }
            }
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion_async.js"></script>
        <script src="{{url('/js/publica.js')}}"></script>
        <!-- Start of HubSpot Embed Code -->
        <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/2880578.js"></script>
        <!-- End of HubSpot Embed Code -->
    </body>
</html>