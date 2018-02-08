<!-- delete-in-place -->
{!! Form::model($model, ['route' => $route, 'method' => 'DELETE']) !!}
<button class="btn pull-right">
    <i class="glyphicon glyphicon-trash"></i>
</button>
{!! Form::close() !!}
<!-- / delete-in-place -->