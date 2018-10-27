<?php

namespace App\Http\Controllers;

use App\BranchOffice;

class HomeController extends Controller
{
    public function index()
    {
        $branchOffices = BranchOffice::paginate();

        return view('home')->with(['branchOffices' => $branchOffices]);
    }
}
