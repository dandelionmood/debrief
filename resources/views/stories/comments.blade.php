<div class="row">
    <div class="col-12">
        <div class="media comment-box">
            <div class="media-left">
                <a href="@can('manage-users'){{ route('users.edit', [request()->user()]) }} @else javascript:void(0); @endcan">
                    <img class="img-fluid user-photo" src="{{ request()->user()->picture_url }}">
                </a>
            </div>
            <div class="media-body">
                {!! Form::model(new \App\Comment(), [
                            'route' => ['universes.stories.comments.store', $story->universe, $story],
                            'method' => 'POST',
                        ]) !!}
                <div class="form-group">
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) !!}
                </div>
                {!! Form::submit('Save!', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>

        @if($story->comments->count() > 0)
            @foreach($story->comments as $comment)
                <div class="media comment-box">
                    <div class="media-left">
                        <a href="@can('manage-users'){{ route('users.edit', [request()->user()]) }} @else javascript:void(0); @endcan">
                            <img class="img-fluid user-photo" src="{{ $comment->created_by->picture_url }}">
                        </a>
                    </div>
                    <div class="media-body">
                        <div class="media-heading">
                            {{ $comment->created_by->name }}
                            <span title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</span>

                            {!! Form::model($comment, [
                                'route' => ['universes.stories.comments.destroy', $story->universe, $story, $comment],
                                'method' => 'DELETE',
                                'class' => 'float-right'
                            ]) !!}
                            <button class="btn btn-sm">
                                <span class="oi oi-trash" title="trash" aria-hidden="true"></span>
                            </button>
                            {!! Form::close() !!}
                        </div>

                        <div class="media-content">
                            @include('shared.edit-in-place', [
                               'model' => $comment,
                               'field' => 'description',
                               'field_type' => 'textarea',
                               'route' => ['universes.stories.comments.update', $story->universe, $story, $comment],
                           ])
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>