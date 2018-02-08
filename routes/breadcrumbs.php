<?php

try {
    
    // Universes index
    \Breadcrumbs::register('universes.index', function ($breadcrumbs) {
        $breadcrumbs->push('Universes', route('universes.index'));
    });

    // Universe show
    \Breadcrumbs::register('universes.show', function ($breadcrumbs, $universe) {
        $breadcrumbs->parent('universes.index');
        $breadcrumbs->push($universe->label, route('universes.show', $universe->id));
    });

    // Stories index
    \Breadcrumbs::register('stories.index', function ($breadcrumbs, $universe) {
        $breadcrumbs->parent('universes.show', $universe);
        $breadcrumbs->push('Stories', route('universes.stories.index', $universe->id));
    });

    // Stories details
    \Breadcrumbs::register('universes.stories.show', function ($breadcrumbs, $universe, $story) {
        $breadcrumbs->parent('stories.index', $universe);
        $breadcrumbs->push($story->label, route('universes.stories.show', [$universe->id, $story->id]));
    });

}
catch (\DaveJamesMiller\Breadcrumbs\Facades\DuplicateBreadcrumbException $e) {
    throw $e;
}
