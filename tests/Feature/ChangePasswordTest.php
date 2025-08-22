<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_change_password_with_valid_data()
    {
        // Create user
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        // Authenticate user
        Sanctum::actingAs($user);

        // Make request to change password
        $response = $this->postJson('/api/auth/change-password', [
            'current_password' => 'oldpassword',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        // Assert response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Password berhasil diubah',
            ]);

        // Assert password was actually changed
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    public function test_user_cannot_change_password_with_wrong_current_password()
    {
        // Create user
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        // Authenticate user
        Sanctum::actingAs($user);

        // Make request with wrong current password
        $response = $this->postJson('/api/auth/change-password', [
            'current_password' => 'wrongpassword',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        // Assert response
        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Password saat ini salah',
            ]);

        // Assert password was not changed
        $this->assertTrue(Hash::check('oldpassword', $user->fresh()->password));
    }

    public function test_user_cannot_change_password_without_authentication()
    {
        // Make request without authentication
        $response = $this->postJson('/api/auth/change-password', [
            'current_password' => 'oldpassword',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        // Assert response
        $response->assertStatus(401);
    }

    public function test_validation_errors_for_missing_fields()
    {
        // Create user
        $user = User::factory()->create();

        // Authenticate user
        Sanctum::actingAs($user);

        // Make request with missing fields
        $response = $this->postJson('/api/auth/change-password', []);

        // Assert validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['current_password', 'new_password']);
    }

    public function test_validation_error_for_password_confirmation_mismatch()
    {
        // Create user
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        // Authenticate user
        Sanctum::actingAs($user);

        // Make request with mismatched password confirmation
        $response = $this->postJson('/api/auth/change-password', [
            'current_password' => 'oldpassword',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'differentpassword',
        ]);

        // Assert validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['new_password']);
    }

    public function test_validation_error_for_short_password()
    {
        // Create user
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        // Authenticate user
        Sanctum::actingAs($user);

        // Make request with short password
        $response = $this->postJson('/api/auth/change-password', [
            'current_password' => 'oldpassword',
            'new_password' => '123',
            'new_password_confirmation' => '123',
        ]);

        // Assert validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['new_password']);
    }
}
