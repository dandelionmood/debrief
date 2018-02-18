@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('universes.stories.create', $story->universe))

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(empty($story->id))
                <h1>Add a new story</h1>
            @else
                <h1>Edit this story</h1>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(empty($story->id))
                {!! Form::model($story, ['route' => ['universes.stories.store', $story->universe->id]]) !!}
            @else
                {!! Form::model($story, ['route' => ['universes.stories.update', $story->universe->id, $story->id], 'method' => 'PUT']) !!}
            @endif

            <div class="form-group">
                {!! Form::label('label', "Label:") !!}
                {!! Form::text('label', null, ['class' => 'form-control input-lg']) !!}

                {!! Form::label('description', "Description:") !!}
                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                @if(empty($story->id))
                    {!! Form::submit('Save!') !!}
                @else
                    {!! Form::submit('Update!') !!}
                @endif
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('sidebar')
    @include('shared.sidebar.stories-tree', ['universe' => $story->universe])
@endsection