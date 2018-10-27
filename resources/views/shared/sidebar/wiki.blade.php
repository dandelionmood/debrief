<form class="debrief-universe-search d-flex align-items-center">
    <input class="form-control ds-input" id="search-input"
           placeholder="Search..."
           autocomplete="off" spellcheck="false"
           role="combobox"
           aria-autocomplete="list" aria-expanded="false"
           aria-owns="algolia-autocomplete-listbox-0"
           style="position: relative; vertical-align: top;"
           dir="auto" type="search">
</form>

<nav id="debrief-universe-tree"
     data-read-url="{{ route('universes.stories-tree.index', $universe->id) }}?lazy"
     data-write-url="{{ route('universes.stories-tree.update', $universe->id) }}"
     @if(!empty($story)) data-current-node="story[{{ $story->id }}]" @endif>
    {{-- Updated via AJAX --}}
</nav>