<?php

namespace App\Events;

use App\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Product
     */
    public $product;

    /**
     * Create a new event instance.
     *
     * @param \App\Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

}
