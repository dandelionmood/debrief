<?php namespace App\Services;

use App\Repositories\PersonRepository;
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
        $this->InlineTypes['['][] = 'LinkTo';
    }

    protected function inlineLinkTo($excerpt)
    {
        $r = false;
        switch ($this->_universe->type) {
            case Universe::TYPE_DIARY:
                $r = $this->replaceDiaryLinks($excerpt);
                break;
            case Universe::TYPE_WIKI:
                $r = $this->replaceWikiLinks($excerpt);
                break;
        }
        if( is_array($r) ) return $r;

        $r = $this->inlineLinkToPerson($excerpt);
        if( is_array($r) ) return $r;
    }

    /**
     * We handle WIKI story links.
     *
     * @param $excerpt
     * @return array
     */
    private function replaceWikiLinks($excerpt)
    {
        if (preg_match('/\[\#([0-9]+)\]/', $excerpt['text'], $matches)) {
            $tag_size = mb_strlen($matches[0], 'UTF-8');
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
    private function replaceDiaryLinks($excerpt)
    {
        if (preg_match('/\[([0-9]{4}-[0-9]{2}-[0-9]{2})\]/', $excerpt['text'], $matches)) {
            $tag_size = mb_strlen($matches[0], 'UTF-8');
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

    protected function inlineLinkToPerson($excerpt)
    {
        if (preg_match('/\[@([^\]]*)\]/', $excerpt['text'], $matches)) {
            $tag_size = mb_strlen($matches[0], 'UTF-8');
            $nickname = $matches[1];

            $person = app()->make(PersonRepository::class)->findOrCreate(
                $this->_universe,
                $this->_user,
                $nickname
            );

            return [
                'extent'  => $tag_size,
                'element' => [
                    'name'       => 'a',
                    'text'       => $person->label,
                    'attributes' => [
                        'href' => $person->link($this->_universe)
                    ],
                ],
            ];
        }
    }
}