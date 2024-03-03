<?php

namespace App\Http\Controllers\users;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_email', Auth::user()->email)->orderByDesc('id')->get();
        return view('users.buyer.pages.dashboard', compact('orders'));

    }

    public function show($id)
    {
        $buyer = Auth::user()->email;
        $order = Order::where('wefarm_tx_ref', $id)->where('customer_email', $buyer)->firstOrFail();

        $orderProductsId = explode("****", $order->order_products_id);

        $orderProductsImg = array();
        $orderProductsName = array();

        // loop through the order_products_id in orders table
        // to get the respective front_view picture in products table
        for ($i = 0; $i < count($orderProductsId); $i++) {
            $orderProductsImg[$i] = Product::with('picture')->where('id', $orderProductsId[$i])->first()->picture->front_view;
            $orderProductsName[$i] = Product::where('id', $orderProductsId[$i])->first()->name;
        }

        return view('users.buyer.pages.showOrder', compact('order', 'orderProductsImg', 'orderProductsName'));
    }

    public function manage()
    {
        $orders = Order::where('customer_email', Auth::user()->email)->orderByDesc('id')->get();
        return view('users.buyer.pages.manageOrder', compact('orders'));
    }
}