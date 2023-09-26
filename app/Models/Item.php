<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function auctions()
    {
        return $this->hasOne(Auction::class, 'item_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
