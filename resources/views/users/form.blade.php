@extends('layouts.user', ['universe' => $user])

@if(empty($user->id))
    @section('breadcrumbs', Breadcrumbs::render('users.create'))
@else
    @section('breadcrumbs', Breadcrumbs::render('users.edit', $user))
@endif

@section('content')
    @if(empty($user->id))
        <h1>Add a new user</h1>
    @else
        <h1>Edit this user</h1>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(empty($user->id))
        {!! Form::model($user, ['route' => 'users.store', 'files' => true]) !!}
    @else
        {!! Form::model($user, ['route' => ['users.update', $user], 'method' => 'PUT', 'files' => true]) !!}
    @endif

    <div class="form-group">
        {!! Form::label('name', "Name:") !!}
        {!! Form::text('name', null, ['class' => 'form-control input-lg']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('email', "Email:") !!}
        {!! Form::email('email', null, ['class' => 'form-control input-lg']) !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('is_admin', null, null, ['class' => '']) !!}
        {!! Form::label('is_admin', "Is admin?", ['class' => 'form-label']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('password', "Password:") !!}
        {!! Form::password('password', ['class' => 'form-control input-lg']) !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control input-lg']) !!}
    </div>
    <div class="form-group">
        <div class="row col-12">
            <div class="col-sm-10">
                {!! Form::label('picture', "Picture (optional):") !!}
                {!! Form::file('picture', ['class' => 'form-control-file']) !!}
            </div>
            <div class="col-sm-2">
                @if(!empty($user->id) && !empty($user->picture_url))
                    <img class="img-fluid" src="{{ $user->picture_url }}" />
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        @if(empty($user->id))
            {!! Form::submit('Save!') !!}
        @else
            {!! Form::submit('Update!') !!}
        @endif
    </div>

    {!! Form::close() !!}
@endsection