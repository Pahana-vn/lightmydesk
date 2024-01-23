<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductFeController extends Controller
{
    function index()
    {
        $data['prt'] = Product::where('status', '1')->paginate(9);
        return view('frontend.pages.product', $data);
    }
}
