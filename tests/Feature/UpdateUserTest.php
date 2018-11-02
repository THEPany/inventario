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
                'email' => 'cristiangomeze@hotmail.com',
            ])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Usuario cristian gomez actualizado con exito."]);

        $this->assertDatabaseHas('users', [
            'name' => 'cristian gomez',
            'email' => 'cristiangomeze@hotmail.com',
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
            'email' => 'cristiangomeze@hotmail.com',
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_update_branchOffice()
    {
        $user = factory(User::class)->create();

        $this->withExceptionHandling()->actingAs($user)
            ->put(route('users.update', $user), [
                'name' => 'cristian gomez',
                'email' => 'cristiangomeze@hotmail.com',
            ])
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('users', [
            'name' => 'cristian gomez',
            'email' => 'cristiangomeze@hotmail.com',
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
            ->assertSessionHasErrors(['name', 'email']);

        $this->assertDatabaseMissing('users', [
            'name' => 'cristian gomez',
            'email' => 'cristiangomeze@hotmail.com',
        ]);
    }

    /** @test */
    function email_must_be_unique()
    {
        $admin = factory(User::class)->create();
        $user = factory(User::class)->create();

        Bouncer::allow($admin)->to('update', User::class);

        $this->handleValidationExceptions()->actingAs($admin)
            ->put(route('users.update', $user), [
                'name' => 'cristian gomez',
                'email' => $admin->email
            ])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['email']);
    }
}