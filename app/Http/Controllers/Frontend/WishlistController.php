<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Cart;

class WishlistController extends Controller
{
    public function addProductToWishlist(Request $request)
    {
        Cart::instance("wishlist")->add($request->id, $request->name, 1, $request->price)->associate('App\Models\Product');
    }
}
