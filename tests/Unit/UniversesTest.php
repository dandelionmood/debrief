<?php

namespace Tests\Unit;

use App\Universe;
use App\User;
use Tests\TestCase;

/**
 * Really basic tests on the universes, just to get the hang of it.
 *
 * We're really testing Eloquent here, not very interesting.
 *
 * @package Tests\Unit
 */
class UniversesTest extends TestCase
{
    public function testUniverseCreation(): void
    {
        // One universe, one user
        $universe = factory(Universe::class)->create();
        factory(User::class)->create()
            ->universes()->attach($universe);

        $this->assertInstanceOf(Universe::class, $universe);
        $this->assertEquals(1, count($universe->users));

        // One universe, two users
        $universe->users()->attach(factory(User::class)->create());
        $universe->refresh();
        $this->assertEquals(2, count($universe->users));
    }

    public function testUniverseDestruction(): void
    {
        $universe = factory(Universe::class)->create();
        $user     = factory(User::class)->create();
        $user->universes()->attach($universe);
        $this->assertEquals(1, count($user->universes));
        $this->assertEquals(1, count($universe->users));

        $universe->delete();
        $user->refresh();
        // The user has no universes left
        $this->assertEquals(0, count($user->universes));
    }
}
