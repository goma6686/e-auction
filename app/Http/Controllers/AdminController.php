<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Auction;
use App\Models\Item;
use App\Models\User;

class AdminController extends Controller
{
    public function index(?string $page = 'auctions')
    {
        switch($page){
            case 'items':
                $data =
                    Item::with(['condition', 'auctions'])
                    ->get();
                break;
            case 'categories':
                $data = Category::all();
                break;
            case 'users':
                $data = User::all();
                break;
            case 'auctions':
                $data = Auction::withCount(['bids', 'items'])
                    ->with(['items', 'category', 'items.condition', 'type', 'user'])
                    ->withMin('items', 'price')
                    ->get();
                break;
        }
        return view('admin.main', compact('data', 'page'));
    }
    
    public function store(Request $request)
    {
        request()->validate([
            'category' => 'required|string',
        ]);
        $category = new Category();
        $category -> category = $request->input('category');

        try {
            $category -> save();
            return back();
        
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return back()->with('error', 'Duplicate entry');
            }else {
                return back()->with('error', 'something went wrong');
            }
        }
    }

    public function activate($uuid){
        User::where('uuid', $uuid)
            ->update(['is_active' => 1]);
        return redirect()->back();
    }

    public function deactivate($uuid){
        User::where('uuid', $uuid)
            ->update(['is_active' => 0]);
        return redirect()->back();
    }

    public function block($uuid){
        Auction::where('uuid', $uuid)
            ->update(['is_blocked' => 1]);
        return redirect()->back();
    }

    public function unblock($uuid){
        Auction::where('uuid', $uuid)
            ->update(['is_blocked' => 0]);
        return redirect()->back();
    }
    

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if($id != 1){
            Auction::where('category_id', $id)->update((['category_id'=>'1']));
            $category->delete();
        }
        return redirect()->back();
    }
}
