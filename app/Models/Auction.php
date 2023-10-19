<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Auction extends Model
{
    use HasFactory, HasUuids;
    
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }
}
