<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Blog;
use App\Models\Brandlogo;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Footbanner;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Trust;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index()
    {
        // $data['featuredtproducts'] = Product::take(8)->orderby("id", "desc")->get();
        $featuredtproducts = Product::take(8)->orderby("id", "desc")->get();

        foreach ($featuredtproducts as $product) {
            if ($product->images) {
                $product->hinhkemtheo = json_decode($product->images, true);
            } else {
                $product->hinhkemtheo = [];
            }
        }
        $data['featuredtproducts'] = $featuredtproducts;
        $data['ngaunhien'] = Product::inRandomOrder()->limit(8)->get();
        $data['danhmuc'] = Category::take(6)->get();
        $data['sder'] = Slider::where('status', '1')->get();
        $data['trust'] = Trust::where('status', '1')->get();
        $data['ads'] = Ads::where('status', '1')->get();
        $data['ftb'] = Footbanner::where('status', '1')->get();
        $data['ltb'] = Blog::where('status', '1')->get();
        $data['blg'] = Brandlogo::where('status', '1')->get();
        $data['cmt'] = Comment::where('status', '1')->get();
        $data['video'] = Comment::where('status', '1')->get();
        // if ($data['detail'] && !empty($data['detail']->images)) {
        //     $data['hinhkemtheo'] = json_decode($data['detail']->images, true); // Đảm bảo thực hiện json_decode với tham số thứ 2 là true
        // } else {
        //     $data['hinhkemtheo'] = NULL;
        // }
        return view('frontend.pages.home', $data);
    }
    function category($id = null)
    {
        try {
            $data['loadsp'] = Product::where('id_cat', $id)->paginate(6);
            return view('frontend.pages.category', $data);
        } catch (\Throwable $th) {
            return redirect()->route('fe.home');
        }
    }

    function wishlist()
    {
        return view('frontend.pages.wishlist');
    }


    function detail($name = null, $id = null)
    {
        $data['detail'] = Product::where('id', $id)->where('status', 1)->first();

        if ($data['detail']) {
            $data['ngaunhien'] = Product::where("id_cat", $data['detail']->id_cat)->inRandomOrder()->limit(8)->get();
            $data['hinhkemtheo'] = json_decode($data['detail']->images); // Lấy các hình ảnh kèm theo sản phẩm
            $data['images'] = json_decode($data['detail']->images); // Lấy đường dẫn ảnh từ cơ sở dữ liệu và chuyển thành mảng
            return view('frontend.pages.detail', $data);
        } else {
            return redirect()->route('fe.home');
        }
    }


    function search(Request $request)
    {
        //c1: php thuan:  $_GET['keyword'];
        //c2:
        $search = $request->input('keyword');
        // $timkiem = trim(htmlspecialchars($search, ENT_QUOTES, "UTF-8"));
        $data['search'] = Product::where('status', 1)
            ->where('name', "LIKE", "%{$search}%")
            ->orwhere('price', "LIKE", "%{$search}%")
            ->orwhere('desc', "LIKE", "%{$search}%")->paginate(6);
        if ($data['search']) {
            return view('frontend.pages.search', $data);
        } else {
            return redirect()->route('be.home');
        }
    }
}
