<?php

namespace App\Http\Controllers;

use Silber\Bouncer\Database\Ability;

class AbilitieController extends Controller
{
    public function index()
    {
        $abilities = Ability::paginate();
        return view('abilities.index', compact('abilities'));
    }
}
