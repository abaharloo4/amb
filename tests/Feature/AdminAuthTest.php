<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_admin_can_authenticate_using_the_login_screen(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@abaharlou.ir',
            'password' => 'Password123!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@abaharlou.ir',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_authenticated_admin_can_access_dashboard_and_crud(): void
    {
        $user = User::where('email', 'admin@abaharlou.ir')->first();

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/admin/resources/projects');
        $response->assertStatus(200);
        $response->assertSee('پروژه‌ها');
    }
}
