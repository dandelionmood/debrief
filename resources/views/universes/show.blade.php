@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>
                    {{ $universe->label }}

                    {!! Form::model($universe, ['route' => ['universes.edit', $universe->id], 'method' => 'GET']) !!}
                        <button class="btn pull-right">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </button>
                    {!! Form::close() !!}

                    {!! Form::model($universe, ['route' => ['universes.destroy', $universe->id], 'method' => 'DELETE']) !!}
                        <button class="btn pull-right">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                    {!! Form::close() !!}
                </h1>
                {!! parsedown($universe->description) !!}
            </div>
        </div>
@endsection
