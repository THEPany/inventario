<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function branch_office()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    public function scopeMainProviders($query)
    {
        return $query->where('branch_office_id', 0);
    }

    public function isMainProvider()
    {
        return $this->branch_office_id == 0;
    }
}
