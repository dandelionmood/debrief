@extends('layouts.base')

@section('body')
    <div class="container-fluid">

        @include('shared.flashes')

        <div class="row justify-content-between bd-header">
            @yield('breadcrumbs')
            <div class="breadcrumb">
                <a class="flag" href="{{ route('change-locale', ['locale' => 'fr', 'callback' => url()->current()]) }}">🇫🇷</a>
                <a class="flag" href="{{ route('change-locale', ['locale' => 'en', 'callback' => url()->current()]) }}">🇬🇧</a>

                @if(\Auth::check())
                    <form method="post" action="{{ route('logout') }}">
                        {{ csrf_field() }}
                        <a href="javascript:void(0);" onclick="$(this).parents('form:eq(0)').trigger('submit');">
                            <span class="d-none d-xl-inline">@lang('Logged in as :name', ['name' => Auth::user()->name])</span>
                            <span class="oi oi-circle-x" title="disconnect" aria-hidden="true"></span>
                        </a>
                    </form>
                @endif
            </div>
        </div>

        <main class="row">
            @section('main')
                @yield('content')
            @show
        </main>
    </div>
@endsection