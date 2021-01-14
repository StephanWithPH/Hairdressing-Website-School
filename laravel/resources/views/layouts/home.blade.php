<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GE81V4JQ14"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-GE81V4JQ14');
    </script>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body data-spy="scroll" data-target=".navbar-nav" data-offset="100">
    <div id="app">
        <div class="container mt-4 mb-4">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <img class="w-100" src="{{ asset('img/logo_transparent.png') }}"/>
                </div>
            </div>
        </div>


        <nav class="navbar navbar-expand-md navbar-dark bg-primary mb-5 sticky-top shadow">
            <div class="container">
                {{--<a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>--}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Center of navbar -->
                    <ul class="navbar-nav ml-auto mr-auto">
                        <li class="nav-item">
                            <a onclick="scrollToAnchor('aboutus')" class="nav-link active" href="#aboutus">{{ __('Over ons') }}</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="scrollToAnchor('ourspecialisation')" class="nav-link" href="#ourspecialisation">{{ __('Onze specialisatie') }}</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="scrollToAnchor('treatments')" class="nav-link" href="#treatments">{{ __('Behandelingen') }}</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="scrollToAnchor('bookappointment')" class="nav-link" href="#bookappointment">{{ __('Reserveren') }}</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="scrollToAnchor('contact')" class="nav-link" href="#contact">{{ __('Contact') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="w-100 bg-primary">
            <div class="container pt-4 pb-2">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h2 class="text-white">Links</h2>
                        <ul class="list-unstyled text-white">
                            <li><a href="#aboutus" class="text-white">Over ons</a></li>
                            <li><a href="#ourspecialisation" class="text-white">Onze specialisatie</a></li>
                            <li><a href="#treatments" class="text-white">Behandelingen</a></li>
                            <li><a href="#bookappointment" class="text-white">Reserveren</a></li>
                            <li><a href="{{ asset('pdf/privacy_statement.pdf') }}" target="_blank" class="text-white">Privacy statement</a></li>
                            <li><a href="{{ route('login') }}" class="text-white">Inloggen</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h2 class="text-white">Contact</h2>
                        <iframe class="w-100 d-none d-md-block" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19690.297625486164!2d5.564022946234518!3d51.91047097527989!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c6559a089c5115%3A0x95bf92fbfda02b69!2sOchten!5e0!3m2!1snl!2snl!4v1606733825219!5m2!1snl!2snl" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        <ul class="list-unstyled text-white d-block d-md-none">
                            <li><a class="text-white">Ochtenlaan 1</a></li>
                            <li><a class="text-white">4000AA Ochten</a></li>
                            <li><a href="tel:+31612345678" class="text-white">Tel: 0612345678</a></li>
                            <li><a href="mailto:contact@knip-it.nl" class="text-white">Email: contact@knip-it.nl</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row justify-content-center bg-secondary">
                    <div class="col-md-4">
                        <p class="pt-2 pb-2 mb-0 text-white text-center">Copyright {{ now()->year }} {{ env('APP_NAME') }} - Alle rechten voorbehouden</p>
                    </div>
                </div>
            </div>
        </footer>
        <div class="fixed-bottom">
            @include('cookieConsent::index')
        </div>
    </div>
    @yield('scripts')
</body>
</html>
