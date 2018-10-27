@extends('layouts.app.'.$story->universe->type)

@section('breadcrumbs', Breadcrumbs::render('universes.stories.show', $story->universe, $story))

@section('content')

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">
                @if($story->universe->type === \App\Universe::TYPE_DIARY)
                    {{-- we only *display* the date of the day, as it can't be altered --}}
                    {{ $story->label }}
                @else
                    @include('shared.edit-in-place', [
                        'model' => $story,
                        'field' => 'label',
                        'field_type' => 'text',
                        'route' => ['universes.stories.update', $story->universe, $story],
                    ])
                @endif
            </h3>
            <p class="card-text">
                @include('shared.edit-in-place', [
                    'model' => $story,
                    'field' => 'description',
                    'field_type' => 'textarea',
                    'route' => ['universes.stories.update', $story->universe, $story],
                ])
            </p>
        </div>
        <div class="card-footer">
            <span title="{{ $story->created_at }}">created {{ $story->created_at->diffForHumans() }}</span>
            by {{ $story->created_by->name }}

            @include('shared.delete-in-place', [
               'model' => $story,
               'route' => ['universes.stories.destroy', $story->universe, $story],
           ])
        </div>
    </div>

    <hr/>

    @include('stories.comments', ['only' => ['story' => $story]])

@endsection

@section('sidebar')
    @include('shared.sidebar.'.$story->universe->type, ['universe' => $story->universe])
@endsection