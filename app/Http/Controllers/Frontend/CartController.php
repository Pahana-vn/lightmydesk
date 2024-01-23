<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\orderdetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    function cart()
    {
        // $cart =   Session::get("cart");

        return view('frontend.pages.cart');
    }

    public function addcart(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $id = $request->id;
            $sp = Product::find((int)$request->id);

            if ($sp) {
                if ($request->soluong) {
                    $soluong = $request->soluong;
                } else {
                    $soluong = 1;
                }
                $item = array(
                    'id' => $sp->id,
                    'name' => $sp->name,
                    'image' => $sp->image,
                    'discount' => $sp->discount,
                    'price' => $sp->price,
                    'soluong' => $soluong
                );
                $cart = Session::put('cart.' . $sp->id, $item);
                return response()->json('cart-success');
            }
        }
    }
    function delcart($id = null)
    {
        if (Session::exists('cart.' . (int)$id)) {
            Session::forget('cart.' . (int)$id);
            return redirect()->route('fe.cart');
        } else {
            return redirect()->route('fe.home');
        }
    }
    public function checkout(Request $request)
    {
        if ($request->isMethod('post')) {
            // Tính toán tổng tiền từ giỏ hàng
            $Subtotal = 0;
            $total = 0;
            $originalPrice = 0;
            $discount = 0;
            $finalPrice = 0;
            foreach (Session::get('cart') as $key => $item) {
                $originalPrice = $originalPrice + $item['price'] * $item['soluong']; // Tính giá gốc
                $discount = $originalPrice * ($item['discount'] / 100); // Tính số tiền được giảm giá
                $finalPrice = $originalPrice - $discount; // Tính giá sau khi giảm giá
            }

            // Tạo mới đơn đặt hàng và gán tổng tiền
            $order = new Order();
            $order->id_account = Auth::user()->id;
            $order->ship = 10;
            $order->total = $finalPrice + 10; // Tổng tiền
            $order->shiptime = 3;
            $order->note = "";
            $order->date_order = date('d/m/Y', strtotime(date('Y-m-d H:i:s')));
            $order->status = 1;
            $order->save();

            // Lưu thông tin chi tiết đơn hàng
            foreach (Session::get('cart') as $key => $value) {
                $orderDetail = new orderdetail();
                $orderDetail->quantity = (int)$value['soluong'];
                $orderDetail->id_order = $order->id;
                $orderDetail->id_product = (int)$value['id'];
                $orderDetail->status = 1;
                $orderDetail->save();
            }

            // Xóa giỏ hàng sau khi đã đặt hàng thành công
            Session::forget('cart');

            return redirect()->route('fe.home');
        }

        return view("frontend.pages.checkout");
    }
}
