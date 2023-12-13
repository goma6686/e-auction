<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BidPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction;

    /**
     * Create a new event instance.
     */
    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    /*public function broadcastOn()
    {
        return ['Bids'];
    }*/

    public function broadcastOn(): Channel
    {
       return new Channel('auctions.'.$this->auction->uuid);
        //return new Channel ('auction');
    }

    public function broadcastAs()
    {
      //return 'my-bids';
      return 'my-bids.' .$this->auction->uuid;
    }

    public function broadcastWith()
    {
        return [
            'uuid' => $this->auction->uuid,
            'bidder_count' => $this->auction->bids()->count(),
            'price' => $this->auction->price
        ];
    }
}
