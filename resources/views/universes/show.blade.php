@extends('layouts.universe', ['universe' => $universe])

@section('breadcrumbs', Breadcrumbs::render('universes.show', $universe))

@section('content')

    <div class="row">
        <div class="col-10">
            <h1>
                @include('shared.edit-in-place', [
                    'model' => $universe,
                    'field' => 'label',
                    'field_type' => 'text',
                    'route' => ['universes.update', $universe->id],
                ])
            </h1>
        </div>
        <div class="col-1" style="text-align: right;">
            {!! Form::model($universe, ['route' => ['universes.edit', $universe->id], 'method' => 'GET']) !!}
            <button class="btn">
                <span class="oi oi-pencil" title="edit" aria-hidden="true"></span>
            </button>
            {!! Form::close() !!}
        </div>
        <div class="col-1" style="text-align: right;">
            {!! Form::model($universe, ['route' => ['universes.destroy', $universe->id], 'method' => 'DELETE', 'class' => 'form-inline']) !!}
            <button class="btn">
                <span class="oi oi-trash" title="trash" aria-hidden="true"></span>
            </button>
            {!! Form::close() !!}
        </div>
    </div>

    @include('shared.edit-in-place', [
        'model' => $universe,
        'field' => 'description',
        'field_type' => 'textarea',
        'route' => ['universes.update', $universe->id],
    ])

    <hr/>

    <a href="{{ route('universes.stories.index', $universe->id) }}">See all the related stories…</a>

@endsection

@section('sidebar')
    @include('shared.sidebar.'.$universe->type, ['universe' => $universe])
@endsection