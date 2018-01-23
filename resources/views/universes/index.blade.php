@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('universes'))

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>My universes</h1>

            @if($universes->isEmpty())
                <p><em>No universes for now!</em></p>
            @else
                <ul>
                    <?php /** @var App\Universe $univers */ ?>
                    @foreach($universes as $universe)
                        <li>
                            <a href="{{ route('universes.show', $universe->id) }}">{{ $universe->label }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <p>
                <a class="btn btn-primary" href="{{ route('universes.create') }}">Add a new one!</a>
            </p>
        </div>
@endsection
