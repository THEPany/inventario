<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{User, Product};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function only_authorized_users_can_create_purchases()
    {
        $product = factory(Product::class)->create(['stock' => 10, 'price' => 500,]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post(route('purchases.store', [
            'product_id' => $product->id,
            'stock' => 10,
            'price' => 1000,
        ]));

        $response->status(302);
        $response->assertSessionHas(['flash_success' => "Compra de {$product->name} registrada exitosamente"]);

        $this->assertDatabaseHas('purchases', [
            'stock' => 10,
            'description' => "{$product->name} : Compra realizada por {$user->name} al proveedor {$product->provider->name}"
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 20,
            'price' => 1000,
        ]);
    }
}
