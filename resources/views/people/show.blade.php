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
            <span title="{{ $person->created_at }}">created {{ $person->created_at->diffForHumans() }}</span>
            by {{ $person->created_by->name }}
        </div>
    </div>

    @if($person->related_stories($universe)->count() > 0)
        <hr/>

        <h5>Mentioned in these stories:</h5>
        <ul>
            @foreach($person->related_stories($universe)->get() as $s)
                <li><a href="{{ $s->link() }}">{{ $s->label }}</a></li>
            @endforeach
        </ul>
    @endif

@endsection

@section('sidebar')
    @include('shared.sidebar.'.$universe->type, ['universe' => $universe])
@endsection