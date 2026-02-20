<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        $managers = User::all();

        $clients->each(function ($client) use ($managers) {

            $orders = Order::factory()->count(3)->create([
                'client_id' => $client->id,
                'manager_id' => $managers->random()->id,
            ]);

            $orders->each(function ($order) {
                $oldStatus = $order->status;

                $order->update(['status' => 'in_progress']);

                OrderLog::create([
                    'order_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => 'in_progress',
                    'changed_by' => $order->manager_id,
                ]);
            });

        });
    }
}
