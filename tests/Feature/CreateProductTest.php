<?php

namespace Tests\Feature;

use Bouncer;
use Tests\TestCase;
use App\{Product, User, Provider};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function only_authorized_users_can_create_products()
    {
        $provider = factory(Provider::class)->create();
        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('create', Product::class);

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'platano',
            'provider_id' => $provider->id,
            'stock' => 10,
            'price' => 7.5,
            'description' => 'Descripcion del producto'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas(['flash_success' => 'Producto Platano creado exitosamente']);

        $this->assertDatabaseHas('products', [
            'name' => 'platano',
            'provider_id' => $provider->id,
            'price' => 7.5
        ]);
    }

    /** @test */
    function guest_cannot_create_products()
    {
        $response = $this->withExceptionHandling()->post(route('products.store'), []);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    function when_create_product_a_purchase_is_registered()
    {
        $provider = factory(Provider::class)->create();
        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('create', Product::class);

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'platano',
            'provider_id' => $provider->id,
            'stock' => 10,
            'price' => 7.5,
            'description' => 'Descripcion del producto'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas(['flash_success' => 'Producto Platano creado exitosamente']);

        $this->assertDatabaseHas('purchases', [
            'description' => 'Platano: Inventario inicial',
            'stock' => 10,
            'price' => 7.5,
            'previous_price' => null,
        ]);
    }
}
