<?php

namespace App\Http\Controllers\Tenant;

use App\Product;
use App\Purchase;
use App\BranchOffice;
use App\Events\ProductStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
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
        $this->authorize('tenant-view', Purchase::class);

        $purchases = Purchase::with(['product' => function ($query) {
            $query->with('provider');
        }])->whereHas('product', function ($query_2) use ($branchOffice) {
            $query_2->where('branch_office_id', $branchOffice->id);
        })->paginate();

        return view('tenant.purchase.index', compact('branchOffice', 'purchases'));
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
        $this->authorize('tenant-create', Purchase::class);

        $products = Product::where('branch_office_id', $branchOffice->id)->with('provider')->get();

        return view('tenant.purchase.create', compact('branchOffice', 'products'));
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
