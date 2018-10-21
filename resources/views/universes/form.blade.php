@extends('layouts.app')

@if(empty($universe->id))
    @section('breadcrumbs', Breadcrumbs::render('universes.create'))
@else
    @section('breadcrumbs', Breadcrumbs::render('universes.edit', $universe))
@endif

@section('content')
    @if(empty($universe->id))
        <h1>Add a new universe</h1>
    @else
        <h1>Edit this universe</h1>
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

    @if(empty($universe->id))
        {!! Form::model($universe, ['route' => 'universes.store', 'files' => true]) !!}
    @else
        {!! Form::model($universe, ['route' => ['universes.update', $universe->id], 'method' => 'PUT', 'files' => true]) !!}
    @endif

    <div class="form-group">
        {!! Form::label('label', "Label:") !!}
        {!! Form::text('label', null, ['class' => 'form-control input-lg']) !!}

        {!! Form::label('description', "Description:") !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}

        <div class="row">
            <div class="col-md-10">
                {!! Form::label('picture', "Picture (optional):") !!}
                {!! Form::file('picture', ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-2">
                @if(!empty($universe->id) && !empty($universe->picture_url))
                    <img class="img-fluid" src="{{ $universe->picture_url }}" />
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        @if(empty($universe->id))
            {!! Form::submit('Save!') !!}
        @else
            {!! Form::submit('Update!') !!}
        @endif
    </div>

    {!! Form::close() !!}
@endsection
