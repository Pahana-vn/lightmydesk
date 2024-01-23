<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdsController extends Controller
{
    function index()
    {
        $data = Ads::get();
        return view('backend.ads.index', ['avs' => $data]);
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
            $avs = new Ads();
            $avs->title = $request->title;
            $avs->desc = $request->desc;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //move image vao thu muc public
                $img->move('public/file/ads/', $nameimage);
                //gan ten hinh vao cot image
                $avs->image = $nameimage;
            }
            $avs->status = $request->status;
            $avs->save();
            Session::flash("note", "Add Success");
            return redirect()->route("be.ads");
        } else {
            return view("backend.ads.add");
        }
    }

    function update(Request $request, $id)
    {
        $data['load'] = Ads::find($id);

        if ($request->isMethod("post")) {
            //cap nhat du lieu
            $this->validate($request, [
                "title" => "required",
                "desc" => "required",
                "image" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            $adver = Ads::find($id);
            $adver->title = $request->title;
            $adver->desc = $request->desc;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //xoa hinh cu
                @unlink('public/file/ads/' . $data["load"]->image);
                //move image vao thu muc public
                $img->move('public/file/ads/', $nameimage);
                //gan ten hinh vao cot image
                $adver->image = $nameimage;
            } else {
                $adver->image = $data["load"]->image;
            }
            $adver->status = $request->status;
            $adver->save();
            Session::flash("note", "Update success!");
            return redirect()->route("be.ads");
        } else {
            return view("backend.ads.update", $data);
        }
    }
    function del($id)
    {
        Ads::destroy($id);
        Session::flash('note', 'Delete successfully! ');
        return redirect()->route('be.ads');
    }
}
