<?php

// Home
\Breadcrumbs::register('universes', function ($breadcrumbs) {
    $breadcrumbs->push('Universes', route('universes.index'));
});

\Breadcrumbs::register('stories', function ($breadcrumbs, $universe) {
    $breadcrumbs->push('Universes', route('universes.index'));
    $breadcrumbs->push($universe->label, route('universes.stories.index', $universe->id));
});