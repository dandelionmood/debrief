@extends('layouts.login')

@section('content')
    <div class="list-group">
        <a class="list-group-item"
           href="{{ route('universes.index') }}">@lang('My universes')
        </a>
        @can('manage-users')
            <a class="list-group-item"
               href="{{ route('users.index') }}">@lang('User management')
            </a>
        @endcan
    </div>
    &nbsp;
    <div class="list-group">
        <a class="list-group-item"
            href="{{ route('change-locale', ['locale' => 'fr']) }}">
            🇫🇷 @lang('Switch to French')
        </a>
        <a class="list-group-item"
            href="{{ route('change-locale', ['locale' => 'en']) }}">
            🇬🇧 @lang('Switch to English')
        </a>
    </div>
@endsection
