<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'comment',
        'client_id',
        'manager_id',
    ];

    public function client(): BelongsTo
    {

        return $this->belongsTo(Client::class);

    }

    public function manager(): BelongsTo
    {

        return $this->belongsTo(User::class, 'manager_id');

    }

    public function logs()
    {

        return $this->hasMany(OrderLog::class);

    }
}
