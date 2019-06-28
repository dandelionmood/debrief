<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Page title -->
    <title>
        {{ ($breadcrumbs = Breadcrumbs::generate()) ? $breadcrumbs
            ->slice(-2, 2)
            ->map(function($breadcrumb) { 
                return $breadcrumb->title; 
            })
            ->implode(' / ') : '' }} — {{ config('app.name', 'Debrief') }}
    </title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

    <!-- generated favicon html -->
    <!-- courtesy of https://realfavicongenerator.net/ -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('icons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('icons/site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ url('icons/favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-config" content="{{ url('icons/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- / generated favicon html -->

</head>
<body class="">

@yield('body')

<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<!-- Scripts -->
<script>
    const URL_FILE_UPLOAD = '{{ route('file-upload') }}';
    Lang.setLocale("{{ App::getLocale() }}");
</script>

</body>
</html>
