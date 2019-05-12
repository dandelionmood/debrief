<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>{{ config('app.name', 'Debrief') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

    @section('favicon')
        {{-- no default favicon, will change for each universe --}}
    @show
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
