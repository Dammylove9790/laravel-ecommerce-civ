<?php

namespace App\Http\Controllers\users\farmer;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FarmerPagesController extends Controller
{
    public function index()
    {
        $user = Auth::user()->name . " / " . Auth::user()->email;
        $products = Product::with('picture')->where('added_by', $user)->orderByDesc('id')->get();


        $orders = Order::all()->sortByDesc('id');
        $seller = Auth::user()->name . " / " . Auth::user()->email;

        $buyerOrders = array();

        foreach ($orders as $order) {
            $orderProductsId = explode("****", $order->order_products_id);
            $orderProductsName = explode("****", $order->order_products);
            $orderProductsQty = explode("****", $order->order_products_quantity);
            $orderProductsPrice = explode("****", $order->order_products_price);


            // loop through the order_products_id in orders table
            // to get the respective seller of the product
            for ($i = 0; $i < count($orderProductsId); $i++) {
                $product = Product::where('id', $orderProductsId[$i])->first();

                if ($product && $product->added_by === $seller) {
                    // once the seller is gotten, get the products
                    // ordered by the buyers for that particular seller
                    $buyerOrders[] = array(
                        'name' => $orderProductsName[$i],
                        'quantity' => $orderProductsQty[$i],
                        'slug' => $product->slug,
                        'total_price' => $orderProductsPrice[$i] * $orderProductsQty[$i],
                        'buyer' => $order->customer_email,
                        'date' => $order->created_at,
                        'status' => $order->order_status,
                        'wefarm_tx_ref' => $order->wefarm_tx_ref
                    );
                }
            }
        }

        return view('users.farmer.pages.dashboard', compact('products', 'buyerOrders'));
    }

    public function buyerOrder()
    {
        $orders = Order::all()->sortByDesc('id');
        $seller = Auth::user()->name . " / " . Auth::user()->email;


        $buyerOrders = array();

        foreach ($orders as $order) {
            $orderProductsId = explode("****", $order->order_products_id);
            $orderProductsName = explode("****", $order->order_products);
            $orderProductsQty = explode("****", $order->order_products_quantity);
            $orderProductsPrice = explode("****", $order->order_products_price);


            // loop through the order_products_id in orders table
            // to get the respective seller of the product
            for ($i = 0; $i < count($orderProductsId); $i++) {
                $product = Product::where('id', $orderProductsId[$i])->first();

                if ($product && $product->added_by === $seller) {
                    // once the seller is gotten, get the products
                    // ordered by the buyers for that particular seller
                    $buyerOrders[] = array(
                        'name' => $orderProductsName[$i],
                        'quantity' => $orderProductsQty[$i],
                        'slug' => $product->slug,
                        'total_price' => $orderProductsPrice[$i] * $orderProductsQty[$i],
                        'buyer' => $order->customer_email,
                        'date' => $order->created_at,
                        'status' => $order->order_status,
                        'wefarm_tx_ref' => $order->wefarm_tx_ref
                    );
                }
            }
        }

        return view('users.farmer.pages.buyerOrder', compact('buyerOrders'));
    }

    public function showBuyerOrder($id, $slug)
    {
        $seller = Auth::user()->name . " / " . Auth::user()->email;

        $order = Order::where('wefarm_tx_ref', $id)->firstOrFail();
        $product = Product::with('picture')->where('slug', $slug)->where('added_by', $seller)->firstOrFail();

        $seller = Auth::user()->name . " / " . Auth::user()->email;

        $buyerOrder = array();

        $orderProductsId = explode("****", $order->order_products_id);
        $orderProductsName = explode("****", $order->order_products);
        $orderProductsQty = explode("****", $order->order_products_quantity);
        $orderProductsPrice = explode("****", $order->order_products_price);


        // loop through the order_products_id in orders table
        // to get the respective seller of the product,
        // and the particular product ordered by the buyer
        for ($i = 0; $i < count($orderProductsId); $i++) {
            if ($product->added_by === $seller && $product->id == $orderProductsId[$i]) {
                $buyerOrder = array(
                    'name' => $orderProductsName[$i],
                    'quantity' => $orderProductsQty[$i],
                    'total_price' => $orderProductsPrice[$i] * $orderProductsQty[$i],
                    'buyer' => $order->customer_email,
                    'date' => $order->created_at,
                    'status' => $order->order_status,
                    'wefarm_tx_ref' => $order->wefarm_tx_ref,
                    'picture' => $product->picture->front_view
                );
            }
        }

        return view('users.farmer.pages.showBuyerOrder', compact('buyerOrder'));
    }

    public function myOrder()
    {
        $orders = Order::where('customer_email', Auth::user()->email)->orderByDesc('id')->get();
        return view('users.farmer.pages.myOrder', compact('orders'));
    }

    public function showMyOrder($id)
    {
        $email = Auth::user()->email;
        $order = Order::where('wefarm_tx_ref', $id)->where('customer_email', $email)->firstOrFail();

        $orderProductsId = explode("****", $order->order_products_id);

        $orderProductsImg = array();
        $orderProductsName = array();

        // loop through the order_products_id in orders table
        // to get the respective front_view picture in products table
        for ($i = 0; $i < count($orderProductsId); $i++) {
            $orderProductsImg[$i] = Product::with('picture')->where('id', $orderProductsId[$i])->first()->picture->front_view;
            $orderProductsName[$i] = Product::where('id', $orderProductsId[$i])->first()->name;
        }

        return view('users.farmer.pages.showMyOrder', compact('order', 'orderProductsImg', 'orderProductsName'));
    }

    public function income()
    {
        $orders = Order::all()->sortByDesc('id');
        $seller = Auth::user()->name . " / " . Auth::user()->email;


        $buyerOrders = array();

        foreach ($orders as $order) {
            $orderProductsId = explode("****", $order->order_products_id);
            $orderProductsName = explode("****", $order->order_products);
            $orderProductsQty = explode("****", $order->order_products_quantity);
            $orderProductsPrice = explode("****", $order->order_products_price);

            // loop through the order_products_id in orders table
            // to get the respective seller of the product
            for ($i = 0; $i < count($orderProductsId); $i++) {
                $product = Product::where('id', $orderProductsId[$i])->first();

                if ($product && $product->added_by === $seller) {
                    // once the seller is gotten, get the products
                    // ordered by the buyers for that particular seller
                    $buyerOrders[] = array(
                        'name' => $orderProductsName[$i],
                        'quantity' => $orderProductsQty[$i],
                        'slug' => $product->slug,
                        'total_price' => $orderProductsPrice[$i] * 0.9 * $orderProductsQty[$i],
                        'buyer' => $order->customer_email,
                        'date' => $order->created_at,
                        'status' => $order->order_status,
                        'wefarm_tx_ref' => $order->wefarm_tx_ref
                    );
                }
            }
        }
        return view('users.farmer.pages.income', compact('buyerOrders'));
    }

}