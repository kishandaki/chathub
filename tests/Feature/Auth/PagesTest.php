<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_loads(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertSee("Reset your password");
    }

    public function test_reset_password_page_loads(): void
    {
        $response = $this->get('/reset-password/fake-token');
        $response->assertStatus(200);
    }

    public function test_verify_email_page_loads(): void
    {
        $response = $this->get('/verify-email');
        $response->assertStatus(200);
    }

    public function test_account_locked_page_loads(): void
    {
        $response = $this->get('/account-locked');
        $response->assertStatus(200);
    }

    public function test_session_expired_page_loads(): void
    {
        $response = $this->get('/session-expired');
        $response->assertStatus(200);
    }

    public function test_403_page_loads(): void
    {
        $response = $this->get('/403');
        $response->assertStatus(200);
    }

    public function test_404_page_loads(): void
    {
        $response = $this->get('/404');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_logout(): void
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

        $this->actingAs($user);

        $response = $this->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
