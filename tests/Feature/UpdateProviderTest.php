<?php

namespace Tests\Feature;

use Bouncer;
use Tests\TestCase;
use App\{Provider, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProviderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function only_authorized_users_can_update_providers()
    {
        $user = factory(User::class)->create();
        $provider = factory(Provider::class)->create();

        Bouncer::allow($user)->to('update', $provider);

        $response = $this->actingAs($user)->put("providers/{$provider->id}", [
            'name' => 'Provedor 1',
            'phone' => '(999) 999-9999',
            'address' => 'Direccion valida',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas(['flash_success' => 'Proveedor Provedor 1 actualizado exitosamente']);

        $this->assertDatabaseHas('providers', [
            'name' => 'Provedor 1',
            'phone' => '(999) 999-9999',
            'address' => 'Direccion valida'
        ]);
    }

    /** @test */
    function guest_cannot_update_providers()
    {
        $provider = factory(Provider::class)->create();

        $response = $this->withExceptionHandling()->put("providers/{$provider->id}", []);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    function provider_update_name_must_be_required()
    {
        $user = factory(User::class)->create();
        $provider = factory(Provider::class)->create();

        Bouncer::allow($user)->to('update', $provider);

        $response = $this->handleValidationExceptions()->actingAs($user)->put("providers/{$provider->id}", [
            'name' => '',
            'phone' => '(999) 999-9999',
            'address' => 'Direccion valida',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    function provider_update_phone_must_be_required()
    {
        $user = factory(User::class)->create();
        $provider = factory(Provider::class)->create();

        Bouncer::allow($user)->to('update', $provider);

        $response = $this->handleValidationExceptions()->actingAs($user)->put("providers/{$provider->id}", [
            'name' => 'Provedor 1',
            'phone' => '',
            'address' => 'Direccion valida',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    /** @test */
    function provider_update_phone_min_must_be_14()
    {
        $user = factory(User::class)->create();
        $provider = factory(Provider::class)->create();

        Bouncer::allow($user)->to('update', $provider);

        $response = $this->handleValidationExceptions()->actingAs($user)->put("providers/{$provider->id}", [
            'name' => 'Provedor 1',
            'phone' => '(999) 999-999',
            'address' => 'Direccion valida',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    /** @test */
    function provider_update_phone_max_must_be_14()
    {
        $user = factory(User::class)->create();
        $provider = factory(Provider::class)->create();

        Bouncer::allow($user)->to('update', $provider);

        $response = $this->handleValidationExceptions()->actingAs($user)->put("providers/{$provider->id}", [
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
        $provider = factory(Provider::class)->create();
        factory(Provider::class)->create(['phone' => '(999) 999-9999']);

        Bouncer::allow($user)->to('update', $provider);

        $response = $this->handleValidationExceptions()->actingAs($user)->put("providers/{$provider->id}", [
            'name' => 'Provedor 1',
            'phone' => '(999) 999-9999',
            'address' => 'Direccion valida',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    /** @test */
    function provider_update_address_must_be_required()
    {
        $user = factory(User::class)->create();
        $provider = factory(Provider::class)->create();

        Bouncer::allow($user)->to('update', $provider);

        $response = $this->handleValidationExceptions()->actingAs($user)->put("providers/{$provider->id}", [
            'name' => 'Provedor 1',
            'phone' => '(999) 999-9999',
            'address' => '',
        ]);

        $response->assertSessionHasErrors(['address']);
    }

    /** @test */
    function provider_update_address_min_must_be_15()
    {
        $user = factory(User::class)->create();
        $provider = factory(Provider::class)->create();

        Bouncer::allow($user)->to('update', $provider);

        $response = $this->handleValidationExceptions()->actingAs($user)->put("providers/{$provider->id}", [
            'name' => 'Provedor 1',
            'phone' => '(999) 9999-9999',
            'address' => 'Direccion',
        ]);

        $response->assertSessionHasErrors(['address']);
    }
}
