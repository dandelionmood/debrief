@extends('layouts.login')

@section('content')
    <form method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <h1 class="h3 mb-3 font-weight-normal">@lang('Reset Password')</h1>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="control-label">@lang('E-Mail Address')</label>

            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                @lang('Send password reset link')
            </button>
        </div>
    </form>
@endsection
