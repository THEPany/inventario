<?php

namespace Tests\Feature\User;

use Bouncer;
use Tests\TestCase;
use App\{User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_update_users()
    {
        $user = factory(User::class)->create();
        $admin = factory(User::class)->create();

        Bouncer::allow($admin)->to('update', User::class);

        $this->actingAs($admin)
            ->put(route('users.update', $user), [
                'name' => 'cristian gomez',
                'username' => 'cgomez',
                'branch_office_id' => 0
            ])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Usuario Cristian Gomez actualizado con exito."]);

        $this->assertDatabaseHas('users', [
            'name' => 'cristian gomez',
            'username' => 'cgomez',
        ]);
    }

    /** @test */
    function an_guest_cannot_update_users()
    {
        $user = factory(User::class)->create();

        $this->withExceptionHandling()->put(route('users.update', $user), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('users', [
            'name' => 'cristian gomez',
            'username' => 'cgomez',
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_update_branchOffice()
    {
        $user = factory(User::class)->create();

        $this->withExceptionHandling()->actingAs($user)
            ->put(route('users.update', $user), [
                'name' => 'cristian gomez',
                'username' => 'cgomez',
                'branch_office_id' => 0
            ])
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('users', [
            'name' => 'cristian gomez',
            'username' => 'cgomez',
        ]);
    }

    /** @test */
    function it_can_see_validations_errors()
    {
        $admin = factory(User::class)->create();
        $user = factory(User::class)->create();

        Bouncer::allow($admin)->to('update', User::class);

        $this->handleValidationExceptions()->actingAs($admin)
            ->put(route('users.update', $user), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'username']);

        $this->assertDatabaseMissing('users', [
            'name' => 'cristian gomez',
            'username' => 'cgomez',
        ]);
    }

    /** @test */
    function username_must_be_unique()
    {
        $admin = factory(User::class)->create();
        $user = factory(User::class)->create();

        Bouncer::allow($admin)->to('update', User::class);

        $this->handleValidationExceptions()->actingAs($admin)
            ->put(route('users.update', $user), [
                'name' => 'cristian gomez',
                'username' => $admin->username
            ])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['username']);
    }
}