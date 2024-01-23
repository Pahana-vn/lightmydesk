<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Footbanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FootbannerController extends Controller
{
    function index()
    {
        $data = Footbanner::get();
        return view('backend.footbanner.index', ['foot' => $data]);
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
            $foot1 = new Footbanner();
            $foot1->title = $request->title;
            $foot1->desc = $request->desc;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //move image vao thu muc public
                $img->move('public/file/footbanner/', $nameimage);
                //gan ten hinh vao cot image
                $foot1->image = $nameimage;
            }
            $foot1->status = $request->status;
            $foot1->save();
            Session::flash("note", "Add Success");
            return redirect()->route("be.footbanner");
        } else {
            return view("backend.footbanner.add");
        }
    }

    function update(Request $request, $id)
    {
        $data['load'] = Footbanner::find($id);

        if ($request->isMethod("post")) {
            //cap nhat du lieu
            $this->validate($request, [
                "title" => "required",
                "desc" => "required",
                "image" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            $foot2 = Footbanner::find($id);
            $foot2->title = $request->title;
            $foot2->desc = $request->desc;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //xoa hinh cu
                @unlink('public/file/footbanner/' . $data["load"]->image);
                //move image vao thu muc public
                $img->move('public/file/footbanner/', $nameimage);
                //gan ten hinh vao cot image
                $foot2->image = $nameimage;
            } else {
                $foot2->image = $data["load"]->image;
            }
            $foot2->status = $request->status;
            $foot2->save();
            Session::flash("note", "Update success!");
            return redirect()->route("be.footbanner");
        } else {
            return view("backend.footbanner.update", $data);
        }
    }
    function del($id)
    {
        Footbanner::destroy($id);
        Session::flash('note', 'Delete successfully! ');
        return redirect()->route('be.footbanner');
    }
}
