<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_uuid',
        'amount',
        'transaction_uuid',
        'transaction_type'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_uuid');
    }

    public function auction(){
        return $this->belongsTo(Auction::class, 'item_uuid');
    }
}
