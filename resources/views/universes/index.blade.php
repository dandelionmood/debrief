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
                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="row">

                                <div class="d-none d-md-block col-md-3 col-lg-4">
                                    @if(!empty($universe->picture_url))
                                        <a href="{{ route('universes.show', [$universe->id]) }}">
                                            <img class="img-fluid" alt="user avatar"
                                                 src="{{ $universe->picture_url }}">
                                        </a>
                                    @endif
                                </div>

                                <div class="col-md-9 col-lg-8">

                                    <div class="d-flex">
                                        <h3 class="flex-grow-1">
                                            <a href="{{ route('universes.show', [$universe->id]) }}">
                                                {{ $universe->label }}</a>
                                            @if($universe->type === \App\Universe::TYPE_DIARY)
                                                <span class="badge badge-pill badge-secondary">Diary</span>
                                            @elseif($universe->type === \App\Universe::TYPE_WIKI)
                                                <span class="badge badge-pill badge-secondary">Wiki</span>
                                            @endif
                                        </h3>
                                        {!! Form::model($universe, ['route' => ['universes.edit', $universe], 'method' => 'GET']) !!}
                                        <button type="submit" class="btn btn-sm btn-secondary">
                                            <span class="oi oi-pencil" title="edit" aria-hidden="true"></span>
                                        </button>
                                        {!! Form::close() !!}
                                    </div>


                                    <div class="mb-2 markdown-content">
                                        {!! parsedown($universe->description) !!}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection
