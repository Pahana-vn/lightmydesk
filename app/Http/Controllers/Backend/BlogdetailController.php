<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Blogdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogdetailController extends Controller
{
    function index()
    {
        $data['blogd'] = Blogdetail::get();
        return view('backend.blogdetail.index', $data);
    }

    function add(Request $request)
    {
        if ($request->isMethod("post")) {
            $this->validate($request, [
                "image" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
                "name" => "required",
                "motangan" => "required",
                "content" => "required",
                "note" => "required",
                "motasanpham" => "required",

            ]);
            //lay gia tri nguoi dung nhap vao cac o
            $latb = new Blogdetail();
            $latb->name = $request->name;
            $latb->motangan = $request->motangan;
            $latb->content = $request->content;
            $latb->note = $request->note;
            $latb->motasanpham = $request->motasanpham;
            $latb->id_blog = $request->id_blog;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //move image vao thu muc public
                $img->move('public/file/blogdetail/', $nameimage);
                //gan ten hinh vao cot image
                $latb->image = $nameimage;
            }
            $latb->save();
            Session::flash("note", "Add Success");
            return redirect()->route("be.blogdetail");
        } else {
            $data['bl'] = Blog::where("status", 1)->get();
            return view("backend.blogdetail.add", $data);
        }
    }
    function update(Request $request, $id)
    {
        $data['load'] = Blogdetail::find($id);

        if ($request->isMethod("post")) {
            //cap nhat du lieu
            $this->validate($request, [
                "image" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
                "name" => "required",
                "motangan" => "required",
                "content" => "required",
                "note" => "required",
                "motasanpham" => "required",

            ]);
            $bd2 = Blogdetail::find($id);
            $bd2->name = $request->name;
            $bd2->motangan = $request->motangan;
            $bd2->content = $request->content;
            $bd2->note = $request->note;
            $bd2->motasanpham = $request->motasanpham;
            $bd2->id_blog = $request->id_blog;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //xoa hinh cu
                @unlink('public/file/blogdetail/' . $data["load"]->image);
                //move image vao thu muc public
                $img->move('public/file/blogdetail/', $nameimage);
                //gan ten hinh vao cot image
                $bd2->image = $nameimage;
            } else {
                $bd2->image = $data["load"]->image;
            }
            $bd2->save();
            Session::flash("note", "Update success!");
            return redirect()->route("be.blogdetail");
        } else {
            return view("backend.blogdetail.update", $data);
        }
    }
    function del($id)
    {
        Blogdetail::destroy($id);
        Session::flash('note', 'Delete successfully! ');
        return redirect()->route('be.blogdetail');
    }
}
