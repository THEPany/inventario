<?php

namespace Tests\Feature;

use Bouncer;
use Tests\TestCase;
use App\{User, BranchOffice};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateBranchOfficeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function only_authorized_users_can_create_branch_office()
    {
        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('create', BranchOffice::class);

        $response = $this->actingAs($user)->post(route('branchOffice.store',[
            'name' => 'Sucursal 1',
        ]));

        $response->status(302);
        $response->assertSessionHas(['flash_success' => 'Sucursal Sucursal 1 Creada correctamente']);

        $this->assertDatabaseHas('branch_offices', [
           'name' => 'Sucursal 1',
           'slug' => 'sucursal-1'
        ]);
    }
}
