@extends('layouts.universe', ['universe' => $story->universe])

@section('breadcrumbs', Breadcrumbs::render('universes.stories.index', $universe))

@section('content')
    <h1>@lang('Stories')</h1>

    @if($stories->isEmpty())
        <p><em>@lang('No stories for now!')</em></p>
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
        <a class="btn btn-primary" href="{{ route('universes.stories.create', $universe) }}">@lang('Add a new one!')</a>
    </p>
@endsection
