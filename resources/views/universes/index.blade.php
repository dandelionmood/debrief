@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('universes.index'))

@section('content')

    <div class="container">
        <div class="row">
            @if($universes->isEmpty())
                <p><em>No universes for now!</em></p>
            @else
                <?php /** @var App\Universe $univers */ ?>
                @foreach($universes as $universe)
                    <div class="col-md-3">
                        @component('shared.panel')
                            @slot('heading')
                                <a href="{{ route('universes.show', $universe->id) }}">{{ $universe->label }}</a>
                                {!! Form::model($universe, ['class' => 'pull-right', 'route' => ['universes.edit', $universe->id], 'method' => 'GET']) !!}
                                <button class="btn btn-sm">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </button>
                                {!! Form::close() !!}
                            @endslot
                            <ul class="list-unstyled">
                                @foreach($universe->stories->take(5) as $story)
                                    <li>
                                        <a href="{{ route('universes.stories.show', [$universe->id, $story->id]) }}">»&nbsp;{{ $story->label }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <p>
                                <a href="{{ route('universes.stories.index', [$universe->id]) }}">See all stories…</a>
                            </p>
                        @endcomponent
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <p>
                    <a class="btn btn-primary" href="{{ route('universes.create') }}">Add a new one!</a>
                </p>
            </div>
        </div>
    </div>
@endsection
