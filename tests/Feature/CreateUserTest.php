<?php

namespace Tests\Feature\User;

use Bouncer;
use App\{User};
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_authorized_user_can_create_users()
    {
        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('create', User::class);

        $this->actingAs($user)
            ->post(route('users.store'), [
                'name' => 'cristian gomez',
                'username' => 'cgomez',
                'password' => 'secret',
                'password_confirmation' => 'secret',
                'branch_office_id' => 0
            ])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Usuario Cristian Gomez creado con éxito."]);

        $this->assertCredentials([
            'name' => 'cristian gomez',
            'username' => 'cgomez',
            'password' => 'secret',
        ]);
    }

    /** @test */
    function an_guest_cannot_create_users()
    {
        $this->withExceptionHandling()->post(route('users.store'), [
            'name' => 'cristian gomez',
            'username' => 'cgomez',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'branch_office_id' => 0
        ])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('users', [
            'name' => 'cristian gomez',
            'username' => 'cgomez',
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_create_users()
    {
        $user = factory(User::class)->create();

        $this->withExceptionHandling()->actingAs($user)
            ->post(route('users.store'), [
                'name' => 'cristian gomez',
                'username' => 'cgomez',
                'password' => 'secret',
                'password_confirmation' => 'secret',
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
        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('create', User::class);

        $this->handleValidationExceptions()->actingAs($user)
            ->post(route('users.store'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name', 'username', 'password']);

        $this->assertDatabaseMissing('users', [
            'name' => 'cristian gomez',
            'username' => 'cgomez',
        ]);
    }

    /** @test */
    function username_must_be_unique()
    {
        $user = factory(User::class)->create();

        Bouncer::allow($user)->to('create', User::class);

        $this->handleValidationExceptions()->actingAs($user)
            ->post(route('users.store'), [
                'name' => 'cristian gomez',
                'username' => $user->username,
            ])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['username']);

        $this->assertDatabaseMissing('users', [
            'name' => 'cristian gomez',
            'username' => 'cgomez',
        ]);
    }
}