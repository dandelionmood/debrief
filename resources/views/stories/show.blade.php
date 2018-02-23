@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('universes.stories.show', $story->universe, $story))

@section('content')

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">
                @include('shared.edit-in-place', [
                    'model' => $story,
                    'field' => 'label',
                    'field_type' => 'text',
                    'route' => ['universes.stories.update', $story->universe->id, $story->id],
                ])
            </h3>
            <p class="card-text">
                @include('shared.edit-in-place', [
                    'model' => $story,
                    'field' => 'description',
                    'field_type' => 'textarea',
                    'route' => ['universes.stories.update', $story->universe->id, $story->id],
                ])
            </p>
        </div>
        <div class="card-footer">
            <span title="{{ $story->created_at }}">created {{ $story->created_at->diffForHumans() }}</span> by {{ $story->created_by->name }}

            @include('shared.delete-in-place', [
               'model' => $story,
               'route' => ['universes.stories.destroy', $story->universe->id, $story->id],
           ])
        </div>
    </div>

    <hr/>

    @include('stories.comments', ['only' => ['story' => $story]])

    <a href="{{ route('universes.stories.index', $story->universe->id) }}">
        Back to this universe stories…
    </a>
@endsection

@section('sidebar')
    @include('shared.sidebar.stories-tree', ['universe' => $story->universe])
@endsection