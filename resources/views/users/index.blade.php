@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('users.index'))

@section('content')
    <h1>
        Users
        <a class="btn btn-primary" href="{{ route('users.create') }}">
            <span class="oi oi-plus" title="add" aria-label="Add a new user!" aria-hidden="true" ></span>
        </a>
    </h1>

    <div class="list-group">
        <?php /** @var App\User $user */ ?>
        @foreach($users as $user)
            <div class="card flex-md-row mb-3">
                @if(!empty($user->picture_url))
                    <img class="d-none d-md-block w-25"
                         alt="user avatar"
                         src="{{ $user->picture_url }}">
                @endif
                <div class="card-body d-flex flex-column align-items-start">
                    <h3 class="mb-0">
                        {{ $user->name }}
                    </h3>
                    <small class="mb-2 text-muted" title="{{ $user->created_at }}">
                        created {{ $user->created_at->diffForHumans() }}
                    </small>
                    <div class="mb-2 text-muted">
                        {{ $user->email }}

                        @if($user->is_admin)
                            <span class="badge badge-pill badge-danger">Admin</span>
                        @endif

                        @if($user->trashed())
                            <span class="badge badge-pill badge-dark">Disabled</span>
                        @endif
                    </div>
                    <div class="btn-group" role="group" aria-label="User admin options">
                        @if($user->trashed())
                            <form action="{{ route('users.restore', [$user]) }}" method="post">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <span class="oi oi-arrow-circle-left" title="restore" aria-hidden="true"></span>
                                </button>
                            </form>
                        @else
                            {!! Form::model($user, ['route' => ['users.edit', $user], 'method' => 'GET']) !!}
                            <button type="submit" class="btn btn-sm btn-secondary">
                                <span class="oi oi-pencil" title="edit" aria-hidden="true"></span>
                            </button>
                            {!! Form::close() !!}
                            {!! Form::model($user, [
                                'route' => ['users.destroy', $user],
                                'method' => 'DELETE',
                            ]) !!}
                            <button type="submit" class="btn btn-sm btn-secondary">
                                <span class="oi oi-trash" title="trash" aria-hidden="true"></span>
                            </button>
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <p>
    </p>
@endsection
