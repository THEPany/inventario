<?php

namespace App\Http\Controllers;

use App\{Purchase, Product};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::with(['product' => function ($query) {
            $query->with('provider');
        }])->paginate();

        return view('purchase.index')->with(['purchases' => $purchases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::with('provider')->get();

        return view('purchase.create')->with(['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        request()->validate([
            'product_id' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $product = Product::findOrfail(request()->product_id);

        DB::transaction(function () use ($product) {
            $product->purchases()->create([
                'price' => request()->price,
                'previous_price' => $product->price,
                'stock' => request()->stock,
                'description' => "{$product->name} : Compra realizada por ". auth()->user()->name ." al proveedor {$product->provider->name}"
            ]);

            $product->increment('stock', request()->stock, ['price' => request()->price]);
        });

        return back()->with(['flash_success' => "Compra de {$product->name} registrada exitosamente"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
