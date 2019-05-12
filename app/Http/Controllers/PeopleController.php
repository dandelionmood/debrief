<?php

namespace App\Http\Controllers;

use App\Person;
use App\Universe;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function show(Request $request, Universe $universe, Person $person)
    {
        return view('people.show', [
            'universe' => $universe,
            'person'   => $person,
        ]);
    }

    /**
     * Update the person in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Universe $universe
     * @param  Person $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Universe $universe, Person $person)
    {
        $attributes                           = $request->except(['_token']);
        $attributes['last_edited_by_user_id'] = $request->user()->id;
        $person->update($attributes);

        return redirect($person->link($universe))
            ->with('success', __('Person successfully updated!'));
    }
}
