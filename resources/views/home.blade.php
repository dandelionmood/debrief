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

    <hr />

    <h4>Preferences</h4>

    <div class="input-group">
        <div class="input-group-prepend">
            <label class="input-group-text" for="">@lang('Language')</label>
        </div>
        <select class="select_auto_url no-select-picker form-control">
            <option 
                @if(app()->getLocale() === 'fr') selected="selected" @endif 
                value="{{ route('change-locale', ['locale' => 'fr']) }}">
                🇫🇷 @lang('French')    
            </option>
            <option 
                @if(app()->getLocale() === 'en') selected="selected" @endif 
                value="{{ route('change-locale', ['locale' => 'en']) }}">
                🇬🇧 @lang('English')    
            </option>
        </select>
    </div>
    &nbsp;
    <div class="input-group">
        <div class="input-group-prepend">
            <label class="input-group-text" for="">@lang('Theme')</label>
        </div>
        <select class="select_auto_url no-select-picker form-control">
            @foreach(config('app.available_themes') as $k => $v)
                <option 
                    @if($k == session()->get('theme', 'theme-default.css')) selected="selected" @endif 
                    value="{{ route('change-theme', ['theme' => $k ]) }}">
                    {{ $v }}
                </option>
            @endforeach
        </select>
    </div>
@endsection
