<div class="bootstrap-datepicker"
     data-story-base-url="{{ route('universes.stories.diary.date', [$universe, '']) }}"
     @if(!empty($story)) data-current-node="{{ $story->getOriginal('label') }}" @endif
></div>
