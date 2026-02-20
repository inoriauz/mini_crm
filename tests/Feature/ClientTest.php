<?php

use App\Models\Client;
use App\Models\Order;

test('client has many orders', function () {

    $client = Client::factory()->create();

    Order::factory()->count(3)->create([
        'client_id' => $client->id,
    ]);

    expect($client->orders)->toHaveCount(3);

});

