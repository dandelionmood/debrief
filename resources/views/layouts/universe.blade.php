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
            @yield('sidebar')
        </div>
        <!-- / NAV SYSTEM -->

        <!-- PLACEHOLDER FOR SMALL VIEWPOINTS -->
        <div class="d-block d-lg-none bd-sidebar-placeholder">
            <a href="javascript:void(0);" id="mobileNavToggle">
                <span class='oi oi-arrow-bottom' title='nav'
                      aria-hidden='true'></span>
                Show navigation menu
            </a>
        </div>
        <!-- / PLACEHOLDER FOR SMALLER VIEWPOINTS -->

    </div>
    <!-- / SIDEBAR -->

    <!-- CONTENT -->
    <main class="col-xl-9 col-lg-8 bd-content">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </main>
    <!-- / CONTENT -->

@endsection