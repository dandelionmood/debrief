@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('stories', $story->universe))

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>
                {{ $story->label }}

                {!! Form::model($story, ['route' => ['universes.stories.edit', $story->universe->id, $story->id], 'method' => 'GET']) !!}
                <button class="btn pull-right">
                    <i class="glyphicon glyphicon-pencil"></i>
                </button>
                {!! Form::close() !!}

                {!! Form::model($story, ['route' => ['universes.stories.destroy', $story->universe->id, $story->id], 'method' => 'DELETE']) !!}
                <button class="btn pull-right">
                    <i class="glyphicon glyphicon-trash"></i>
                </button>
                {!! Form::close() !!}
            </h1>

            <div class="markdown-content">
                {!! parsedown($story->description) !!}
            </div>

            <hr/>

            <a href="{{ route('universes.stories.index', $story->universe->id) }}">Back to this universe stories…</a>
        </div>
    </div>
@endsection
