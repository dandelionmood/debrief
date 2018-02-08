@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @component('shared.panel')
                    @slot('heading')Navigation @endslot
                    <a href="{{ route('universes.index') }}">My universes</a>
                @endcomponent
            </div>
        </div>
    </div>
@endsection
