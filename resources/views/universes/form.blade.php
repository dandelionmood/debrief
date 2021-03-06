@extends('layouts.universe', ['universe' => $universe])

@if(empty($universe->id))
    @section('breadcrumbs', Breadcrumbs::render('universes.create'))
@else
    @section('breadcrumbs', Breadcrumbs::render('universes.edit', $universe))
@endif

@section('content')
    @if(empty($universe->id))
        <h1>@lang('Add a new universe')</h1>
    @else
        <h1>@lang('Edit this universe')</h1>
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

    @if(empty($universe->id))
        {!! Form::model($universe, ['route' => 'universes.store', 'files' => true]) !!}
    @else
        {!! Form::model($universe, ['route' => ['universes.update', $universe->id], 'method' => 'PUT', 'files' => true]) !!}
    @endif

    <div class="form-group">
        {!! Form::label('label', __("Label:")) !!}
        {!! Form::text('label', null, ['class' => 'form-control input-lg']) !!}

        {!! Form::label('label', __("Type:")) !!}
        {!! Form::select('type', \App\Universe::getTypes(), null, ['class' => 'form-control']) !!}

        {!! Form::label('description', __("Description:")) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}

        <div class="row col-12">
            <div class="col-sm-10">
                {!! Form::label('picture', __("Picture (optional):")) !!}
                {!! Form::file('picture', ['class' => 'form-control-file']) !!}
            </div>
            <div class="col-sm-2">
                @if(!empty($universe->id) && !empty($universe->picture_url))
                    <img alt="@lang('universe avatar')" class="img-fluid" src="{{ $universe->picture_url }}" />
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        @if(empty($universe->id))
            {!! Form::submit(__('Save!')) !!}
        @else
            {!! Form::submit(__('Update!')) !!}
        @endif
    </div>

    {!! Form::close() !!}
@endsection

@section('sidebar')
    @if($universe->type)
        @include('shared.sidebar.'.$universe->type, ['universe' => $universe])
    @endif
@endsection