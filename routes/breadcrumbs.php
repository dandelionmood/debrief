<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

try {

    // Universes index
    \Breadcrumbs::register('universes.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->push('Universes', route('universes.index'));
    });
    \Breadcrumbs::register('universes.show', function (BreadcrumbsGenerator $breadcrumbs, $universe) {
        $breadcrumbs->parent('universes.index');
        $breadcrumbs->push($universe->label, route('universes.show', $universe->id), ['universe' => $universe]);
    });
    \Breadcrumbs::register('universes.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('universes.index');
        $breadcrumbs->push('Add a new universe');
    });
    \Breadcrumbs::register('universes.edit', function (BreadcrumbsGenerator $breadcrumbs, $universe) {
        $breadcrumbs->parent('universes.show', $universe);
        $breadcrumbs->push('Edit this universe');
    });


    \Breadcrumbs::register('universes.stories.index', function (BreadcrumbsGenerator $breadcrumbs, $universe) {
        $breadcrumbs->parent('universes.show', $universe);
        $breadcrumbs->push('Stories', route('universes.stories.index', $universe->id));
    });
    \Breadcrumbs::register('universes.stories.show', function (BreadcrumbsGenerator $breadcrumbs, $universe, $story) {
        $breadcrumbs->parent('universes.stories.index', $universe);
        $breadcrumbs->push($story->label, route('universes.stories.show', [$universe->id, $story->id]));
    });
    \Breadcrumbs::register('universes.stories.create', function (BreadcrumbsGenerator $breadcrumbs, $universe) {
        $breadcrumbs->parent('universes.stories.index', $universe);
        $breadcrumbs->push('New story');
    });


    \Breadcrumbs::register('universes.people.show', function (BreadcrumbsGenerator $breadcrumbs, $universe, $person) {
        $breadcrumbs->parent('universes.stories.index', $universe);
        $breadcrumbs->push($person->label, route('universes.people.show', [$universe->id, $person->id]));
    });

} catch (\DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException $e) {
    throw $e;
}
