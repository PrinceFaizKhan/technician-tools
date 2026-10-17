<?php

namespace Tests\Feature;

use App\Models\AppSetting;
use App\Models\User;
use App\Services\AppSettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin login endpoint.
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('nasruddin@#321@#'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'nasruddin@#321@#',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'token',
                    'user' => ['id', 'name', 'email', 'role'],
                ],
            ]);
    }

    /**
     * Test invalid login fails with 401.
     */
    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJsonPath('success', false);
    }

    /**
     * Test appliances list endpoint.
     */
    public function test_can_list_appliances(): void
    {
        $response = $this->getJson('/api/v1/appliances');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    /**
     * Test error codes search endpoint.
     */
    public function test_can_search_error_codes(): void
    {
        $response = $this->getJson('/api/v1/error-codes?search=error');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data',
                'pagination' => ['current_page', 'last_page', 'total'],
            ]);
    }

    /**
     * Test settings endpoint and singleton service.
     */
    public function test_settings_service_singleton_behavior(): void
    {
        AppSetting::create([
            'key' => 'app_name',
            'value' => "Technician's Toolkit",
        ]);

        $service1 = app(AppSettingsService::class);
        $service2 = app(AppSettingsService::class);

        $this->assertSame($service1, $service2);

        $response = $this->getJson('/api/v1/settings');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'app_name',
                    'whatsapp_support',
                    'whatsapp_group_url',
                    'version_info',
                ],
            ]);
    }
}
