<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\EndAuction;

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
