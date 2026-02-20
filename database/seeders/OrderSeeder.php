<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    use withoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        $managers = User::all();

        if ($clients->isEmpty() || $managers->isEmpty()) {
            return;
        }

        $clients->each(function ($client) use ($managers) {

            $order = Order::factory()
                ->count(3)
                ->create([
                    'client_id' => $client->id,
                    'manager_id' => $managers->random()->id,
                ])
                ->each(function ($order) {

                    $order->update([
                        'status' => 'in_progress'
                    ]);

                });

        });
    }
}
