{!! Form::model(new \App\Comment(), [
    'route' => ['universes.stories.comments.store', $story->universe->id, $story->id],
    'method' => 'POST',
]) !!}
<div class="form-group">
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) !!}
</div>
{!! Form::submit('Save!', ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}

@if($story->comments->count() > 0)
    <table style="width: 100%;">
        <tbody>
        @foreach($story->comments as $comment)
            <tr>
                <th>
                    {{ $comment->created_at->diffForHumans() }}
                </th>
                <th>
                    {!! Form::model($comment, ['route' => ['universes.stories.comments.destroy', $story->universe->id, $story->id, $comment->id], 'method' => 'DELETE']) !!}
                    <button class="btn pull-right">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                    {!! Form::close() !!}
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    @include('shared.edit-in-place', [
                        'model' => $comment,
                        'field' => 'description',
                        'field_type' => 'textarea',
                        'route' => ['universes.stories.comments.update', $story->universe->id, $story->id, $comment->id],
                    ])
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif