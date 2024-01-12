<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavouriteController extends Controller
{

    public function toggleAuctionInFavourite(Request $request)
    {
        $uuid = $request->input('data');
        $user = auth()->user();
        
        if(DB::table('favourites')->where('user_uuid', $user->uuid)->where('auction_uuid', $uuid)->doesntExist()){
            $favourite = Favourite::create([
                'user_uuid' => $user->uuid,
                'auction_uuid' => $uuid,
            ]);
            return response()->json(['message' => "Added To Favourites Successfully", 'data' => $uuid]);
        } else {
            $favourite = Favourite::where('user_uuid', $user->uuid)
                ->where('auction_uuid', $uuid)
                ->first();

            $favourite->delete();

            return response()->json(['message' => "Removed From Favourites Successfully", 'data' => $uuid]);
        }
    }
}
