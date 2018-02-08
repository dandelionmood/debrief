<?php

namespace App\Http\Controllers;

use App\Universe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search($universe_id, Request $request)
    {
        $q = $request->input('q');

        $universe = Universe::findOrFail($universe_id);
        $stories  = $universe->stories();
        if (!empty($q)) {
            $stories->where('label', 'LIKE', '%' . $q . '%');
        }
        $stories = $stories->get(['id', 'label'])->map(function ($s) {
            return [
                'id'    => "#$s->id",
                'label' => $s->label,
            ];
        });

        return response()->json($stories);
    }
}
