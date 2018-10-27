{!! Form::model(new \App\Comment(), [
    'route' => ['universes.stories.comments.store', $story->universe, $story],
    'method' => 'POST',
]) !!}
<div class="form-group">
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) !!}
</div>
{!! Form::submit('Save!', ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}

@if($story->comments->count() > 0)
    @foreach($story->comments as $comment)
        <div class="card">
            <div class="card-header">
                <span title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</span> by {{ $comment->created_by->name }}
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
            <div class="card-body">
                <div class="card-text">
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