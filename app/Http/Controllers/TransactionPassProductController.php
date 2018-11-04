<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Http\Requests\StoreTransactionPassProductRequest;

class TransactionPassProductController extends Controller
{
    public function store(StoreTransactionPassProductRequest $request)
    {
        $this->authorize('move-product', Transaction::class);

        return response()->json(['data' => $request->createTransaction()], 201);
    }
}
