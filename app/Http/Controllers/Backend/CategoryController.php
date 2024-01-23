<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    function index()
    {
        // $data = Category::get();
        $data = Category::get();
        return view('backend.category.index', ['dm' => $data]);
    }
    function add(Request $request)
    {
        if ($request->isMethod("post")) {
            $this->validate($request, [
                "name" => "required",
                "keyword" => "required",
                "image" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
                "desc" => "required",
                "level" => "required|numeric",
            ]);
            //lay gia tri nguoi dung nhap vao cac o
            $cat = new Category();
            $cat->name = $request->name;
            $cat->keyword = $request->keyword;
            $cat->desc = $request->desc;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //move image vao thu muc public
                $img->move('public/file/image/', $nameimage);
                //gan ten hinh vao cot image
                $cat->image = $nameimage;
            }
            $cat->level = $request->level;
            $cat->status = $request->status;
            // print_r ($cate);
            $cat->save();
            Session::flash("note", "Add Success");
            return redirect()->route("be.category");
        } else {
            return view("backend.category.add");
        }
    }
    function update(Request $request, $id)
    {
        $data['load'] = Category::find($id);

        if ($request->isMethod("post")) {
            //cap nhat du lieu
            $this->validate($request, [
                "name" => "required",
                "keyword" => "required",
                "image" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
                "desc" => "required",
                "level" => "required|numeric",
            ]);
            $cate = Category::find($id);
            $cate->name = $request->name;
            $cate->keyword = $request->keyword;
            $cate->desc = $request->desc;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //xoa hinh cu
                @unlink('public/file/image/' . $data["load"]->image);
                //move image vao thu muc public
                $img->move('public/file/image/', $nameimage);
                //gan ten hinh vao cot image
                $cate->image = $nameimage;
            } else {
                $cate->image = $data["load"]->image;
            }
            $cate->level = $request->level;
            $cate->status = $request->status;
            $cate->save();
            Session::flash("note", "Update success!");
            return redirect()->route("be.category");
        } else {
            return view("backend.category.update", $data);
        }
    }
    function del($id)
    {
        Category::destroy($id);
        Session::flash('note', 'Delete successfully! ');
        return redirect()->route('be.category');
    }
}
