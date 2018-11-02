<?php

namespace App\Http\Controllers;

use App\BranchOffice;

class HomeController extends Controller
{
    public function index()
    {
        $branchOffices = BranchOffice::unless(auth()->user()->isAn('admin'), function ($query) {
            $query->where('id', auth()->user()->branch_office_id);
        })
            ->orderBy('id','DESC')
            ->paginate();

        return view('home')->with(['branchOffices' => $branchOffices]);
    }
}
