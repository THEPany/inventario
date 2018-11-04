<?php

namespace App\Http\Controllers;

use App\Events\ProductStatus;
use App\{Transaction, Product};
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store()
    {
        $this->authorize('create', Transaction::class);

        request()->validate([
           'products' => ['required', 'array'],
           'products.*.id' => ['required', 'numeric'],
           'products.*.quantity' => ['required', 'numeric'],
           'products.*.description' => ['nullable', 'min:10', 'max:255'],
        ]);

        DB::transaction(function () {
            collect(request()->products)->each(function ($product_item) {
                $product = Product::findOrfail($product_item['id']);

                Transaction::create([
                    'product_id' => $product->id,
                    'quantity' => $product_item['quantity'],
                    'description' => $product_item['description'] ?? "Registro de transacción para {$product->name}"
                ]);

                abort_if($product_item['quantity'] > $product->stock,
                    400,
                    "No se puede realizar la transacción para el producto {$product->name}, la cantidad solicitada excede el stock del mismo");

                $product->decrement('stock', $product_item['quantity']);

                event(new ProductStatus($product));
            });
        });

        return back()->with(['flash_success' => 'Transacción completada con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
