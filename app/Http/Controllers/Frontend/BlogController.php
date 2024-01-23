<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Blogdetail;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    function blog()
    {
        $data['bl'] = Blog::where('status', '1')->paginate(9);
        return view('frontend.pages.blog', $data);
    }
    function blogdetail($name = null, $id = null)
    {
        $data['blog'] = Blog::take(5)->where('id', $id)->where('status', 1)->first();
        $data['bl'] = Blog::where('status', '1')->get();
        $data['category'] = Category::where('status', 1)->get();
        return view('frontend.pages.blogdetail', $data);
    }
}
