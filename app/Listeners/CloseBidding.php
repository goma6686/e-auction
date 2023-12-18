<?php

namespace App\Listeners;

use App\Events\EndAuction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CloseBidding
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EndAuction $endAuction): void
    {
        $endAuction->auction->update(['is_active' => false]);
        $endAuction->auction->refresh();
    }
}
