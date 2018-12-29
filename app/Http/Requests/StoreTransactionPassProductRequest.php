<?php

namespace App\Http\Requests;

use App\Events\ProductStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use App\{Product,BranchOffice, Transaction, Provider};

class StoreTransactionPassProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'branch_office_id' => ['required', 'numeric'],
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'numeric'],
            'products.*.quantity' => ['required', 'numeric'],
            'products.*.description' => ['nullable', 'min:10', 'max:255'],
        ];
    }

    public function createTransaction()
    {
        $branchOffice = BranchOffice::findOrFail($this->branch_office_id);

        DB::transaction(function () use ($branchOffice){
            collect(request()->products)->each(function ($_product) use ($branchOffice){
                $product = Product::findOrfail($_product['id']);

                $this->abortCases($product, $_product['quantity']);

                Transaction::createTransaction($product, $_product);

                $product->decrement('stock', $_product['quantity']);

                event(new ProductStatus($product));

                $this->moveProductBranchOffice($branchOffice, $product, $_product);

            });
        });

        return "Transacción completada, los productos fueron enviados a la sucursal: {$branchOffice->name}";

    }

    public function abortCases(Product $product, $quantity)
    {
        abort_if($product->stock < $quantity,
            400,
            "No se puede realizar la transacción para el producto {$product->name}, la cantidad solicitada excede el stock del mismo");
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return mixed
     */
    protected function getTenantProvider(BranchOffice $branchOffice)
    {
        return Provider::firstOrCreate([
            'branch_office_id' => $branchOffice->id,
        ], [
            'branch_office_id' => $branchOffice->id,
            'name' => 'Sucursal principal',
            'phone' => 'No especificado',
            'address' => 'No especificado',
        ]);
    }

    protected function moveProductBranchOffice(BranchOffice $branchOffice, Product $product, $_product)
    {
        $tenantProduct = Product::firstOrCreate([
            'name' => strtolower($product->name),
            'branch_office_id' => $branchOffice->id,
        ], [
            'name' => $product->name,
            'stock' => $_product['quantity'],
            'min_stock' => $product->min_stock,
            'price' => $product->price,
            'description' => $product->description,
            'branch_office_id' => $branchOffice->id,
            'provider_id' =>  $this->getTenantProvider($branchOffice)->id
        ]);

        if (! $tenantProduct->wasRecentlyCreated) {
            $tenantProduct->increment('stock', $_product['quantity']);
        }

        $tenantProduct->purchases()->create([
            'description' => "{$product->name}: Inventario inicial (Productos enviados desde la sucursal principal)",
            'stock' => $product->stock,
            'price' => $product->price,
        ]);
    }
}
