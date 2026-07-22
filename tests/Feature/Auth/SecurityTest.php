<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_locks_after_multiple_failed_attempts(): void
    {
        $user = User::create([
            'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => Hash::make('secret'),
            'status' => 'active',
        ]);

        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrong',
            ]);
            $response->assertSessionHasErrors();
        }

        $user->refresh();
        $this->assertNotNull($user->locked_until);
        $this->assertEquals(5, $user->failed_login_attempts);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'secret',
        ]);
        $response->assertRedirect('/account-locked');
    }

    public function test_two_factor_page_redirects_guest(): void
    {
        $response = $this->get('/two-factor');
        $response->assertRedirect('/login');
    }
}
