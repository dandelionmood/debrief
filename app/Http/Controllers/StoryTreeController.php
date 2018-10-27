<?php

namespace App\Http\Controllers;

use App\Story;
use App\Universe;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class StoryTreeController extends Controller
{
    public function index($universe_id, Request $request)
    {
        $universe = Universe::findOrFail($universe_id);

        $transform_to_tree = function (Story $story) use ($universe) {

            $children = $story->getImmediateDescendants()->map(function (Story $children) {
                return [
                    'id'       => 'story[' . $children->id . ']',
                    'text'     => $children->label,
                    'a_attr'   => ['href' => $children->link()],
                    'children' => $children->descendants()->count() > 0,
                ];
            });

            $r = [
                'state'    => ['opened' => true],
                'children' => $children->count() === 0 ? false : $children->all(),
            ];

            if ($story->isRoot()) {
                $r['text']   = $universe->label;
                $r['a_attr'] = ['href' => route('universes.show', [$universe->id])];
            } else {
                $r['id']     = 'story[' . $story->id . ']';
                $r['text']   = $story->label;
                $r['a_attr'] = ['href' => $story->link()];
            }

            return $r;
        };

        $id = $request->input('id');

        // Root element required
        if ($id === '#') {
            $stories = $transform_to_tree($universe->root_story);
        } else {
            // Any other node …
            preg_match('/\[([0-9]*)\]/', $id, $matches);
            $id      = $matches[1];
            $stories = $transform_to_tree(Story::findOrFail($id));
        }

        return response()->json($stories);
    }

    public function update($universe_id, Request $request)
    {
        preg_match('/.*\[([0-9]*)\]/', $request->input('node_id'), $m);
        $node_id = (int) $m[1];

        $parent_node = $request->input('parent_node');
        if ($parent_node !== '#') {
            preg_match('/.*\[([0-9]*)\]/', $parent_node, $m);
            $parent_node = (int) $m[1];
        }

        $node_position = (int) $request->input('node_position');

        // We first need to find our node within its universe
        $universe = Universe::findOrFail((int) $universe_id);
        /** @var Story $story */
        $story = $universe->stories->where('id', $node_id)->first();
        if (!$story) throw new InternalErrorException("No node found.");

        $siblings = null;

        // Node position in the tree (regarding its parent)

        if ($parent_node === '#') {
            $siblings = $universe->root_story->getRoot()->getImmediateDescendants();
            $story->makeChildOf($universe->root_story->getRoot());
        } else {
            /** @var Story $parent_node */
            $parent_node = Story::findOrFail((int) $parent_node);
            $siblings    = $parent_node->getImmediateDescendants();
            $story->makeChildOf($parent_node);
        }

        // Node position in the tree (regarding its neighbours)

        if ($node_position === 0) {
            if ($parent_node === '#') {
                $story->makeFirstChildOf(
                    $universe->root_story->getRoot()
                );
            } else {
                $story->makeFirstChildOf(
                    $parent_node
                );
            }
        } else {
            $story->makeNextSiblingOf(
                $siblings->offsetGet($node_position)
            );
        }

        return response()->json(['updated' => true]);
    }
}
