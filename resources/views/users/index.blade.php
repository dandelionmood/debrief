@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('users.index'))

@section('content')
    <h1>
        @lang('Users')
        <a class="btn btn-primary" href="{{ route('users.create') }}">
            <span class="oi oi-plus" title="add" aria-label="@lang('Add a new user!')" aria-hidden="true" ></span>
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
                    
                    @lang('<small class="mb-2 text-muted" title=":date_user_created_at">created :date_user_created_at_diff_human</small>', [
                        'date_user_created_at' => $user->created_at,
                        'date_user_created_at_diff_human' => $user->created_at->diffForHumans(),
                    ])
                    <div class="mb-2 text-muted">
                        {{ $user->email }}

                        @if($user->is_admin)
                            <span class="badge badge-pill badge-danger">@lang('Admin')</span>
                        @endif

                        @if($user->trashed())
                            <span class="badge badge-pill badge-dark">@lang('Disabled')</span>
                        @endif
                    </div>
                    <div class="btn-group" role="group" aria-label="@lang('User admin options')">
                        @if($user->trashed())
                            <form action="{{ route('users.restore', [$user]) }}" method="post">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <span class="oi oi-arrow-circle-left" title="@lang('restore')" aria-hidden="true"></span>
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
