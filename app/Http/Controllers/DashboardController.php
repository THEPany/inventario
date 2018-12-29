<?php

namespace App\Http\Controllers;

use App\{BranchOffice, Provider, Product, Purchase, Transaction, User};

class DashboardController extends Controller
{
    public function index()
    {
        $providers_count = Provider::mainProviders()->count();
        $products_count = Product::mainProducts()->count();
        $users_count = User::count();
        $branchOffices_count = BranchOffice::count();
        $purchases_count = Purchase::whereDate('created_at', now())->whereHas('product', function ($query) {
            $query->mainProducts();
        })->count();
        $transactions_count = Transaction::mainTransactions()->whereDate('created_at', now())->count();


        return view('dashboard', compact('providers_count', 'products_count', 'users_count', 'branchOffices_count', 'purchases_count', 'transactions_count'));
    }
}
