<?php


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('can login with credentials', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'role',
                    'created_at',
                    'updated_at',
                ],
            ],
            'message',
        ]);
});

it('cannot login with invalid credentials', function () {
    $response = $this->postJson('/api/login', [
        'email' => 'invalid@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
        ->assertJsonStructure([
            'success',
            'message',
        ]);
});

it('can logout', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data',
            'message',
        ]);
});
