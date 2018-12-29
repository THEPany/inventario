<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\{Events\ProductStatus, Purchase, Product};

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Purchase::class);

        $purchases = Purchase::with(['product' => function ($query) {
            $query->with('provider');
        }])->whereHas('product', function ($query_2) {
            $query_2->mainProducts();
        })->orderByDesc('id')
            ->paginate();

        return view('purchase.index')->with(['purchases' => $purchases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Purchase::class);

        $products = Product::mainProducts()->with('provider')->get();

        return view('purchase.create')->with(['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store()
    {
        $this->authorize('create', Purchase::class);

        request()->validate([
            'product_id' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $product = Product::findOrfail(request()->product_id);

        abort_unless($product->isMainProdut(), 403);

        DB::transaction(function () use ($product) {
            $product->purchases()->create([
                'price' => request()->price,
                'previous_price' => $product->price,
                'stock' => request()->stock,
                'description' => "{$product->name} : Compra realizada por ". auth()->user()->name ." al proveedor {$product->provider->name}"
            ]);

            $product->increment('stock', request()->stock, ['price' => request()->price]);

            event(new ProductStatus($product));
        });

        return back()->with(['flash_success' => "Compra de {$product->name} registrada exitosamente"]);
    }
}
