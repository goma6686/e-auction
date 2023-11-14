<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

use App\Models\Item;
use Illuminate\Http\Request;

class ImageService
{
    public function uploadImage($image, $uuid){
        /*$request->validate([
            'image' => 'image|mimes:jpeg,png,jpg',
        ]);*/
        $item = Item::find($uuid);
        $file = $image;
        $imageName = time() . '_' . $file->getClientOriginalName();
        $item->image = $imageName;
        $image->move(public_path('images'), $imageName);
        $item->save();
    }

    public function destroyImage($uuid){
        $item = Item::find($uuid);
        unlink(public_path('/images/' . $item->image));
        $item->image = null;
        $item->save();

        return redirect()->back();
    }
}