<!-- edit-in-place {{ $field }} / {{ $field_type }} -->
<div class="hide-and-show-next-form
    @if($field_type === 'textarea')
        markdown-content
        @if(empty($model->$field)) empty-content @endif
@endif">
    @if(empty($model->$field))
        No <code>{{ $field }}</code> yet…
        <small>(double-click to add one!)</small>
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
@if($field_type === 'textarea')
    <div class="form-group">
        {!! Form::$field_type($field, null, ['class' => 'form-control']) !!}
        {!! Form::button('<span class="oi oi-check" title="save" aria-hidden="true"></span> Save!',
            ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
    </div>
@else
    <div class="form-inline">
        {!! Form::$field_type($field, null, ['class' => 'form-control form-control-lg mr-sm-2']) !!}
        {!! Form::button('<span class="oi oi-check" title="save" aria-hidden="true"></span>',
            ['type' => 'submit', 'class' => 'form-control form-control-lg btn btn-primary']) !!}
    </div>
@endif
{!! Form::close() !!}
<!-- edit-in-place {{ $field }} / {{ $field_type }} -->