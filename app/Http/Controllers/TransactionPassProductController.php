<?php

namespace App\Http\Controllers;

use App\Product;
use App\Provider;
use App\Transaction;
use App\BranchOffice;
use App\Events\ProductStatus;
use Illuminate\Support\Facades\DB;

class TransactionPassProductController extends Controller
{
    public function store()
    {
        $this->authorize('move-product', Transaction::class);

        request()->validate([
            'branch_office_id' => ['required', 'numeric'],
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'numeric'],
            'products.*.quantity' => ['required', 'numeric'],
            'products.*.description' => ['nullable', 'min:10', 'max:255'],
        ]);

        $branchOffice = BranchOffice::findOrFail(request()->branch_office_id);

        DB::transaction(function () use ($branchOffice){
            collect(request()->products)->each(function ($product_item) use ($branchOffice){
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

                $tenantProvider = Provider::firstOrCreate([
                    'branch_office_id' => $branchOffice->id,
                    'name' => 'Proveedor por defecto',
                    'phone' => 'No especificado',
                    'address' => 'No especificado',
                ]);

                $tenantProduct = Product::firstOrCreate([
                    'name' => strtolower($product->name),
                    'branch_office_id' => $branchOffice->id,
                ], [
                    'name' => $product->name,
                    'stock' => $product_item['quantity'],
                    'min_stock' => $product->min_stock,
                    'price' => $product->price,
                    'description' => $product->description,
                    'branch_office_id' => $branchOffice->id,
                    'provider_id' => $tenantProvider->id
                ]);

                if (! $tenantProduct->wasRecentlyCreated) {
                    $tenantProduct->increment('stock', $product_item['quantity']);
                }

                $tenantProduct->purchases()->create([
                    'description' => "{$product->name}: Inventario inicial (Productos enviados desde la sucursal principal)",
                    'stock' => $product->stock,
                    'price' => $product->price,
                ]);
            });
        });

        return back()->with(['flash_success' => "Transacción completada, los productos fueron enviados a la sucursal: {$branchOffice->name}"]);
    }
}
