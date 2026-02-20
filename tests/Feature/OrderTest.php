<?php

use App\Models\Order;
use App\Models\Client;
use App\Models\User;
use App\Models\OrderLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('order can be created', function () {

    $client = Client::factory()->create();
    $manager = User::factory()->create();

    $order= Order::factory()->create([
        'manager_id' => $manager->id,
        'client_id' => $client->id,
        'comment' => 'test comment'
    ]);

    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'status' => 'new',
    ]);
});

test('order belongs to client and manager', function () {

    $client = Client::factory()->create();
    $manager = User::factory()->create();

    $order = Order::factory()->create([
        'client_id' => $client->id,
        'manager_id' => $manager->id,
    ]);

    expect($order->client->id)->toBe($client->id)
        ->and($order->manager->id)->toBe($manager->id);
});


test('order log can be created', function () {

    $order = Order::factory()->create();
    $user = User::factory()->create();

    OrderLog::create([
        'order_id' => $order->id,
        'old_status' => 'new',
        'new_status' => 'in_progress',
        'changed_by' => $user->id,
    ]);

    $this->assertDatabaseHas('order_logs', [
        'order_id' => $order->id,
        'new_status' => 'in_progress',
    ]);
});


test('order has many logs', function () {

    $order = Order::factory()->create();
    $user = User::factory()->create();

    OrderLog::factory()->count(3)->create([
        'order_id' => $order->id,
        'changed_by' => $user->id,
    ]);

    expect($order->logs)->toHaveCount(3);
});


test('changing order status creates log', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    $order = Order::factory()->create([
        'status' => 'new',
    ]);

    $order->update([
        'status' => 'in_progress',
    ]);

    $this->assertDatabaseHas('order_logs', [
        'order_id' => $order->id,
        'new_status' => 'in_progress',
        'changed_by' => $user->id,
    ]);
});
