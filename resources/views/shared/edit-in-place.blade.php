<!-- edit-in-place {{ $field }} / {{ $field_type }} -->
<div class="@if($field_type === 'textarea') markdown-content @endif hide-and-show-next-form">
    @if($field_type === 'textarea')
        @parsedown($model->$field)
    @else
        @parsedown_line($model->$field)
    @endif
</div>

{!! Form::model($model, ['route' => $route, 'method' => 'PUT', 'class' => 'hide']) !!}
<div class="form-group">
    {!! Form::$field_type($field, null, ['class' => 'form-control']) !!}
</div>
{!! Form::close() !!}
<!-- edit-in-place {{ $field }} / {{ $field_type }} -->