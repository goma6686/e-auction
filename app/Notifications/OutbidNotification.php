<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OutbidNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $auction;
    private $highest_bidder;
    private $user_uuid;


    /**
     * Create a new notification instance.
     */
    public function __construct($auction, $highest_bidder, $user_uuid)
    {
        $this->auction = $auction;
        $this->highest_bidder = $highest_bidder;
        $this->user_uuid = $user_uuid;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->markdown('auction.outbid',
        [
            'auction_title' => $this->auction->title,
            'username' => $this->highest_bidder->username,
            'url' => route('show-auction', $this->auction->uuid),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
        ];
    }

        /**
     * Determine the notification's delivery delay.
     *
     * @return array<string, \Illuminate\Support\Carbon>
     */
    public function withDelay(object $notifiable): array
    {
        return [
            'mail' => now()->addMinutes(5),
        ];
    }

    /**
     * Determine if the notification should be sent.
     */
    public function shouldSend(object $notifiable, string $channel): bool
    {
        return $this->user_uuid !== $this->highest_bidder->uuid;
    }
}
