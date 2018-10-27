<?php namespace App\Services;

use App\Story;
use App\Universe;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Parsedown extends \Parsedown
{
    function __construct()
    {
        $this->InlineTypes['['][] = 'LinkToStory';
    }

    private $_universe;
    public function setUniverse(Universe $universe)
    {
        $this->_universe = $universe;
    }

    protected function inlineLinkToStory($excerpt)
    {
        // we handle diary type links first
        if (preg_match('/\[\#([0-9]+)\]/', $excerpt['text'], $matches)) {
            $tag_size = strlen($matches[0]);
            try {
                /** @var Story $story */
                $story = Story::findOrFail($matches[1]);
                return [
                    'extent'  => $tag_size,
                    'element' => [
                        'name'       => 'a',
                        'text'       => $story->label,
                        'attributes' => [
                            'href' => $story->link(),
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
        } elseif (preg_match('/\[([0-9]{4}-[0-9]{2}-[0-9]{2})\]/', $excerpt['text'], $matches)) {
            $tag_size = strlen($matches[0]);
            try {
                $date = $matches[1];
                return [
                    'extent'  => $tag_size,
                    'element' => [
                        'name'       => 'a',
                        'text'       => Carbon::parse($date)->toFormattedDateString(),
                        'attributes' => [
                            'href' => route('universes.stories.diary.date', [$this->_universe, $date]),
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