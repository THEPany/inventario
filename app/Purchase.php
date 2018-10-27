<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    const UPDATED_AT = null;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
