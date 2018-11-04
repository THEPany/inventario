<?php

namespace App\Listeners;

use App\Product;
use App\Events\ProductStatus;

class ProductWithOutStock
{
    /**
     * Handle the event.
     *
     * @param \App\Events\ProductStatus $event
     * @return void
     */
    public function handle(ProductStatus $event)
    {
        if ($event->product->stock === 0 && $event->product->status === Product::DISPONIBLE){
            $event->product->status = Product::NO_DISPONIBLE;
            $event->product->save();
        }
    }
}
