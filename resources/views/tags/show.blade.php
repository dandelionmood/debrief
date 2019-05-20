@extends('layouts.universe')

@section('breadcrumbs', Breadcrumbs::render('universes.tags.show', $universe, $tag))

@section('content')

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">
                @lang("Settings for <code>:tag_label</code>", ['tag_label' => $tag->label])
            </h3>
            <p class="card-text">
                <h4>@lang('Label:')</h4>
                @include('shared.edit-in-place', [
                    'model'      => $tag,
                    'field'      => 'label',
                    'field_type' => 'text',
                    'route'      => ['universes.tags.update', $universe, $tag],
                    'show'       => true
                ])

                <hr />

                <h4>@lang('Colour:')</h4>
                @include('shared.edit-in-place', [
                    'model'      => $tag,
                    'field'      => 'colour',
                    'field_type' => 'color',
                    'route'      => ['universes.tags.update', $universe, $tag],
                    'show'       => true
                ])
            </p>
        </div>
        <div class="card-footer">
            @lang('<span title=":date_created_at">created :date_created_at_diff_human</span> by :creator_name', [
                'date_created_at'            => $tag->created_at,
                'date_created_at_diff_human' => $tag->created_at->diffForHumans(),
                'creator_name'               => $tag->created_by->name
            ])
        </div>
    </div>

    @if($tag->related_stories($universe)->count() > 0)
        <hr/>

        <h4>@lang('Mentioned in these stories:')</h4>
        <ul class="list-group">
            @foreach($tag->related_stories($universe)->get() as $s)
                <li class="list-group-item">
                    <a href="{{ $s->link() }}">{{ $s->label }}</a>
                    <span class="text-muted">
                        @lang('(last updated :date_updated_at_diff_human)', [
                            'date_updated_at_diff_human' => $s->updated_at->diffForHumans(),
                        ])
                    </span>
                </li>
            @endforeach
        </ul>
    @endif

@endsection

@section('sidebar')
    @include('shared.sidebar.'.$universe->type, ['universe' => $universe])
@endsection