@extends('layouts.base')

@section('body')
    <div class="container-fluid">
        <div class="row flex-xl-nowrap bd-breadcrumbs">
            <nav class="col-12 bd-header" aria-label="breadcrumb">
                @yield('breadcrumbs')
            </nav>
        </div>

            <main class="col-12 row bd-content">
                @section('main')
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @yield('content')
                @show
            </main>
    </div>
@endsection