<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_register_from_landing_page_as_member(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Ali Bin Abu',
            'email' => 'ali@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('assistance-requests.index'));
        $this->assertAuthenticated();

        $user = User::where('email', 'ali@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('member', $user->role);
    }

    public function test_registration_ignores_submitted_role_and_still_creates_member(): void
    {
        $this->post(route('register'), [
            'name' => 'Siti Binti Abu',
            'email' => 'siti@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $user = User::where('email', 'siti@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('member', $user->role);
    }
}
