<?php namespace App\Services;

use App\Repositories\StoryRepository;
use App\Story;
use App\Universe;
use App\User;

class Parsedown extends \Parsedown
{
    private $_universe;
    private $_user;

    public function setUniverse(Universe $universe)
    {
        $this->_universe = $universe;
    }

    public function setUser(User $user)
    {
        $this->_user = $user;
    }




    function __construct()
    {
        $this->InlineTypes['['][] = 'LinkToStory';
    }

    protected function inlineLinkToStory($excerpt)
    {
        switch ($this->_universe->type) {
            case Universe::TYPE_DIARY:
                return $this->replaceDiaryLinks($excerpt);
                break;
            case Universe::TYPE_WIKI:
                return $this->replaceWikiLinks($excerpt);
                break;
        }
    }

    /**
     * We handle WIKI story links.
     *
     * @param $excerpt
     * @return array
     */
    private function replaceWikiLinks($excerpt): array
    {
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

        }
    }

    /**
     * We handle DIARY story links.
     *
     * @param $excerpt
     * @return array
     */
    private function replaceDiaryLinks($excerpt): array
    {
        if (preg_match('/\[([0-9]{4}-[0-9]{2}-[0-9]{2})\]/', $excerpt['text'], $matches)) {
            // we handle diary type links
            $tag_size = strlen($matches[0]);
            $date     = $matches[1];
            $story    = app()->make(StoryRepository::class)->findOrCreateForDiary(
                $this->_universe,
                $this->_user,
                $date
            );

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
        }
    }
}