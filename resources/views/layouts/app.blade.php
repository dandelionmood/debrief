@extends('layouts.base')

@section('body')
    <div class="container-fluid">
        <div class="row flex-xl-nowrap bd-breadcrumbs">
            <nav class="col-12 bd-header" aria-label="breadcrumb">
                @yield('breadcrumbs')
            </nav>
        </div>

        <div class="row flex-xl-nowrap">

            @hasSection('sidebar')
                {{-- SIDEBAR MODE --}}

                <div class="col-12 col-md-4 col-xl-4 d-none d-sm-block bd-sidebar">
                    @yield('sidebar')
                </div>
                <main class="col-12 col-md-8 col-xl-8 py-md-3 pl-md-5 bd-content">
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @yield('content')
                </main>

            @else
                {{-- NO SIDEBAR MODE --}}
                <main class="col-12  bd-content">
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @yield('content')
                </main>
            @endif

        </div>
    </div>
@endsection