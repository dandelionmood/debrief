@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('universes.index'))

@section('content')
    <div class="container">
        <h1>Your universes</h1>

        <div class="col-12 row">
            @if($universes->isEmpty())
                <p><em>No universes for now!</em></p>
            @else
                <div class="card-columns">
                    <?php /** @var App\Universe $univers */ ?>
                    @foreach($universes as $universe)
                        <div class="card border-light">
                            @if(!empty($universe->picture_url))
                                <img class="card-img-top img-fluid img-rounded"
                                     src="{{ $universe->picture_url }}"
                                     alt="Universe picture">
                            @endif

                            <div class="card-body">
                                <h3 class="card-title">{{ $universe->label }}</h3>
                                <p class="card-text">{{ str_limit($universe->description, 100) }}</p>
                                <a href="{{ route('universes.show', [$universe->id]) }}"
                                   class="btn btn-primary">Go there!</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-12 row">
            <p>
                <a class="btn btn-primary"
                   href="{{ route('universes.create') }}">Add a new one!</a>
            </p>
        </div>
    </div>
@endsection
