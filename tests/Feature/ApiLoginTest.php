<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can login with valid credentials', function () {

    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'token',
                'user' => ['id', 'name', 'email', 'role'],
            ],
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Logged in successfully',
        ]);

});

test('user cannot login with invalid password', function () {

    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'success' => false,
            'message' => 'Invalid credentials',
        ]);

});

test('user cannot login with non-existent email', function () {

    $response = $this->postJson('/api/login', [
        'email' => 'notexist@gmail.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'success' => false,
            'message' => 'Invalid credentials',
        ]);

});

test('login validates required fields', function () {

    $response = $this->postJson('/api/login', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);

});

test('login validates email format', function () {

    $response = $this->postJson('/api/login', [
        'email' => 'not-an-email',
        'password' => 'password123',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);

});

test('user can logout', function () {

    $user = User::factory()->create();

    $token = $user->createToken('api-token')->plainTextToken;

    $response = $this->withToken($token)->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);

    $this->assertDatabaseCount('personal_access_tokens', 0);

});

test('unauthenticated user cannot logout', function () {

    $response = $this->postJson('/api/logout');

    $response->assertStatus(401);

});
