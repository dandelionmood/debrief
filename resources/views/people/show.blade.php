@extends('layouts.universe')

@section('breadcrumbs', Breadcrumbs::render('universes.people.show', $universe, $person))

@section('content')

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">
                {{ $person->nickname }}
            </h3>
            <p class="card-text">
                @include('shared.edit-in-place', [
                    'model' => $person,
                    'field' => 'first_name',
                    'field_type' => 'text',
                    'route' => ['universes.people.update', $universe, $person],
                ])

                @include('shared.edit-in-place', [
                    'model' => $person,
                    'field' => 'last_name',
                    'field_type' => 'text',
                    'route' => ['universes.people.update', $universe, $person],
                ])

                @include('shared.edit-in-place', [
                    'model' => $person,
                    'field' => 'email',
                    'field_type' => 'email',
                    'route' => ['universes.people.update', $universe, $person],
                ])
            </p>
        </div>
        <div class="card-footer">
            @lang('<span title=":date_created_at">created :date_created_at_diff_human</span> by :creator_name', [
                'date_created_at' => $person->created_at,
                'date_created_at_diff_human' => $person->created_at->diffForHumans(),
                'creator_name' => $person->created_by->name
            ])
        </div>
    </div>

    @if($person->related_stories($universe)->count() > 0)
        <hr/>

        <h4>@lang('Mentioned in these stories:')</h4>
        <ul class="list-group">
            @foreach($person->related_stories($universe)->get() as $s)
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