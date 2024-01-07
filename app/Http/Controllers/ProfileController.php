<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Conversation;
use App\Events\MessageSent;
use App\Repositories\Interfaces\AuctionRepositoryInterface;
use App\Enums\Duration;
use Illuminate\Http\Request;
use App\Traits\EnumToArray;
class ProfileController extends Controller
{
    use EnumToArray;

    public function sendMessage(Request $request, $auction){

        $message = $request->input('data');

        $conversation = Conversation::create([
            'message' => $message,
            'user' => auth()->user()->username,
        ]);
        //$user = auth()->user();
        
        //broadcast(new MessageSent::broadcast($message))->toOthers();
        MessageSent::broadcast($message, $auction);
        return response()->json(['message' => $message, 'auction' => $auction]);
    }

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

    public function messages($uuid){
        $user = Auth::user();
        return view('profile.chat', compact('user'));
    }

    public function sellAnyway($uuid){
        $auction = Auction::where('uuid', $uuid)->firstOrFail();
        app()->make(AuctionRepositoryInterface::class)->createWinner($auction);
        return redirect()->back();
    }
}
