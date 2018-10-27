@extends('layouts.app')

@section('main')
    <div class="col-12 col-md-2 col-xl-2 d-none d-sm-block bd-sidebar">
        @yield('sidebar')
    </div>
    <main class="col-12 col-md-10 col-xl-10 py-md-3 pl-md-5 bd-content">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </main>
@endsection