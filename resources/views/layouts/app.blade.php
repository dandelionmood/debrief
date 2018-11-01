@extends('layouts.base')

@section('body')
    <div class="container-fluid">

        <div class="row flex-xl-nowrap bd-header">
            @yield('breadcrumbs')
        </div>

        <main class="row">
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