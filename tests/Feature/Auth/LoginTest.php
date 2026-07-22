<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Sign in to Chat HUB');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::create([
            'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => Hash::make('secret'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'secret',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::create([
            'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('secret'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
