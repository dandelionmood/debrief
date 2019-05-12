@extends('layouts.login')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="form-signin">
        {{ csrf_field() }}

        <h3>@lang('Please sign in')</h3>
        <label for="inputEmail" class="sr-only">@lang('Email address')</label>
        <input type="email" name="email" value="{{ old('email') }}" id="inputEmail" class="form-control"
               placeholder="@lang('Email address')" required autofocus>
        <label for="inputPassword" class="sr-only">@lang('Password')</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="@lang('Password')" required>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('Remember me')
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">@lang('Sign in')</button>
        <p class="mt-5 mb-3">
            <a href="{{ route('password.request') }}">
                @lang('Forgot Your Password?')
            </a>
        </p>
    </form>
@endsection
