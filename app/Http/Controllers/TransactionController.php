<?php

namespace App\Http\Controllers;

use App\BranchOffice;
use App\Product;
use App\Transaction;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Transaction::class);

        $transactions = Transaction::mainTransactions()
            ->with('product')
            ->paginate();

        return view('transaction.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Transaction::class);

        $products = Product::mainProducts()
            ->where('stock', '>', 0)
            ->select('id', 'name', 'stock')
            ->get();

        $branchOffices = BranchOffice::select('id', 'name')->get();

        return view('transaction.create', compact('products', 'branchOffices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTransactionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTransactionRequest $request)
    {
        $this->authorize('create', Transaction::class);

        return response()->json(['data' => $request->createTransaction()], 201);
    }
}
