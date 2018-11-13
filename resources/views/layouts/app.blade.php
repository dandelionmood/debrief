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

        <div class="row justify-content-between bd-header">
            @yield('breadcrumbs')
            <div class="breadcrumb">
                @if(\Auth::check())
                    <form method="post" action="{{ route('logout') }}">
                        {{ csrf_field() }}
                        <a href="javascript:void(0);" onclick="$(this).parents('form:eq(0)').trigger('submit');">
                            <span class="d-none d-xl-inline">Logged in as {{ Auth::user()->name }}</span>
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