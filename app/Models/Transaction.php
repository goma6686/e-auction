<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_uuid',
        'auction_uuid',
        'amount',
        'transaction_uuid',
        'transaction_type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }

    public function auction(): HasOne
    {
        return $this->hasOne(Auction::class, 'auction_uuid');
    }
}
