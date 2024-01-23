<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogBEController extends Controller
{
    function index()
    {
        $data = Blog::get();
        return view('backend.blog.index', ['latestb' => $data]);
    }

    function add(Request $request)
    {
        if ($request->isMethod("post")) {
            $this->validate($request, [
                "title" => "required",
                "name" => "required",
                "info" => "required",
                "avatar" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
                "nameblogger" => "required",
                "descshort" => "required",
                "content" => "required",
                "note" => "required",
                "descproduct" => "required",
                "image" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            //lay gia tri nguoi dung nhap vao cac o
            $latb = new Blog();
            $latb->title = $request->title;
            $latb->name = $request->name;
            $latb->info = $request->info;
            $latb->nameblogger = $request->nameblogger;
            $latb->descshort = $request->descshort;
            $latb->content = $request->content;
            $latb->note = $request->note;
            $latb->descproduct = $request->descproduct;
            if ($request->hasFile("avatar")) {
                $img = $request->file("avatar");
                $nameavatar = time() . "_" . $img->getClientOriginalName();
                //move avatar vao thu muc public
                $img->move('public/file/blog/', $nameavatar);
                //gan ten hinh vao cot avatar
                $latb->avatar = $nameavatar;
            }
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //move image vao thu muc public
                $img->move('public/file/blog/', $nameimage);
                //gan ten hinh vao cot image
                $latb->image = $nameimage;
            }
            $latb->status = $request->status;
            $latb->save();
            Session::flash("note", "Add Success");
            return redirect()->route("be.blog");
        } else {
            return view("backend.blog.add");
        }
    }

    function update(Request $request, $id)
    {
        $data['load'] = Blog::find($id);

        if ($request->isMethod("post")) {
            //cap nhat du lieu
            $this->validate($request, [
                "title" => "required",
                "name" => "required",
                "info" => "required",
                "avatar" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
                "nameblogger" => "required",
                "descshort" => "required",
                "content" => "required",
                "note" => "required",
                "descproduct" => "required",
                "image" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            $ltbg = Blog::find($id);
            $ltbg->title = $request->title;
            $ltbg->name = $request->name;
            $ltbg->info = $request->info;
            $ltbg->nameblogger = $request->nameblogger;
            $ltbg->descshort = $request->descshort;
            $ltbg->content = $request->content;
            $ltbg->note = $request->note;
            $ltbg->descproduct = $request->descproduct;
            if ($request->hasFile("avatar")) {
                $img = $request->file("avatar");
                $nameavatar = time() . "_" . $img->getClientOriginalName();
                //move avatar vao thu muc public
                $img->move('public/file/blog/', $nameavatar);
                //gan ten hinh vao cot avatar
                $ltbg->avatar = $nameavatar;
            }
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //xoa hinh cu
                @unlink('public/file/blog/' . $data["load"]->image);
                //move image vao thu muc public
                $img->move('public/file/blog/', $nameimage);
                //gan ten hinh vao cot image
                $ltbg->image = $nameimage;
            } else {
                $ltbg->image = $data["load"]->image;
            }
            $ltbg->status = $request->status;
            $ltbg->save();
            Session::flash("note", "Update success!");
            return redirect()->route("be.blog");
        } else {
            return view("backend.blog.update", $data);
        }
    }
    function del($id)
    {
        Blog::destroy($id);
        Session::flash('note', 'Delete successfully! ');
        return redirect()->route('be.blog');
    }
}
