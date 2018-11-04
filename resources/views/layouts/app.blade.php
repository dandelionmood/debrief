@extends('layouts.base')

@section('body')
    <div class="container-fluid">

        @if(session()->has('success'))
            <div class="row bd-flash-messages">
                <div class="col-12 success alert-success">
                    {{ session()->get('success') }}
                </div>
            </div>
        @endif

        <div class="row flex-xl-nowrap bd-header">
            @yield('breadcrumbs')
        </div>

        <main class="row">
            @section('main')
                @yield('content')
            @show
        </main>
    </div>
@endsection