@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('universes.stories.show', $story->universe, $story))

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>
                @include('shared.edit-in-place', [
                    'model' => $story,
                    'field' => 'label',
                    'field_type' => 'text',
                    'route' => ['universes.stories.update', $story->universe->id, $story->id],
                ])

                @include('shared.delete-in-place', [
                    'model' => $story,
                    'route' => ['universes.stories.destroy', $story->universe->id, $story->id],
                ])
            </h1>

            @include('shared.edit-in-place', [
                'model' => $story,
                'field' => 'description',
                'field_type' => 'textarea',
                'route' => ['universes.stories.update', $story->universe->id, $story->id],
            ])

            <hr/>

            <h2>Comments</h2>

            @include('stories.comments', ['only' => ['story' => $story]])

            <a href="{{ route('universes.stories.index', $story->universe->id) }}">
                Back to this universe stories…
            </a>
        </div>
    </div>
@endsection

@section('sidebar')
    @include('shared.sidebar.stories-tree', ['universe' => $story->universe])
@endsection