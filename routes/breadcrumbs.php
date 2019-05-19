<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

try {

    \Breadcrumbs::register('home', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->push(__('Home'), route('home'));
    });

    \Breadcrumbs::register('users.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push(__('Users management'), route('users.index'));
    });
    \Breadcrumbs::register('users.edit', function (BreadcrumbsGenerator $breadcrumbs, $user) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push(__('Edit this user'));
    });
    \Breadcrumbs::register('users.create', function (BreadcrumbsGenerator $breadcrumbs, $user) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push(__('Add a new user'));
    });

    // Universes index
    \Breadcrumbs::register('universes.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push(__('Universes'), route('universes.index'));
    });
    \Breadcrumbs::register('universes.show', function (BreadcrumbsGenerator $breadcrumbs, $universe) {
        $breadcrumbs->parent('universes.index');
        $breadcrumbs->push($universe->label, route('universes.show', $universe->id), ['universe' => $universe]);
    });
    \Breadcrumbs::register('universes.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('universes.index');
        $breadcrumbs->push(__('Add a new universe'));
    });
    \Breadcrumbs::register('universes.edit', function (BreadcrumbsGenerator $breadcrumbs, $universe) {
        $breadcrumbs->parent('universes.show', $universe);
        $breadcrumbs->push(__('Edit this universe'));
    });


    \Breadcrumbs::register('universes.stories.index', function (BreadcrumbsGenerator $breadcrumbs, $universe) {
        $breadcrumbs->parent('universes.show', $universe);
        $breadcrumbs->push(__('Stories'), route('universes.stories.index', $universe->id));
    });
    \Breadcrumbs::register('universes.stories.show', function (BreadcrumbsGenerator $breadcrumbs, $universe, $story) {
        $breadcrumbs->parent('universes.stories.index', $universe);
        $breadcrumbs->push($story->label, route('universes.stories.show', [$universe->id, $story->id]));
    });
    \Breadcrumbs::register('universes.stories.create', function (BreadcrumbsGenerator $breadcrumbs, $universe) {
        $breadcrumbs->parent('universes.stories.index', $universe);
        $breadcrumbs->push(__('New story'));
    });


    \Breadcrumbs::register('universes.people.show', function (BreadcrumbsGenerator $breadcrumbs, $universe, $person) {
        $breadcrumbs->parent('universes.stories.index', $universe);
        $breadcrumbs->push($person->label, route('universes.people.show', [$universe->id, $person->id]));
    });

    \Breadcrumbs::register('universes.tags.show', function (BreadcrumbsGenerator $breadcrumbs, $universe, $tag) {
        $breadcrumbs->parent('universes.stories.index', $universe);
        $breadcrumbs->push($tag->label, route('universes.tags.show', [$universe->id, $tag->id]));
    });

} catch (\DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException $e) {
    throw $e;
}
