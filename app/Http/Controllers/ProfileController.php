<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Repositories\Interfaces\AuctionRepositoryInterface;
use App\Enums\Duration;
use App\Traits\EnumToArray;
class ProfileController extends Controller
{
    use EnumToArray;

    public function getAuctionsEndedWithNoBids(): array {
        $auction_repository = app()->make(AuctionRepositoryInterface::class);
        return $auction_repository->getAuctionsEndedWithNoBids();
    }

    public function getSecondChanceAuctions(): array {
        $auction_repository = app()->make(AuctionRepositoryInterface::class);
        return $auction_repository->getSecondChanceAuctions();
    }

    public function profile($uuid) {
        $user = User::find($uuid);
        $durations = Duration::values();
        return view('profile.profile', compact('user', 'durations'));
    }

    public function dashboard($uuid){
        $durations = Duration::values();
        $user = Auth::user();
        return view('profile.dashboard', compact('durations', 'user'));
    }

    public function sellAnyway($uuid){
        $auction = Auction::where('uuid', $uuid)->firstOrFail();
        app()->make(AuctionRepositoryInterface::class)->createWinner($auction);
        return redirect()->back();
    }
}
