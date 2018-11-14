@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('universes.index'))

@section('content')
    <div class="container">
        <h1>
            Your universes
            <a class="btn btn-primary" href="{{ route('universes.create') }}">
                <span class="oi oi-plus" title="add" aria-hidden="true" aria-label="Add a new one!"></span>
            </a>
        </h1>

        @if($universes->isEmpty())
            <p><em>No universes for now!</em></p>
        @else
            <div class="list-group">
                <?php /** @var App\Universe $univers */ ?>
                @foreach($universes as $universe)
                    <div class="card flex-md-row mb-3">
                        @if(!empty($universe->picture_url))
                            <a class="d-none d-md-block w-25" href="{{ route('universes.show', [$universe->id]) }}">
                                <img class="img-fluid" alt="user avatar"
                                     src="{{ $universe->picture_url }}">
                            </a>
                        @endif
                        <div class="card-body d-flex flex-column align-items-start">
                            <h3 class="mb-0">
                                <a href="{{ route('universes.show', [$universe->id]) }}">
                                    {{ $universe->label }}</a>
                                @if($universe->type === \App\Universe::TYPE_DIARY)
                                    <span class="badge badge-pill badge-secondary">Diary</span>
                                @elseif($universe->type === \App\Universe::TYPE_WIKI)
                                    <span class="badge badge-pill badge-secondary">Wiki</span>
                                @endif
                            </h3>
                            <div class="mb-2 text-muted">
                                {!! parsedown($universe->description) !!}
                            </div>

                            {!! Form::model($universe, ['route' => ['universes.edit', $universe], 'method' => 'GET']) !!}
                            <button type="submit" class="btn btn-sm btn-secondary">
                                <span class="oi oi-pencil" title="edit" aria-hidden="true"></span>
                            </button>
                            {!! Form::close() !!}
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection
