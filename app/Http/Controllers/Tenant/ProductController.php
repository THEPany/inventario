<?php

namespace App\Http\Controllers\Tenant;

use App\Product;
use App\Provider;
use App\BranchOffice;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
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
        $this->authorize('tenant-view', Product::class);

        $products = Product::where('branch_office_id', $branchOffice->id)->paginate();

        return view('tenant.product.index', compact('branchOffice', 'products'));
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
        $this->authorize('tenant-create', Product::class);

        $product = new Product;
        $providers = Provider::select('id', 'name')->where('branch_office_id', $branchOffice->id)->get();

        return view('tenant.product.create')->with([
            'branchOffice' => $branchOffice,
            'product' => $product,
            'providers' => $providers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(BranchOffice $branchOffice)
    {
        $this->authorize('tenant-create', Product::class);

        request()->validate([
            'name' => [
                'required',
                Rule::unique('products')->where(function ($query) use($branchOffice) {
                    return $query->where([
                        ['branch_office_id', $branchOffice->id],
                        ['name', request()->name],
                    ]);
                })],
            'provider_id' => 'required',
            'stock' => 'required|numeric',
            'min_stock' => 'nullable|numeric',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        DB::transaction(function () use($branchOffice) {
            $product = $branchOffice->products()->create([
                'name' => request()->name,
                'provider_id' => request()->provider_id,
                'stock' => request()->stock,
                'min_stock' => request()->min_stock,
                'price' => request()->price,
                'description' => request()->description,
            ]);

            $product->purchases()->create([
                'description' => "{$product->name}: Inventario inicial",
                'stock' => $product->stock,
                'price' => $product->price,
            ]);
        });

        return back()->with(['flash_success' => "Producto ". ucwords(request()->name) ." creado exitosamente"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\BranchOffice $branchOffice
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BranchOffice $branchOffice, Product $product)
    {
        $this->authorize('tenant-update', $product);

        abort_unless($product->branch_office_id == $branchOffice->id, 403);

        $providers = Provider::where('branch_office_id', $branchOffice->id)->select('id', 'name')->get();

        return view('tenant.product.edit')->with([
            'branchOffice' => $branchOffice,
            'product' => $product,
            'providers' => $providers
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\BranchOffice $branchOffice
     * @param  \App\Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(BranchOffice $branchOffice, Product $product)
    {
        $this->authorize('tenant-update', $product);

        abort_unless($product->branch_office_id == $branchOffice->id, 403);

        request()->validate([
            'name' => [
                'required',
                Rule::unique('products')->ignore($product->id)->where(function ($query) use ($branchOffice, $product) {
                    return $query->where([
                        ['branch_office_id', $branchOffice->id],
                        ['name', $product->name],
                    ]);
                })],
            'provider_id' => 'required',
            'stock' => 'required|numeric',
            'min_stock' => 'nullable|numeric',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        $product->update([
            'name' => request()->name,
            'provider_id' => request()->provider_id,
            'stock' => request()->stock,
            'min_stock' => request()->min_stock,
            'price' => request()->price,
            'description' => request()->description,
        ]);

        return back()->with(['flash_success' => "Producto {$product->name} actualizado exitosamente"]);
    }
}
