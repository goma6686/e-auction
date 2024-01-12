<?php

namespace App\Console\Commands;

use App\Events\EndAuction;
use App\Models\Auction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AuctionDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'app:auction-deadline';
    protected $signature = 'watch:auction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Auction status when time expires';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Auction::query()
            ->get()
            ->each(function ($auction){
                $auction->when(
                    Carbon::now()->greaterThanOrEqualTo($auction->end_time),
                    function () use ($auction) {
                        $auction->update([
                            'is_active' => false
                        ]);
                        broadcast(new EndAuction($auction))->toOthers();
                    }
                );
            });
    }
}
