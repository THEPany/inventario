<?php

namespace App\Http\Requests;

use App\Product;
use App\Transaction;
use App\Events\ProductStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'numeric'],
            'products.*.quantity' => ['required', 'numeric'],
            'products.*.description' => ['nullable', 'min:10', 'max:255'],
        ];
    }

    public function createTransaction()
    {
        DB::transaction(function () {
            collect($this->products)->each(function ($_product) {
                $product = Product::findOrfail($_product['id']);

                $this->abortCases($product, $_product['quantity']);

                Transaction::createTransaction($product, $_product);

                $product->decrement('stock', $_product['quantity']);

                event(new ProductStatus($product));
            });
        });

        return "Transacción completada con éxito";
    }

    public function abortCases(Product $product, $quantity)
    {
        abort_if($product->stock < $quantity,
            400,
            "No se puede realizar la transacción para el producto {$product->name}, la cantidad solicitada excede el stock del mismo");
    }
}
