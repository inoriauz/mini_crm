<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can get their orders', function () {

    $manager = User::factory()->create();
    $client = Client::factory()->create();

    Order::factory()->count(3)->create([
        'manager_id' => $manager->id,
        'client_id' => $client->id,
    ]);

    $token = $manager->createToken('api-token')->plainTextToken;

    $response = $this->withToken($token)->getJson('/api/orders');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Orders retrieved successfully',
        ])
        ->assertJsonCount(3, 'data');

});

test('unauthenticated user cannot get orders', function () {

    $response = $this->getJson('/api/orders');

    $response->assertStatus(401);

});

test('manager only sees their own orders', function () {

    $manager1 = User::factory()->create();
    $manager2 = User::factory()->create();
    $client = Client::factory()->create();

    Order::factory()->count(3)->create(['manager_id' => $manager1->id, 'client_id' => $client->id]);
    Order::factory()->count(5)->create(['manager_id' => $manager2->id, 'client_id' => $client->id]);

    $token = $manager1->createToken('api-token')->plainTextToken;

    $response = $this->withToken($token)->getJson('/api/orders');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');

});

test('orders can be filtered by status', function () {

    $manager = User::factory()->create();
    $client = Client::factory()->create();

    Order::factory()->count(2)->create([
        'manager_id' => $manager->id,
        'client_id' => $client->id,
        'status' => 'new',
    ]);

    Order::factory()->count(3)->create([
        'manager_id' => $manager->id,
        'client_id' => $client->id,
        'status' => 'in_progress',
    ]);

    $token = $manager->createToken('api-token')->plainTextToken;

    $response = $this->withToken($token)->getJson('/api/orders?status=in_progress');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');

});

test('admin can see all orders', function () {

    $admin = User::factory()->create(['role' => 'admin']);
    $manager1 = User::factory()->create();
    $manager2 = User::factory()->create();
    $client = Client::factory()->create();

    Order::factory()->count(3)->create(['manager_id' => $manager1->id, 'client_id' => $client->id]);
    Order::factory()->count(4)->create(['manager_id' => $manager2->id, 'client_id' => $client->id]);

    $token = $admin->createToken('api-token')->plainTextToken;

    $response = $this->withToken($token)->getJson('/api/orders');

    $response->assertStatus(200)
        ->assertJsonCount(7, 'data');

});
