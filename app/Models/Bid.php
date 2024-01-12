<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'amount',
        'user_uuid',
        'auction_uuid',
        'created_at',
    ];

    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function calculateBid($currentPrice, $increment){
        return $currentPrice + $increment;
    }

    public static function incremets(){
        return collect([
            ['from' => 0.01, 'to' => 0.99, 'increment' => 0.05],
            ['from' => 1.00, 'to' => 4.99, 'increment' => 0.25],
            ['from' => 5.00, 'to' => 24.99, 'increment' => 0.50],
            ['from' => 25.00, 'to' => 99.99, 'increment' => 1.00],
            ['from' => 100.00, 'to' => 249.99, 'increment' => 2.50],
            ['from' => 250.00, 'to' => 499.99, 'increment' => 5.00],
            ['from' => 500.00, 'to' => 999.99, 'increment' => 10.00],
            ['from' => 1000.00, 'to' => 2499.99, 'increment' => 25.00],
            ['from' => 2500.00, 'to' => 4999.99, 'increment' => 50.00],
            ['from' => 5000.00, 'to' => 10000.00, 'increment' => 100.00],
        ]);
    }
}
