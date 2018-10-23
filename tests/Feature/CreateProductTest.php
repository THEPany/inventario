<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{User, Provider};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function only_authorized_users_can_create_products()
    {
        $provider = factory(Provider::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Platano',
            'provider_id' => $provider->id,
            'stock' => 10,
            'price' => 7.5,
            'description' => 'Descripcion del producto'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas(['flash_success' => 'Producto Platano creado exitosamente']);

        $this->assertDatabaseHas('products', [
            'name' => 'Platano',
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
}
