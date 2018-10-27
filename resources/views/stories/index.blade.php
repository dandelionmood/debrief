@extends('layouts.app.'.$universe->type)

@section('breadcrumbs', Breadcrumbs::render('universes.stories.index', $universe))

@section('content')
    <h1>Stories</h1>

    @if($stories->isEmpty())
        <p><em>No stories for now!</em></p>
    @else
        <ul>
            <?php /** @var App\Universe $univers */ ?>
            @foreach($stories as $story)
                <li>
                    <a href="{{ $story->link() }}">{{ $story->label }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    <p>
        <a class="btn btn-primary" href="{{ route('universes.stories.create', $universe) }}">Add a new one!</a>
    </p>
@endsection
