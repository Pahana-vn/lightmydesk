<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Brandlogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandlogoController extends Controller
{
    function index()
    {
        $data = Brandlogo::get();
        return view('backend.brandlogo.index', ['brnd' => $data]);
    }

    function add(Request $request)
    {
        if ($request->isMethod("post")) {
            $this->validate($request, [
                "image" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            //lay gia tri nguoi dung nhap vao cac o
            $bndl = new Brandlogo();
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //move image vao thu muc public
                $img->move('public/file/brandlogo/', $nameimage);
                //gan ten hinh vao cot image
                $bndl->image = $nameimage;
            }
            $bndl->status = $request->status;
            $bndl->save();
            Session::flash("note", "Add Success");
            return redirect()->route("be.brandlogo");
        } else {
            return view("backend.brandlogo.add");
        }
    }

    function update(Request $request, $id)
    {
        $data['load'] = Brandlogo::find($id);

        if ($request->isMethod("post")) {
            //cap nhat du lieu
            $this->validate($request, [
                "image" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
            ]);
            $blogo = Brandlogo::find($id);
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName();
                //xoa hinh cu
                @unlink('public/file/brandlogo/' . $data["load"]->image);
                //move image vao thu muc public
                $img->move('public/file/brandlogo/', $nameimage);
                //gan ten hinh vao cot image
                $blogo->image = $nameimage;
            } else {
                $blogo->image = $data["load"]->image;
            }
            $blogo->status = $request->status;
            $blogo->save();
            Session::flash("note", "Update success!");
            return redirect()->route("be.brandlogo");
        } else {
            return view("backend.brandlogo.update", $data);
        }
    }
    function del($id)
    {
        Brandlogo::destroy($id);
        Session::flash('note', 'Delete successfully! ');
        return redirect()->route('be.brandlogo');
    }
}
