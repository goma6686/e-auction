<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $message;
   // public $auction_uuid;
    public $receiver_uuid;

    public function __construct($message, $receiver_uuid )
    {
        $this->message = $message;
        //$this->auction_uuid = $auction_uuid;
        $this->receiver_uuid = $receiver_uuid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            //new Channel('message-sent'.$this->user_uuid),
            new PrivateChannel('message-sent'.$this->receiver_uuid),
            //new Channel('message-sent'.$this->receiver_uuid),
        ];
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}
