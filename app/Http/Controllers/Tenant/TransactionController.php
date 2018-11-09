<?php

namespace App\Http\Controllers\Tenant;

use App\Product;
use App\Transaction;
use App\BranchOffice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-view', Transaction::class);

        $transactions = Transaction::where('branch_office_id', $branchOffice->id)
            ->with('product')
            ->paginate();

        return view('tenant.transaction.index', compact('branchOffice','transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Transaction::class);

        $products = Product::where('branch_office_id', $branchOffice->id)
            ->where('stock', '>', 0)
            ->select('id', 'name', 'stock')
            ->get();

        return view('tenant.transaction.create', compact('products', 'branchOffice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Http\Requests\Tenant\StoreTransactionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(BranchOffice $branchOffice, StoreTransactionRequest $request)
    {
        $this->authorize('tenant-create', Transaction::class);

        return response()->json(['data' => $request->createTransaction($branchOffice)], 201);
    }
}
