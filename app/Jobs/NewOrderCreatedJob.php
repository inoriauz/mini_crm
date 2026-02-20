<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewOrderCreatedJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public int $orderId)
    {
        //
    }

    public function handle(): void
    {
        Log::info("New order created: {$this->orderId}");
    }
}
