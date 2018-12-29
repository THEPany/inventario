<?php

namespace App\Http\Controllers\Tenant;

use App\{BranchOffice, Product, Provider, Purchase, Transaction};
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(BranchOffice $branchOffice)
    {
        $providers_count = Provider::where('branch_office_id', $branchOffice->id)->count();
        $products_count = Product::where('branch_office_id', $branchOffice->id)->count();
        $purchases_count = Purchase::whereDate('created_at', now())->whereHas('product', function ($query) use ($branchOffice) {
            $query->where('branch_office_id', $branchOffice->id);
        })->count();
        $transactions_count = Transaction::where('branch_office_id', $branchOffice->id)->whereDate('created_at', now())->count();

        return view('tenant.dashboard', compact('branchOffice', 'products_count', 'providers_count', 'purchases_count', 'transactions_count'));
    }
}
