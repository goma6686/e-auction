<?php

namespace App\Services;

use App\Models\Item;

class ImageService
{
    public function uploadImage($image, $uuid){
        $item = Item::find($uuid);
        $file = $image;
        $imageName = time() . '_' . $file->getClientOriginalName();
        $item->image = $imageName;
        $image->move(public_path('images/items'), $imageName);
        $item->save();
    }

    public function destroyImage($uuid){
        $item = Item::find($uuid);

        if(file_exists(public_path('images/items' . $item->image)) && $item->image){
            unlink(public_path('images/items' . $item->image));
        }

        $item->image = null;
        $item->save();

        return redirect()->back();
    }
}