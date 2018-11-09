<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    public static function createTransaction(Product $product, $_product)
    {
        return self::create([
            'product_id' => $product->id,
            'quantity' => $_product['quantity'],
            'description' => $_product['description'] ?? "Registro de transacción para {$product->name}"
        ]);
    }

    public function scopeMainTransactions($query)
    {
        return $query->whereNull('branch_office_id');
    }

    public function isMainTransaction()
    {
        return $this->branch_office_id === null;
    }
}
