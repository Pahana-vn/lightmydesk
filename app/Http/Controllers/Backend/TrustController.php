<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Trust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TrustController extends Controller
{
    function index()
    {
        $data = Trust::get();
        return view('backend.trust.index', ['trt' => $data]);
    }

    function add(Request $request)
    {
        if ($request->isMethod("post")) {
            $this->validate($request, [
                "title" => "required",
                "desc" => "required",
                "image" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            //lay gia tri nguoi dung nhap vao cac o
            $trt = new Trust();
            $trt->title = $request->title;
            $trt->desc = $request->desc;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //move image vao thu muc public
                $img->move('public/file/trust/', $nameimage);
                //gan ten hinh vao cot image
                $trt->image = $nameimage;
            }
            $trt->status = $request->status;
            $trt->save();
            Session::flash("note", "Add Success");
            return redirect()->route("be.trust");
        } else {
            return view("backend.trust.add");
        }
    }

    function update(Request $request, $id)
    {
        $data['load'] = Trust::find($id);

        if ($request->isMethod("post")) {
            //cap nhat du lieu
            $this->validate($request, [
                "title" => "required",
                "desc" => "required",
                "image" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            $tst = Trust::find($id);
            $tst->title = $request->title;
            $tst->desc = $request->desc;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //xoa hinh cu
                @unlink('public/file/trust/' . $data["load"]->image);
                //move image vao thu muc public
                $img->move('public/file/trust/', $nameimage);
                //gan ten hinh vao cot image
                $tst->image = $nameimage;
            } else {
                $tst->image = $data["load"]->image;
            }
            $tst->status = $request->status;
            $tst->save();
            Session::flash("note", "Update success!");
            return redirect()->route("be.trust");
        } else {
            return view("backend.trust.update", $data);
        }
    }
    function del($id)
    {
        Trust::destroy($id);
        Session::flash('note', 'Delete successfully! ');
        return redirect()->route('be.trust');
    }
}
