<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function viewWishlist(){
		return view('frontend.wishlist.view_wishlist');
	}// End Method

    public function GetWishlistProduct(){

		$wishlist = Wishlist::with('product')->where('user_id',Auth::id())->latest()->get();
		return response()->json($wishlist);
	} // end mehtod

    public function removeWishlistProduct($id){

		Wishlist::where('user_id',Auth::id())->where('id',$id)->delete();
		return response()->json(['success' => 'Successfully Product Remove']);
	}
}
