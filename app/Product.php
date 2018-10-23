<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    const DISPONIBLE = "Disponible";
    const NO_DISPONIBLE = "No disponible";

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
