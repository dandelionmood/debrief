<!-- delete-in-place -->
{!! Form::model($model, ['route' => $route, 'method' => 'DELETE', 'class' => 'float-right']) !!}
<button class="btn btn-sm">
    <span class="oi oi-trash" title="trash" aria-hidden="true"></span>
</button>
{!! Form::close() !!}
<!-- / delete-in-place -->