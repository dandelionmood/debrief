@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('universes.show', $universe))

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>
                @include('shared.edit-in-place', [
                    'model' => $universe,
                    'field' => 'label',
                    'field_type' => 'text',
                    'route' => ['universes.update', $universe->id],
                ])

                {!! Form::model($universe, ['route' => ['universes.edit', $universe->id], 'method' => 'GET']) !!}
                <button class="btn pull-right">
                    <i class="glyphicon glyphicon-pencil"></i>
                </button>
                {!! Form::close() !!}

                {!! Form::model($universe, ['route' => ['universes.destroy', $universe->id], 'method' => 'DELETE']) !!}
                <button class="btn pull-right">
                    <i class="glyphicon glyphicon-trash"></i>
                </button>
                {!! Form::close() !!}
            </h1>

            @include('shared.edit-in-place', [
                'model' => $universe,
                'field' => 'description',
                'field_type' => 'textarea',
                'route' => ['universes.update', $universe->id],
            ])

            <hr/>

            <a href="{{ route('universes.stories.index', $universe->id) }}">See all the related stories…</a>
        </div>
    </div>
@endsection

@section('sidebar')
    @include('shared.sidebar.stories-tree', ['universe' => $universe])
@endsection