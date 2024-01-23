<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{
    function index()
    {
        $data = Comment::get();
        return view('backend.comment.index', ['com' => $data]);
    }

    function add(Request $request)
    {
        if ($request->isMethod("post")) {
            $this->validate($request, [
                "desc" => "required",
                "name" => "required",
                "pos" => "required",
                "image" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            //lay gia tri nguoi dung nhap vao cac o
            $cm1 = new Comment();
            $cm1->desc = $request->desc;
            $cm1->name = $request->name;
            $cm1->pos = $request->pos;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //move image vao thu muc public
                $img->move('public/file/comment/', $nameimage);
                //gan ten hinh vao cot image
                $cm1->image = $nameimage;
            }
            $cm1->status = $request->status;
            $cm1->save();
            Session::flash("note", "Add Success");
            return redirect()->route("be.comment");
        } else {
            return view("backend.comment.add");
        }
    }

    function update(Request $request, $id)
    {
        $data['load'] = Comment::find($id);

        if ($request->isMethod("post")) {
            //cap nhat du lieu
            $this->validate($request, [
                "desc" => "required",
                "name" => "required",
                "pos" => "required",
                "image" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            $cm2 = Comment::find($id);
            $cm2->desc = $request->desc;
            $cm2->name = $request->name;
            $cm2->pos = $request->pos;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //xoa hinh cu
                @unlink('public/file/comment/' . $data["load"]->image);
                //move image vao thu muc public
                $img->move('public/file/comment/', $nameimage);
                //gan ten hinh vao cot image
                $cm2->image = $nameimage;
            } else {
                $cm2->image = $data["load"]->image;
            }
            $cm2->status = $request->status;
            $cm2->save();
            Session::flash("note", "Update success!");
            return redirect()->route("be.comment");
        } else {
            return view("backend.comment.update", $data);
        }
    }
    function del($id)
    {
        Comment::destroy($id);
        Session::flash('note', 'Delete successfully! ');
        return redirect()->route('be.comment');
    }
}
