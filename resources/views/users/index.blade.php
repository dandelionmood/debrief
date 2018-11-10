@extends('layouts.user')

@section('breadcrumbs', Breadcrumbs::render('users.index'))

@section('content')
    <h1>Users</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Admin?</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php /** @var App\User $user */ ?>
        @foreach($users as $user)
            <tr>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    {{ $user->is_admin }}
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
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
                    </div>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p>
        <a class="btn btn-primary" href="{{ route('users.create') }}">Add a new one!</a>
    </p>
@endsection
