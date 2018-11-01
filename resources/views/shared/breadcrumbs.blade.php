@if (!empty($breadcrumbs))

    <ol class="breadcrumb">

        @foreach ($breadcrumbs as $breadcrumb)

            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item">
                    @if(!empty($breadcrumb->universe) && !empty($breadcrumb->universe->picture_url))
                        <img class="rounded" style="height: 1em;"
                             src="{{ $breadcrumb->universe->picture_url }}"/>
                    @endif

                    <a href="{{ $breadcrumb->url }}">
                        {{ $breadcrumb->title }}
                    </a>
                </li>
            @else
                <li class="breadcrumb-item active">
                    @if(!empty($breadcrumb->universe) && !empty($breadcrumb->universe->picture_url))
                        <img class="rounded" style="height: 1em;"
                             src="{{ $breadcrumb->universe->picture_url }}"/>
                    @endif

                    {{ $breadcrumb->title }}
                </li>
            @endif

        @endforeach

    </ol>

@endif