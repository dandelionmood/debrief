@extends('layouts.admin', ['universe' => $user])

@if(empty($user->id))
    @section('breadcrumbs', Breadcrumbs::render('users.create', $user))
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
        {!! Form::checkbox('is_admin', null, null, ['class' => '', 'id' => 'is_admin']) !!}
        {!! Form::label('is_admin', "Is admin?", ['class' => 'form-label']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('password', "Password:") !!}
        {!! Form::password('password', ['class' => 'form-control input-lg', 'autocomplete' => 'new-password']) !!}
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2">
                @if(!empty($user->id) && !empty($user->picture_url))
                    <img alt="user avatar" class="img-fluid" src="{{ $user->picture_url }}"/>
                @endif
            </div>
            <div class="col-sm-10">
                {!! Form::label('picture', "Picture (optional):") !!}
                {!! Form::file('picture', ['class' => 'form-control-file']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('universes', "Universes:") !!}
        {!! Form::select('universes[]', \App\Universe::getForSelect(), null, ['class' => 'form-control', 'multiple' => true]) !!}
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