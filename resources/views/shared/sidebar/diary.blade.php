<div class="col-12 row">
    <div class="bootstrap-datepicker col-md-12"
         data-story-base-url="{{ route('universes.stories.diary.date', [$universe, '']) }}"
         @if(!empty($story)) data-current-node="{{ $story->label }}" @endif
    ></div>
</div>
