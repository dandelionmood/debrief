<div class="row justify-content-center mb-3">
    <div class="btn-group">
        <a href="{{ route('universes.stories.diary.date', [$universe, date('Y-m-d')]) }}" class="btn btn-outline-primary">
            <span class="oi oi-calendar"></span>
            @lang('Go today!')
        </a>
    </div>
</div>

<div class="bootstrap-datepicker"
     data-story-base-url="{{ route('universes.stories.diary.date', [$universe, '']) }}"
     @if(!empty($story)) data-current-node="{{ $story->getOriginal('label') }}" @endif
></div>