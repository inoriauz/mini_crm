<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLog extends Model
{

    protected $fillable = [
        'order_id',
        'old_status',
        'new_status',
        'change_by'
    ];

    public function order(): BelongsTo
    {

        return $this->belongsTo(Order::class);

    }

    public function changeBy(): BelongsTo
    {

        return $this->belongsTo(User::class, 'change_by');

    }
}
