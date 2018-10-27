<?php

use App\Comment;
use App\Story;
use App\Universe;
use App\User;
use Illuminate\Database\Seeder;

class AppDevSeeder extends Seeder
{
    const HOW_MANY_USERS                     = 2;
    const HOW_MANY_UNIVERSES_PER_USER        = 1;
    const HOW_MANY_STORIES_PER_UNIVERSE      = 3;
    const HOW_MANY_SUB_STORIES_PER_STORY     = 3;
    const HOW_MANY_SUB_SUB_STORIES_PER_STORY = 3;
    const HOW_MANY_COMMENTS_PER_STORY        = 2;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, self::HOW_MANY_USERS)->create()
            ->each(function (User $user) {
                echo "User generated : $user->email / secret", PHP_EOL;
                factory(Universe::class, self::HOW_MANY_UNIVERSES_PER_USER)->make()
                    ->each(function (Universe $universe) use ($user) {
                        $user->universes()->save($universe);

                        factory(Story::class, self::HOW_MANY_STORIES_PER_UNIVERSE)
                            ->make(['created_by_user_id' => $user->id,
                                    'universe_id'        => $universe->id])
                            ->each(function (Story $story) use ($universe, $user) {
                                $story->save();
                                $story->makeChildOf($universe->root_story->getRoot());
                                // Lets add some substories to the mix !
                                factory(Story::class, self::HOW_MANY_SUB_STORIES_PER_STORY)
                                    ->make(['created_by_user_id' => $user->id,
                                            'universe_id'        => $universe->id])
                                    ->each(function (Story $substory) use ($story, $user, $universe) {
                                        $substory->save();
                                        $substory->makeChildOf($story);
                                        // And some subsubstories for good measure.
                                        factory(Story::class, self::HOW_MANY_SUB_SUB_STORIES_PER_STORY)
                                            ->make(['created_by_user_id' => $user->id,
                                                    'universe_id'        => $universe->id])
                                            ->each(function (Story $subsubstory) use ($substory) {
                                                $subsubstory->save();
                                                $subsubstory->makeChildOf($substory);
                                            });
                                    });

                                // And a few comments as well.
                                factory(Comment::class, self::HOW_MANY_COMMENTS_PER_STORY)
                                    ->make(['created_by_user_id' => $user->id])
                                    ->each(function (Comment $comment) use ($story) {
                                        $story->comments()->save($comment);
                                    });
                            });
                    });
            });
    }
}
