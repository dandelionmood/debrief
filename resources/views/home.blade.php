@extends('layouts.login')

@section('content')
    <div class="list-group">
        <a class="list-group-item"
           href="{{ route('universes.index') }}">My universes
        </a>
        @can('manage-users')
            <a class="list-group-item"
               href="{{ route('users.index') }}">User management
            </a>
        @endcan
    </div>
@endsection
