<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_uuid',
        'auction_uuid',
        'final_amount',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
}
