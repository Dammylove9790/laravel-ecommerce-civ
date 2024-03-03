<?php

namespace App\Http\Controllers\pages;

use Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

    public function add(Request $request)
    {
        // return $request->session()->flush();
        // return $request->session()->all();
        $product = Product::with('picture')->where('slug', $request->slug)->first();
        // $userID = $request->userId;
        // session(['userID' => $userID]);

        $cartContent = Cart::session('user')->getContent();
        // return Cart::session($userID)->getContent();

        foreach ($cartContent as $eachCartContent) {
            if ($eachCartContent->associatedModel->slug === $request->slug) {
                return response()->json(['productExist' => true]);
            }
        }

        Cart::session('user')->add(
            array(
                // unique row ID
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'attributes' => array(),
                'associatedModel' => $product
            )
        );
        return response()->json(
            [
                'productExist' => false,
                'cartQty' => Cart::session('user')->getContent()->count()
            ]
        );
    }

    public function show()
    {
        $products = Product::all();
        $orders = Order::all();

        $orderWithQuantity = [];

        foreach ($orders as $order) {
            $rowOrderName = explode("****", $order->order_products);
            $rowOrderQuantity = explode("****", $order->order_products_quantity);

            for ($itemOrderName = 0; $itemOrderName < count($rowOrderName); $itemOrderName++) {
                if (array_key_exists($rowOrderName[$itemOrderName], $orderWithQuantity)) {
                    $orderWithQuantity[$rowOrderName[$itemOrderName]] += $rowOrderQuantity[$itemOrderName];
                } else {
                    $orderWithQuantity[$rowOrderName[$itemOrderName]] = $rowOrderQuantity[$itemOrderName];
                }
            }
        }

        $cartContent = Cart::session('user')->getContent();
        $getTotal = Cart::session('user')->getTotal();
        return view('pages.cart.cart', compact(['cartContent', 'getTotal', 'products', 'orderWithQuantity']));
    }

    public function update(Request $request)
    {
        $product = Product::where('slug', $request->slug)->first();
        Cart::session('user')->update(
            $product->id,
            [
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            ]
        );
        return Cart::session('user')->getContent();
    }

    public function delete(Request $request)
    {
        $product = Product::where('slug', $request->slug)->first();
        Cart::session('user')->remove($product->id);
        $getTotal = Cart::session('user')->getTotal();
        return response()->json([
            'total' => $getTotal,
            'cartQty' => Cart::session('user')->getContent()->count()
        ]);
        // return Cart::session('user')->getContent();
    }

    public function clear()
    {
        Cart::session('user')->clear();
    }

}