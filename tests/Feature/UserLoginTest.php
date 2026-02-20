<?php

use App\Models\User;
use Filament\Auth\Pages\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login page loads successfully', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});


test('filament user can login', function () {

    $user = User::factory()->create([
        'password' => Hash::make('123456'),
    ]);

    Livewire::test(Login::class)
        ->set('data.email', $user->email)
        ->set('data.password', '123456')
        ->call('authenticate')
        ->assertRedirect();

    $this->assertAuthenticatedAs($user);

});

test('filament user cannot login with invalid credentials', function () {

    $user = User::factory()->create([
        'password' => Hash::make('123456'),
    ]);

    Livewire::test(Login::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'wrong-password')
        ->call('authenticate')
        ->assertHasErrors();

    $this->assertGuest();

});
