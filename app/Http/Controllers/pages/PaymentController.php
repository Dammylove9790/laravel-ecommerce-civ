<?php

namespace App\Http\Controllers\pages;

use Cart;
use App\Models\Size;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Mail\order\NewOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\order\NewOrderNotifySeller;

class PaymentController extends Controller
{
    public function reviewCart()
    {
        $user = Auth::user();
        $cartContent = Cart::session('user')->getContent()->values();
        $cartTotal = Cart::session('user')->getTotal();

        $cartContent->map(function ($item) {
            $sizes = [];
            $colors = [];

            foreach(json_decode($item->attributes->size) as $size) {
                $size = Size::find($size);
                if($size){
                    $sizes[] = $size->name;
                }
            }

            foreach(json_decode($item->attributes->color) as $color) {
                $color = Color::find($color);
                if($color){
                    $colors[] = $color->name;
                }
            }

            $item->color = $colors;
            $item->size = $sizes;

            return $item;
        });

        return view('pages.order.review_order', compact(['user', 'cartContent', 'cartTotal']));
    }

    public function postSingleOrder(Request $request, $id)
    {
        // $user = Auth::user();
        // $product = Product::where('slug', $id)->firstOrFail();
        $quantity = $request->qtyOrdered;
        // dd($request);
        // return $quantity;
        return redirect()->route('order.single.review.get', $id)->with('qty', $quantity);
    }

    public function getSingleOrder($id)
    {
        $user = Auth::user();
        $product = Product::where('slug', $id)->firstOrFail();

        $sizes = [];
        $colors = [];

        foreach(json_decode($product->size) as $size) {
            $size = Size::find($size);
            if($size){
                $sizes[] = $size->name;
            }
        }

        foreach(json_decode($product->color) as $color) {
            $color = Color::find($color);
            if($color){
                $colors[] = $color->name;
            }
        }

        $product->color = $colors;
        $product->size = $sizes;

        return view('pages.order.review_single_order', compact(['user', 'product']));
    }


    public function verify(Request $request)
    {
        $cartContent = Cart::session('user')->getContent();
        $cartTotal = Cart::session('user')->getTotal();

        $order_products = "";
        $order_products_id = "";
        $order_products_quantity = "";
        $order_products_price = "";
        $i = 0;
        foreach ($cartContent as $eachProduct) {
            ++$i;
            // combine the ordered products into one column
            $order_products .= $eachProduct->name;
            $order_products_id .= $eachProduct->id;
            $order_products_quantity .= $eachProduct->quantity;
            $order_products_price .= $eachProduct->price;

            if ($i != count($cartContent)) {
                // separator of the ordered products in a column
                $order_products .= "****";
                $order_products_id .= "****";
                $order_products_quantity .= "****";
                $order_products_price .= "****";
            }
        }

        if ($request->status === "successful" && $request->amount == $cartTotal && $request->currency === "NGN") {
            // add the ordered items in orders table
            $new_order = Order::create([
                'customer_email' => Auth::user()->email,
                'order_products' => $order_products,
                'order_products_id' => $order_products_id,
                'order_products_quantity' => $order_products_quantity,
                'order_products_price' => $order_products_price,
                'total_price' => $request->amount,
                'wefarm_tx_ref' => $request->tx_ref,
                'flw_tx_id' => $request->transaction_id,
                'flw_tx_ref' => $request->flw_ref,
                'order_status' => 'processing'
            ]);
            $new_order['buyer_name'] = Auth::user()->name;
            Mail::to($new_order->customer_email)->send(new NewOrder($new_order));

            // remove the quantity bought from the product table
            foreach ($cartContent as $cart) {
                $product = Product::find($cart->id);
                $product->update([
                    'quantity' => $product->quantity - $cart->quantity
                ]);
                $seller_email = explode("/", $product->added_by);
                $seller_email = trim(end($seller_email));

                $seller_name = explode("/", $product->added_by);
                $seller_name = trim($seller_name[0]);

                $new_order['seller_email'] = $seller_email;
                $new_order['seller_name'] = $seller_name;
                Mail::to($seller_email)->send(new NewOrderNotifySeller($new_order));
            }
            Cart::session('user')->clear();
            return response()->json(['status' => 'successful']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function verifySingleOrder(Request $request, $id)
    {
        $product = Product::where('slug', $id)->firstOrFail();

        if ($request->status === "successful" && $request->amount == ($request->qtyOrdered * $product->price) && $request->currency === "NGN") {
            // add the ordered items in orders table
            $new_order = Order::create([
                'customer_email' => Auth::user()->email,
                'order_products' => $product->name,
                'order_products_id' => $product->id,
                'order_products_quantity' => $request->qtyOrdered,
                'order_products_price' => $product->price,
                'total_price' => $request->amount,
                'wefarm_tx_ref' => $request->tx_ref,
                'flw_tx_id' => $request->transaction_id,
                'flw_tx_ref' => $request->flw_ref,
                'order_status' => 'processing'
            ]);

            $new_order['buyer_name'] = Auth::user()->name;
            Mail::to($new_order->customer_email)->send(new NewOrder($new_order));

            $seller_email = explode("/", $product->added_by);
            $seller_email = trim(end($seller_email));

            $seller_name = explode("/", $product->added_by);
            $seller_name = trim($seller_name[0]);

            $new_order['seller_email'] = $seller_email;
            $new_order['seller_name'] = $seller_name;
            Mail::to($seller_email)->send(new NewOrderNotifySeller($new_order));


            // remove the quantity bought from the product table
            $product->update([
                'quantity' => $product->quantity - $request->qtyOrdered
            ]);
            return response()->json(['status' => 'successful']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }
}