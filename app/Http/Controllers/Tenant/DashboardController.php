<?php

namespace App\Http\Controllers\Tenant;

use App\BranchOffice;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view-dashboard');

        return view('tenant.dashboard', compact('branchOffice'));
    }
}
