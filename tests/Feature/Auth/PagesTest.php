<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee("Welcome back");
        $response->assertSee("Sign in");
    }

    public function test_forgot_password_page_loads(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertSee("Forgot your password?");
    }

    public function test_reset_password_page_loads(): void
    {
        $response = $this->get('/reset-password/fake-token');
        $response->assertStatus(200);
        $response->assertSee("Set a new password");
    }

    public function test_verify_email_page_loads(): void
    {
        $response = $this->get('/verify-email');
        $response->assertStatus(200);
        $response->assertSee("Verify your email");
    }

    public function test_account_locked_page_loads(): void
    {
        $response = $this->get('/account-locked');
        $response->assertStatus(200);
        $response->assertSee("Account Locked");
    }

    public function test_session_expired_page_loads(): void
    {
        $response = $this->get('/session-expired');
        $response->assertStatus(200);
        $response->assertSee("Session Expired");
    }

    public function test_403_page_loads(): void
    {
        $response = $this->get('/403');
        $response->assertStatus(200);
        $response->assertSee("Access Denied");
    }

    public function test_404_page_loads(): void
    {
        $response = $this->get('/404');
        $response->assertStatus(200);
        $response->assertSee("Page Not Found");
    }

    public function test_register_page_loads(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee("Create your account");
        $response->assertSee("Create Account");
    }

    public function test_otp_verify_page_loads(): void
    {
        $response = $this->get('/otp-verify');
        $response->assertStatus(200);
        $response->assertSee("Verify your identity");
    }

    public function test_change_password_page_loads(): void
    {
        $response = $this->get('/change-password');
        $response->assertStatus(200);
        $response->assertSee("Change your password");
    }

    public function test_two_factor_page_redirects_when_not_authenticated(): void
    {
        $response = $this->get('/two-factor');
        // 2FA page redirects guests since it requires a pending 2FA challenge
        $response->assertStatus(302);
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
