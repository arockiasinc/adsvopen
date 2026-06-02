<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginFallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_form_can_fall_back_to_a_native_post(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('wire:submit="authenticate"', false)
            ->assertSee('name="_token"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('name="remember"', false);
    }

    public function test_native_admin_login_post_authenticates_an_admin(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '1',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/admin');
    }

    public function test_native_admin_login_post_rejects_non_admins(): void
    {
        $user = User::factory()->create([
            'role' => 'advertiser',
            'is_approved' => true,
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('data.email');
    }
}
