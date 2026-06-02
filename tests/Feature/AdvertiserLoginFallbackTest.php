<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvertiserLoginFallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_advertiser_login_form_can_fall_back_to_a_native_post(): void
    {
        $this->get('/advertiser/login')
            ->assertOk()
            ->assertSee('wire:submit="authenticate"', false)
            ->assertSee('name="_token"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('name="remember"', false);
    }

    public function test_native_advertiser_login_post_authenticates_an_approved_advertiser(): void
    {
        $user = User::factory()->create([
            'role' => 'advertiser',
            'is_approved' => true,
        ]);

        $response = $this->from('/advertiser/login')->post('/advertiser/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '1',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/advertiser');
    }

    public function test_native_advertiser_login_post_rejects_unapproved_advertisers(): void
    {
        $user = User::factory()->create([
            'role' => 'advertiser',
            'is_approved' => false,
        ]);

        $response = $this->from('/advertiser/login')->post('/advertiser/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/advertiser/login');
        $response->assertSessionHasErrors('data.email');
    }

    public function test_native_advertiser_login_post_rejects_non_advertisers(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'is_approved' => true,
        ]);

        $response = $this->from('/advertiser/login')->post('/advertiser/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/advertiser/login');
        $response->assertSessionHasErrors('data.email');
    }
}
