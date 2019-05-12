@extends('layouts.app')

@section('favicon')
    @if(!empty($universe->picture_url))
        <link rel="shortcut icon" href="{{ $universe->picture_url }}">
    @endif
@endsection

@section('main')

    <!-- SIDEBAR -->
    <div class="col-xl-3 col-lg-4 bd-sidebar">

        <!-- NAV SYSTEM -->
        <div class="d-none d-lg-block bd-sidebar-content">

            <div class="header">
                @if(!empty($universe) && !empty($universe->picture_url))
                    <img class="img-fluid d-none d-lg-inline"
                         src="{{ $universe->picture_url }}"/>
                @endif
                <h2>{{ $universe->label }}</h2>
            </div>

            @yield('sidebar')
        </div>
        <!-- / NAV SYSTEM -->

        <!-- PLACEHOLDER FOR SMALL VIEWPOINTS -->
        <div class="d-block d-lg-none bd-sidebar-placeholder">
            <a href="javascript:void(0);" id="mobileNavToggle">
                <span class='oi oi-arrow-bottom' title='nav'
                      aria-hidden='true'></span>
                @lang('Show navigation menu')
            </a>
        </div>
        <!-- / PLACEHOLDER FOR SMALLER VIEWPOINTS -->

    </div>
    <!-- / SIDEBAR -->

    <!-- CONTENT -->
    <main class="col-xl-9 col-lg-8 bd-content">
        @if($errors->any())
            <div class="alert alert-danger">
                <h4>@lang('Errors')</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
    <!-- / CONTENT -->

@endsection