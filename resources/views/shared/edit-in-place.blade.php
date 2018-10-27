<!-- edit-in-place {{ $field }} / {{ $field_type }} -->
<div class="hide-and-show-next-form
    @if($field_type === 'textarea')
        markdown-content
        @if(empty($model->$field)) empty-content @endif
@endif">
    @if(empty($model->$field))
        Nothing yet… <small>(psst, you can double-click here to edit !)</small>
    @else
        @if($field_type === 'textarea')
            @parsedown($model->$field)
        @else
            @parsedown_line($model->$field)
        @endif
    @endif
</div>

@php($classes = ['hide'])
@if(get_class($model) === \App\Story::class)
    @php($classes[] = $model->universe->type)
@endif

{!! Form::model($model, ['route' => $route, 'method' => 'PUT', 'class' => implode(' ', $classes)]) !!}
<div class="form-group">
    {!! Form::$field_type($field, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::submit('Update!') !!}
</div>
{!! Form::close() !!}
<!-- edit-in-place {{ $field }} / {{ $field_type }} -->