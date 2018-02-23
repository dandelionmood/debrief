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
        {!! Form::model($universe, ['route' => 'universes.store']) !!}
    @else
        {!! Form::model($universe, ['route' => ['universes.update', $universe->id], 'method' => 'PUT']) !!}
    @endif

    <div class="form-group">
        {!! Form::label('label', "Label:") !!}
        {!! Form::text('label', null, ['class' => 'form-control input-lg']) !!}

        {!! Form::label('description', "Description:") !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
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
