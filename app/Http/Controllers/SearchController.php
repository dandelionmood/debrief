<?php

namespace App\Http\Controllers;

use App\Universe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function story(Universe $universe, Request $request)
    {
        $q = $request->input('q');

        $stories = $universe->stories();
        if (!empty($q)) {
            $stories->where('label', 'LIKE', '%' . $q . '%');
        }

        $stories = $stories->get(['id', 'label', 'universe_id'])->map(function ($s) {
            return [
                'id'    => "#$s->id",
                'label' => $s->label,
            ];
        });

        return response()->json($stories);
    }

    public function person(Universe $universe, Request $request)
    {
        $q = str_slug($request->input('q'));

        $people = $universe->people();
        if (!empty($q)) {
            $people->where('nickname', 'LIKE', '%' . $q . '%');
        }

        $people = $people->get()
            ->map(function ($p) {
                return [
                    'id'    => "@$p->nickname",
                    'label' => trim($p->first_name . ' ' . $p->last_name),
                ];
            });

        if (!empty($q)) {
            $people = $people->prepend([
                'id'    => "@$q",
                'label' => '',
            ]);
        }

        return response()->json($people);
    }
}
