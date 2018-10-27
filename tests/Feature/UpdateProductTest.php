<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{Product, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function only_authorized_users_can_update_products()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->put(route('products.update', $product), [
            'name' => 'Platano',
            'provider_id' => $product->provider_id,
            'stock' => $product->stock,
            'price' => $product->price,
            'description' => $product->description
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas(['flash_success' => 'Producto Platano actualizado exitosamente']);

        $this->assertDatabaseHas('products', [
            'name' => 'Platano',
            'provider_id' => $product->provider_id,
        ]);
    }

    /** @test */
    function guest_cannot_update_products()
    {
        $product = factory(Product::class)->create();
        
        $response = $this->withExceptionHandling()->put(route('products.update', $product), []);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
