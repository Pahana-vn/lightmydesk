<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VideoControlle extends Controller
{
    function index()
    {
        $data = Video::get();
        return view('backend.vid.index', ['vide' => $data]);
    }

    function add(Request $request)
    {
        if ($request->isMethod("post")) {
            $this->validate($request, [
                "linkyt" => "required",
                "image" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            //lay gia tri nguoi dung nhap vao cac o
            $v1 = new Video();
            $v1->linkyt = $request->linkyt;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //move image vao thu muc public
                $img->move('public/file/linkyt/', $nameimage);
                //gan ten hinh vao cot image
                $v1->image = $nameimage;
            }
            $v1->status = $request->status;
            $v1->save();
            Session::flash("note", "Add Success");
            return redirect()->route("be.video");
        } else {
            return view("backend.vid.add");
        }
    }

    function update(Request $request, $id)
    {
        $data['load'] = Video::find($id);

        if ($request->isMethod("post")) {
            //cap nhat du lieu
            $this->validate($request, [
                "image" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
                "linkyt" => "required",
            ]);
            $v2 = Video::find($id);
            $v2->linkyt = $request->linkyt;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //xoa hinh cu
                @unlink('public/file/linkyt/' . $data["load"]->image);
                //move image vao thu muc public
                $img->move('public/file/linkyt/', $nameimage);
                //gan ten hinh vao cot image
                $v2->image = $nameimage;
            } else {
                $v2->image = $data["load"]->image;
            }
            $v2->status = $request->status;
            $v2->save();
            Session::flash("note", "Update success!");
            return redirect()->route("be.video");
        } else {
            return view("backend.vid.update", $data);
        }
    }
    function del($id)
    {
        Video::destroy($id);
        Session::flash('note', 'Delete successfully! ');
        return redirect()->route('be.video');
    }
}
