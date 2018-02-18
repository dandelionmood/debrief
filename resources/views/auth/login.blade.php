@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="form-signin">
        {{ csrf_field() }}

        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" value="{{ old('email') }}" id="inputEmail" class="form-control"
               placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3">
            <a href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
        </p>
    </form>
@endsection
