<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    const DISPONIBLE = "Disponible";
    const NO_DISPONIBLE = "No disponible";

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function branch_office()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    public function scopeMainProducts($query)
    {
        return $query->whereNull('branch_office_id');
    }

    public function isMainProdut()
    {
        return $this->branch_office_id == 0;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
