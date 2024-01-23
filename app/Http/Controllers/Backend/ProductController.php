<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    function index()
    {
        $data = Product::get();
        return view('backend.product.index', ['prd' => $data]);
    }

    function add(Request $request)
    {
        if ($request->isMethod("post")) {
            $this->validate($request, [
                "name" => "required",
                "keyword" => "required",
                "desc" => "required",
                "discount" => "required",
                "price" => "required|numeric",
                "price_old" => "required|numeric",
                "image" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
                "image_secondary" => "required|mimes:jpeg,png,gif,jpg,ico|max:4096",
                "images.*" => "image|mimes:jpeg,bmp,png,gif,jpg|max:4096",
                "content" => "required",
            ]);
            $Product = new Product();
            $Product->name = $request->name;
            $Product->keyword = $request->keyword;
            $Product->desc = $request->desc;
            $Product->discount = $request->discount;
            $Product->price = $request->price;
            $Product->price_old = $request->price_old;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName(); //435345_hinh.jpg
                //move img vao thu muc public
                $img->move('public/file/image', $nameimage);
                //gan ten hinh vao cot image
                $Product->image = $nameimage;
            }

            if ($request->hasFile("image_secondary")) {
                $img2 = $request->file("image_secondary");
                $nameimage2 = time() . "_" . $img2->getClientOriginalName(); //435345_hinh.jpg
                //move img vao thu muc public
                $img2->move('public/file/image_secondary', $nameimage2);
                //gan ten hinh vao cot image
                $Product->image_secondary = $nameimage2;
            }


            if ($request->hasfile('images')) {
                foreach ($request->file('images') as $file) {
                    $name = time() . '_at_' . $file->getClientOriginalName();
                    $file->move('public/file/product/', $name);
                    $image[] = $name;
                }
                $Product->images = json_encode($image);
            }
            $Product->id_cat = $request->id_cat;
            $Product->content = $request->content;
            $Product->date_create = time();
            $Product->date_edit = time();
            $Product->status = $request->status;
            $Product->save();
            Session::flash('note', 'Add product success !');
            return redirect()->route("be.product");
        } else {
            $data = Category::where("status", 1)->get();
            return view('backend.product.add', ['dm' => $data]);
        }
    }
    function update(Request $request, $id)
    {

        $data['load'] = Product::find($id);

        if ($request->isMethod("post")) {
            $this->validate($request, [
                "name" => "required",
                "keyword" => "required",
                "desc" => "required",
                "discount" => "required",
                "price" => "required|numeric",
                "price_old" => "required|numeric",
                "image" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
                "image_secondary" => "mimes:jpeg,png,gif,jpg,ico|max:4096",
                "content" => "required",
            ]);

            $Product = Product::find($id);
            $Product->name = $request->name;
            $Product->keyword = $request->keyword;
            $Product->desc = $request->desc;
            $Product->discount = $request->discount;
            $Product->price = $request->price;
            $Product->price_old = $request->price_old;
            if ($request->hasFile("image")) {
                $img = $request->file("image");
                $nameimage = time() . "_" . $img->getClientOriginalName(); //435345_hinh.jpg
                //xoa hinh cu
                @unlink('public/file/image/' . $data["load"]->image);
                //move img vao thu muc public
                $img->move('public/file/image/', $nameimage);
                //gan ten hinh vao cot image
                $Product->image = $nameimage;
            }
            if ($request->hasFile("image_secondary")) {
                $img2 = $request->file("image_secondary");
                $nameimage2 = time() . "_" . $img2->getClientOriginalName(); //435345_hinh.jpg
                //xoa hinh cu
                @unlink('public/file/image_secondary/' . $data["load"]->image);
                //move img vao thu muc public
                $img2->move('public/file/image_secondary/', $nameimage2);
                //gan ten hinh vao cot image
                $Product->image_secondary = $nameimage2;
            } else {
                $Product->image = $data["load"]->image;
            }
            if ($request->hasfile('images')) {
                if ($Product->images != "") {
                    foreach (json_decode($Product->images) as $key) {
                        @unlink('public/file/product/' . $key);
                    }
                }
                foreach ($request->file('images') as $file) {
                    $name = time() . '_at_' . $file->getClientOriginalName();
                    $file->move('public/file/product', $name);
                    $image[] = $name;
                }
                $Product->images = json_encode($image);
            }
            // $Product->image = $request->image;
            // $Product->images = $request->images;
            $Product->content = $request->content;
            $Product->id_cat = $request->id_cat;
            $Product->date_create = time();
            $Product->date_edit = time();
            $Product->status = $request->status;
            $Product->save();
            Session::flash('note', 'Update success !');
            return redirect()->route("be.product");
        } else {
            $data['dm'] = Category::where("status", 1)->get();
            return view('backend.product.update', $data);
        }
    }
    function del($id)
    {

        try {
            $load = Product::find($id);
            @unlink('public/file/image/' . $load->image);
            Product::destroy($id);
            Session::flash('note', 'Delete successfully! ');
            return redirect()->route('be.product');
        } catch (\Throwable $th) {
            return redirect()->route("be.product");
        }
    }
}
