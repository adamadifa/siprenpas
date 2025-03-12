<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Dashboard</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/css/styleform.css') }}">

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper-bundle.min.css') }}" />
    <style>
        :root {
            --fimobile-green: #3ac79b;
            --fimobile-red: #f73563;
            --fimobile-yellow: #ffbd17;
            --fimobile-blue: #3c63e2;
            --fimobile-rounded: 15px;
            --fimobile-padding: 15px;
            --bs-gutter-x: var(--fimobile-padding);
            --fimobile-input-rounded: 10px;
            /* radial gradient colors */
            --fimobile-theme-color-grad-1: #2bc277;
            --fimobile-theme-color-grad-2: #32745e;
            --fimobile-theme-color-grad-3: #32745e;
            /* color schemes */
            --fimobile-theme-color: #092c9f;
            --fimobile-theme-color-2: #001c77;
            --fimobile-theme-color-light: #d3ddfd;
            --fimobile-theme-bordercolor: #dadff6;
            --fimobile-theme-text: #ffffff;
            --fimobile-header: transparent;
            --fimobile-header-active: #ffffff;
            --fimobile-header-text: #000000;
            --fimobile-footer: #ffffff;
            --fimobile-footer-text: #999999;
            --fimobile-footer-text-active: var(--fimobile-theme-color);
            --fimobile-sidebar: var(--fimobile-theme-color);
            --fimobile-sidebar-text: #ffffff;
            --fimobile-sidebar-text-active: #ffffff;
            --fimobile-card-color: rgba(255, 255, 255, 0.85);
            --fimobile-card-text: #000000;
            --fimobile-page-bg-1: #f1f3f8;
            --fimobile-page-bg-2: #e5ecfe;
            --fimobile-page-text: #000000;
            --fimobile-page-link: var(--fimobile-theme-color);
        }

        .historicontent {
            display: flex;
            justify-content: space-between;
            padding: 20px
        }

        .historibordergreen {
            border: 1px solid #32745e;
        }

        .historiborderred {
            border: 1px solid rgb(171, 18, 18);
        }

        .historidetail1 {
            display: flex;
        }

        .historidetail2 h4 {
            margin-bottom: 0;
        }



        .datepresence {
            margin-left: 10px;
        }

        .datepresence h4 {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 0;
        }

        .timepresence {
            font-size: 14px;
        }



        .card.theme-bg,
        .card.dark-bg,
        .card.bg-danger,
        .card.bg-success,
        .card.bg-primary,
        .card.bg-warning,
        .card.bg-info,
        .card.bg-dark,
        .card.bg-opac {
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.07), inset 0 1px 0px rgba(255, 255, 255, 0.18);
            -webkit-box-shadow: 0 3px 10px rgba(0, 0, 0, 0.07), inset 0 1px 0px rgba(255, 255, 255, 0.18);
            -moz-box-shadow: 0 3px 10px rgba(0, 0, 0, 0.07), inset 0 1px 0px rgba(255, 255, 255, 0.18);
            background-color: #086c29;
            color: #ffffff;

        }

        .cardswiper .swiper-wrapper .swiper-slide:first-child {
            padding-left: var(--fimobile-padding);
        }

        .cardswiper .swiper-wrapper .swiper-slide {
            width: 270px;
            padding: 0 5px 10px 15px;
        }

        .theme-radial-gradient {
            background: var(--fimobile-theme-color-grad-1);
            background: -moz-radial-gradient(30% 30%, ellipse cover, var(--fimobile-theme-color-grad-1) 0%, var(--fimobile-theme-color-grad-2) 50%, var(--fimobile-theme-color-grad-3) 100%);
            background: -webkit-radial-gradient(30% 30%, ellipse cover, var(--fimobile-theme-color-grad-1) 0%, var(--fimobile-theme-color-grad-2) 50%, var(--fimobile-theme-color-grad-3) 100%);
            background: radial-gradient(ellipse at 30% 30%, var(--fimobile-theme-color-grad-1) 0%, var(--fimobile-theme-color-grad-2) 50%, var(--fimobile-theme-color-grad-3) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='var(--fimobile-theme-color-grad-1)', endColorstr='var(--fimobile-theme-color-grad-3)', GradientType=1);
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    {{-- <style>
        .selectmaterialize,
        textarea {
            display: block;
            background-color: transparent !important;
            border: 0px !important;
            border-bottom: 1px solid #9e9e9e !important;
            border-radius: 0 !important;
            outline: none !important;
            height: 3rem !important;
            width: 100% !important;
            font-size: 16px !important;
            margin: 0 0 8px 0 !important;
            padding: 0 !important;
            color: #495057;

        }

        textarea {
            height: 80px !important;
            color: #495057 !important;
            padding: 20px !important;
        }
    </style> --}}
</head>
<style>
    body {
        touch-action: manipulation !important
    }
</style>

<body>

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    @yield('header')

    <!-- App Capsule -->
    <div id="appCapsule">
        @yield('content')
    </div>
    <!-- * App Capsule -->


    @include('layouts.mobile.bottomNav')


    @include('layouts.mobile.script')




</body>

</html>
