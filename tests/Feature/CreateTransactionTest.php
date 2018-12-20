<?php

namespace Tests\Feature;

use Bouncer;
use Tests\TestCase;
use App\{Product, Transaction, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authorized_user_can_create_transaction()
    {
        $uvas = factory(Product::class)->create(['stock' => 10]);
        $manzanas = factory(Product::class)->create(['stock' => 10]);

        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('create', Transaction::class);

        $response = $this->actingAs($user)->post(route('transactions.store'), [
            'products' => [
                ['id' => $uvas->id, 'quantity' => 1, 'description' => 'Descripcion uvas'],
                ['id' => $manzanas->id, 'quantity' => 2, 'description' => 'Descripcion manzanas']
            ],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('transactions', [
            'branch_office_id' => 0,
            'product_id' => $uvas->id,
            'description' => 'Descripcion uvas'
        ]);

        $this->assertDatabaseHas('products', [
           'id' => $uvas->id,
           'stock' => 9
        ]);

        $this->assertDatabaseHas('transactions', [
            'branch_office_id' => 0,
            'product_id' => $manzanas->id,
            'description' => 'Descripcion manzanas'
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $manzanas->id,
            'stock' => 8
        ]);
    }

    /** @test */
    function unauthorized_user_cannot_create_transaction()
    {
        $uvas = factory(Product::class)->create();
        $manzanas = factory(Product::class)->create();

        $user = factory(User::class)->create();

        $response = $this->withExceptionHandling()->actingAs($user)->post(route('transactions.store'), [
            'products' => [
                ['id' => $uvas->id, 'quantity' => 1, 'description' => 'Descripcion uvas'],
                ['id' => $manzanas->id, 'quantity' => 2, 'description' => 'Descripcion manzanas']
            ],
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('transactions', [
            'branch_office_id' => 0,
            'product_id' => $uvas->id,
            'description' => 'Descripcion uvas'
        ]);

        $this->assertDatabaseMissing('transactions', [
            'branch_office_id' => 0,
            'product_id' => $manzanas->id,
            'description' => 'Descripcion manzanas'
        ]);
    }

    /** @test */
    function it_cannot_exceed_product_stock_in_transaction()
    {
        $uvas = factory(Product::class)->create(['stock' => 10]);

        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('create', Transaction::class);

        $response = $this->withExceptionHandling()->actingAs($user)->post(route('transactions.store'), [
            'products' => [
                ['id' => $uvas->id, 'quantity' => 11, 'description' => 'Descripcion uvas'],
            ],
        ]);

        $response->assertStatus(400);

        $this->assertDatabaseMissing('transactions', [
            'branch_office_id' => 0,
            'product_id' => $uvas->id,
            'description' => 'Descripcion uvas'
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $uvas->id,
            'stock' => 10
        ]);
    }

    /** @test */
    function product_status_change_when_you_run_out_of_stock()
    {
        $uvas = factory(Product::class)->create(['stock' => 10]);

        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('create', Transaction::class);

        $response = $this->withExceptionHandling()->actingAs($user)->post(route('transactions.store'), [
            'products' => [
                ['id' => $uvas->id, 'quantity' => 10, 'description' => 'Descripcion uvas'],
            ],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('transactions', [
            'branch_office_id' => 0,
            'product_id' => $uvas->id,
            'description' => 'Descripcion uvas'
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $uvas->id,
            'stock' => 0,
            'status' => Product::NO_DISPONIBLE,
        ]);
    }
}
