@extends('layouts.universe', ['universe' => $universe])

@section('breadcrumbs', Breadcrumbs::render('universes.show', $universe))

@section('content')

    <div class="d-flex">
        <h1 class="flex-grow-1">
            @include('shared.edit-in-place', [
                'model' => $universe,
                'field' => 'label',
                'field_type' => 'text',
                'route' => ['universes.update', $universe->id],
            ])
        </h1>
        {!! Form::model($universe, ['route' => ['universes.edit', $universe->id], 'method' => 'GET']) !!}
        <button class="btn" role="button">
            <span class="oi oi-pencil" title="edit" aria-hidden="true"></span>
        </button>
        {!! Form::close() !!}
        {!! Form::model($universe, ['route' => ['universes.destroy', $universe->id], 'method' => 'DELETE']) !!}
        <button class="btn" role="button">
            <span class="oi oi-trash" title="trash" aria-hidden="true"></span>
        </button>
        {!! Form::close() !!}
    </div>

    @include('shared.edit-in-place', [
        'model' => $universe,
        'field' => 'description',
        'field_type' => 'textarea',
        'route' => ['universes.update', $universe->id],
    ])

@endsection

@section('sidebar')
    @include('shared.sidebar.'.$universe->type, ['universe' => $universe])
@endsection