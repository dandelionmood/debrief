@extends('layouts.universe', ['universe' => $story->universe])

@section('breadcrumbs', Breadcrumbs::render('universes.stories.show', $story->universe, $story))

@section('content')

    <div class="row">
        <div class="col-12 col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h1>
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
                        </h1>
                    </div>
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
                    @lang('<span title=":date_created_at">created :date_created_at_diff_human</span> by :creator_name', [
                        'date_created_at' => $story->created_at,
                        'date_created_at_diff_human' => $story->created_at->diffForHumans(),
                        'creator_name' => $story->created_by->name
                    ])

                    @include('shared.delete-in-place', [
                       'model' => $story,
                       'route' => ['universes.stories.destroy', $story->universe, $story],
                   ])
                </div>
            </div>

            @include('stories.comments', ['only' => ['story' => $story]])

        </div>

        <div class="col-12 col-lg-4 col-xl-3">
            @if($story->related_stories->count() > 0)
                <h4>@lang('Related stories')</h4>
                <ul class="list-group">
                    @foreach($story->related_stories as $s)
                        <li class="list-group-item">
                            <a href="{{ $s->link() }}" title="@lang('Last updated :date_updated_at_diff_human', [
                                'date_updated_at_diff_human' => $s->updated_at->diffForHumans(),
                            ])">
                                {{ $s->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <hr/>
            @endif

            @if($story->mentioned_people->count() > 0)
                <h4>@lang('Mentioned people')</h4>
                <ul class="list-group">
                    @foreach($story->mentioned_people as $p)
                        <li class="list-group-item">
                            <a href="{{ $p->link($story->universe) }}">
                                {{ $p->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

@endsection

@section('sidebar')
    @include('shared.sidebar.'.$story->universe->type, ['universe' => $story->universe])
@endsection