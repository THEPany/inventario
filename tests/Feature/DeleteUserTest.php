<?php

namespace Tests\Feature\User;

use Bouncer;
use App\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

    class DeleteuserTestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_delete_user()
    {
        $admin = factory(User::class)->create();
        $user = factory(User::class)->create();

        Bouncer::allow($admin)->to('delete', User::class);

        $this->actingAs($admin)
            ->delete(route('users.destroy', $user))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => "Usuario {$user->name} eliminado con éxito."]);

        $this->assertSoftDeleted('users', [
            'id' => $user->id,
            'name' => $user->name,
        ]);
    }

    /** @test */
    function an_guest_cannot_delete_user()
    {
        $admin = factory(User::class)->create();
        $user = factory(User::class)->create();

        Bouncer::allow($admin)->to('delete', User::class);

        $this->withExceptionHandling()->delete(route('users.destroy', $user))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
        ]);
    }

    /** @test */
    function an_unauthorized_user_cannot_delete_user()
    {
        $admin = factory(User::class)->create();
        $user = factory(User::class)->create();

        $this->withExceptionHandling()->actingAs($admin)->delete(route('users.destroy', $user))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name
        ]);
    }
}