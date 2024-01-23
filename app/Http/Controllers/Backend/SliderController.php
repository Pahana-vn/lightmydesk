<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
{
    function index()
    {
        $data = Slider::get();
        return view('backend.slider.index', ['sld' => $data]);
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
            $sld = new Slider();
            $sld->title = $request->title;
            $sld->desc = $request->desc;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //move image vao thu muc public
                $img->move('public/file/slider/', $nameimage);
                //gan ten hinh vao cot image
                $sld->image = $nameimage;
            }
            $sld->status = $request->status;
            $sld->save();
            Session::flash("note", "Add Success");
            return redirect()->route("be.slider");
        } else {
            return view("backend.slider.add");
        }
    }

    function update(Request $request, $id)
    {
        $data['load'] = Slider::find($id);

        if ($request->isMethod("post")) {
            //cap nhat du lieu
            $this->validate($request, [
                "title" => "required",
                "desc" => "required",
                "image" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            $sd = Slider::find($id);
            $sd->title = $request->title;
            $sd->desc = $request->desc;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //xoa hinh cu
                @unlink('public/file/slider/' . $data["load"]->image);
                //move image vao thu muc public
                $img->move('public/file/slider/', $nameimage);
                //gan ten hinh vao cot image
                $sd->image = $nameimage;
            } else {
                $sd->image = $data["load"]->image;
            }
            $sd->status = $request->status;
            $sd->save();
            Session::flash("note", "Update success!");
            return redirect()->route("be.slider");
        } else {
            return view("backend.slider.update", $data);
        }
    }
    function del($id)
    {
        Slider::destroy($id);
        Session::flash('note', 'Delete successfully! ');
        return redirect()->route('be.slider');
    }
}
