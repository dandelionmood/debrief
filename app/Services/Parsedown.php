<?php namespace App\Services;

use App\Story;

class Parsedown extends \Parsedown
{
    function __construct()
    {
        $this->InlineTypes['['][] = 'LinkToStory';
    }

    protected function inlineLinkToStory($excerpt)
    {
        if (preg_match('/\[\#([0-9]+)\]/', $excerpt['text'], $matches)) {
            $tag_size = strlen($matches[0]);
            try {
                $story = Story::findOrFail($matches[1]);
                return [
                    'extent'  => $tag_size,
                    'element' => [
                        'name'       => 'a',
                        'text'       => $story->label,
                        'attributes' => [
                            'href' => route('universes.stories.show', [$story->universe->id, $story->id]),
                        ],
                    ],
                ];
            } catch (\Exception $e) {
                echo $e->getMessage();
                return [
                    'extent'  => $tag_size,
                    'element' => [
                        'name'       => 'span',
                        'text'       => 'Unknown story',
                        'attributes' => [
                            'class' => 'dontknow',
                        ],
                    ],
                ];
            }

        }
    }
}