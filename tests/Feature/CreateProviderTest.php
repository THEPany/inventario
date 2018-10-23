<?php

namespace Tests\Feature;

use App\Provider;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProviderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function only_authorized_users_can_create_providers()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('providers', [
           'name' => 'Provedor 1',
           'phone' => '(999) 999-9999',
           'address' => 'Direccion valida',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas(['flash_success' => 'Proveedor Provedor 1 creado exitosamente']);

        $this->assertDatabaseHas('providers', [
            'name' => 'Provedor 1',
            'phone' => '(999) 999-9999',
            'address' => 'Direccion valida'
        ]);
    }

    /** @test */
    function guest_cannot_create_providers()
    {
        $response = $this->withExceptionHandling()->post('providers', []);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    function provider_store_name_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->handleValidationExceptions()->actingAs($user)->post('providers', [
            'name' => '',
            'phone' => '(999) 999-9999',
            'address' => 'Direccion valida',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    function provider_store_phone_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->handleValidationExceptions()->actingAs($user)->post('providers', [
            'name' => 'Provedor 1',
            'phone' => '',
            'address' => 'Direccion valida',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    /** @test */
    function provider_store_phone_min_must_be_14()
    {
        $user = factory(User::class)->create();

        $response = $this->handleValidationExceptions()->actingAs($user)->post('providers', [
            'name' => 'Provedor 1',
            'phone' => '(999) 999-999',
            'address' => 'Direccion valida',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    /** @test */
    function provider_store_phone_max_must_be_14()
    {
        $user = factory(User::class)->create();

        $response = $this->handleValidationExceptions()->actingAs($user)->post('providers', [
            'name' => 'Provedor 1',
            'phone' => '(999) 9999-9999',
            'address' => 'Direccion valida',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    /** @test */
    function provider_store_phone_must_be_unique()
    {
        $user = factory(User::class)->create();
        factory(Provider::class)->create(['phone' => '(999) 999-9999']);

        $response = $this->handleValidationExceptions()->actingAs($user)->post('providers', [
            'name' => 'Provedor 1',
            'phone' => '(999) 999-9999',
            'address' => 'Direccion valida',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    /** @test */
    function provider_store_address_must_be_required()
    {
        $user = factory(User::class)->create();

        $response = $this->handleValidationExceptions()->actingAs($user)->post('providers', [
            'name' => 'Provedor 1',
            'phone' => '(999) 999-9999',
            'address' => '',
        ]);

        $response->assertSessionHasErrors(['address']);
    }

    /** @test */
    function provider_store_address_min_must_be_15()
    {
        $user = factory(User::class)->create();

        $response = $this->handleValidationExceptions()->actingAs($user)->post('providers', [
            'name' => 'Provedor 1',
            'phone' => '(999) 9999-9999',
            'address' => 'Direccion',
        ]);

        $response->assertSessionHasErrors(['address']);
    }
}
