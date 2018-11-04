<?php

namespace Tests\Feature;

use Bouncer;
use Tests\TestCase;
use App\{BranchOffice, Product, User, Transaction};
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionPassProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_can_pass_products_to_other_branch_office()
    {
        $branchOffice = factory(BranchOffice::class)->create();
        $uvas = factory(Product::class)->create(['stock' => 10]);
        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('move-product', Transaction::class);

        $response = $this->actingAs($user)->post(route('transaction.pass.store'), [
            'branch_office_id' => $branchOffice->id,
            'products' => [
                ['id' => $uvas->id, 'quantity' => 5, 'description' => 'Descripcion uvas'],
            ],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('transactions', [
            'branch_office_id' => null,
            'product_id' => $uvas->id,
            'description' => 'Descripcion uvas'
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $uvas->id,
            'stock' => 5
        ]);

        $this->assertDatabaseHas('products', [
            'branch_office_id' => $branchOffice->id,
            'stock' => 5
        ]);

        $this->assertDatabaseHas('purchases', [
            'stock' => 5,
        ]);
    }

    /** @test */
    function it_can_pass_products_to_other_branch_office_not_create_if_exist()
    {
        $branchOffice = factory(BranchOffice::class)->create();
        $uvas = factory(Product::class)->create(['name' => 'uvas', 'stock' => 10]);
        $tenantUvas = factory(Product::class)->create(['name' => 'uvas', 'stock' => 10, 'branch_office_id' => $branchOffice->id]);

        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('move-product', Transaction::class);

        $response = $this->actingAs($user)->post(route('transaction.pass.store'), [
            'branch_office_id' => $branchOffice->id,
            'products' => [
                ['id' => $uvas->id, 'quantity' => 5, 'description' => 'Descripcion uvas'],
            ],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('transactions', [
            'branch_office_id' => null,
            'product_id' => $uvas->id,
            'description' => 'Descripcion uvas'
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $uvas->id,
            'stock' => 5,
            'name' => 'uvas'
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $tenantUvas->id,
            'branch_office_id' => $branchOffice->id,
            'stock' => 15,
            'name' => 'uvas',
        ]);

        $this->assertDatabaseHas('purchases', [
            'stock' => 5,
            'product_id' => $tenantUvas->id
        ]);
    }

}
