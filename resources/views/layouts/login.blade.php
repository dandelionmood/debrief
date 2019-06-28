@extends('layouts.base')

@section('body')
    <div class="container login">
    @include('shared.flashes')
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <h1>
                    <img class="img-fluid" 
                        src="{{ url('icons/android-chrome-192x192.png') }}" 
                        alt="icon" />
                    {{ config('app.name', 'Debrief') }}
                </h1>
                @yield('content')
            </div>
        </div>
    </div>
@endsection