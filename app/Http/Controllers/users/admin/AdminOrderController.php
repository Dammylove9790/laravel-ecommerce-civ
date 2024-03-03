<?php

namespace App\Http\Controllers\users\admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\order\UpdateOrderStatus;

class AdminOrderController extends Controller
{
    public function wefarmProductOrders()
    {
        $orders = Order::all()->sortByDesc('id');

        $buyerOrders = array();

        foreach ($orders as $order) {
            $orderProductsId = explode("****", $order->order_products_id);
            $orderProductsName = explode("****", $order->order_products);
            $orderProductsQty = explode("****", $order->order_products_quantity);
            $orderProductsPrice = explode("****", $order->order_products_price);

            // loop through the order_products_id in orders table
            // to get the respective admin seller of the product
            for ($i = 0; $i < count($orderProductsId); $i++) {
                $product = Product::where('id', $orderProductsId[$i])->first();

                if ($product && $product->role === "admin") {
                    // once the admin seller is gotten, get the products
                    // ordered by the buyers for all the admmin
                    $buyerOrders[] = array(
                        'name' => $orderProductsName[$i],
                        'quantity' => $orderProductsQty[$i],
                        'slug' => $product->slug,
                        'admin' => $product->added_by,
                        'total_price' => $orderProductsPrice[$i] * $orderProductsQty[$i],
                        'buyer' => $order->customer_email,
                        'date' => $order->created_at,
                        'status' => $order->order_status,
                        'wefarm_tx_ref' => $order->wefarm_tx_ref
                    );
                }
            }
            // return $buyerOrders;
        }
        

        return view('users.admin.pages.orders.wefarmProductOrder', compact('buyerOrders'));

    }

    public function showWefarmProductOrder($id, $slug)
    {
        $order = Order::where('wefarm_tx_ref', $id)->firstOrFail();
        $product = Product::with('picture')->where('slug', $slug)->where('role', 'admin')->firstOrFail();

        $buyerOrder = array();

        $orderProductsId = explode("****", $order->order_products_id);
        $orderProductsName = explode("****", $order->order_products);
        $orderProductsQty = explode("****", $order->order_products_quantity);
        $orderProductsPrice = explode("****", $order->order_products_price);

        // loop through the order_products_id in orders table
        // to get the particular product ordered by the buyer
        for ($i = 0; $i < count($orderProductsId); $i++) {
            if ($product->role === "admin" && $product->id == $orderProductsId[$i]) {
                $buyerOrder = array(
                    'name' => $orderProductsName[$i],
                    'admin' => $product->added_by,
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

        return view('users.admin.pages.orders.showWefarmProductOrder', compact('buyerOrder'));
    }

    public function farmerProductOrders()
    {
        $orders = Order::all()->sortByDesc('id');

        $buyerOrders = array();

        foreach ($orders as $order) {
            $orderProductsId = explode("****", $order->order_products_id);
            $orderProductsName = explode("****", $order->order_products);
            $orderProductsQty = explode("****", $order->order_products_quantity);
            $orderProductsPrice = explode("****", $order->order_products_price);

            // loop through the order_products_id in orders table
            // to get the respective admin seller of the product
            for ($i = 0; $i < count($orderProductsId); $i++) {
                $product = Product::where('id', $orderProductsId[$i])->first();

                if ($product && $product->role === "farmer") {
                    // once the farmer seller is gotten, get the products
                    // ordered by the buyers for all the admmin
                    $buyerOrders[] = array(
                        'name' => $orderProductsName[$i],
                        'quantity' => $orderProductsQty[$i],
                        'slug' => $product->slug,
                        'farmer' => $product->added_by,
                        'total_price' => $orderProductsPrice[$i] * $orderProductsQty[$i],
                        'buyer' => $order->customer_email,
                        'date' => $order->created_at,
                        'status' => $order->order_status,
                        'wefarm_tx_ref' => $order->wefarm_tx_ref
                    );
                }
            }
        }

        return view('users.admin.pages.orders.farmerProductOrder', compact('buyerOrders'));
    }

    public function showFarmerProductOrder($id, $slug)
    {
        $order = Order::where('wefarm_tx_ref', $id)->firstOrFail();
        $product = Product::with('picture')->where('slug', $slug)->where('role', 'farmer')->firstOrFail();

        $buyerOrder = array();

        $orderProductsId = explode("****", $order->order_products_id);
        $orderProductsName = explode("****", $order->order_products);
        $orderProductsQty = explode("****", $order->order_products_quantity);
        $orderProductsPrice = explode("****", $order->order_products_price);

        // loop through the order_products_id in orders table
        // to get the particular product ordered by the buyer
        for ($i = 0; $i < count($orderProductsId); $i++) {
            if ($product->role === "farmer" && $product->id == $orderProductsId[$i]) {
                $buyerOrder = array(
                    'name' => $orderProductsName[$i],
                    'farmer' => $product->added_by,
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

        return view('users.admin.pages.orders.showFarmerProductOrder', compact('buyerOrder'));
    }

    public function wefarmOrder()
    {
        $orders = Order::all()->sortByDesc('id');
        $admins = User::where('role', 'admin')->get();

        $wefarmOrders = array();

        foreach ($orders as $order) {
            foreach ($admins as $admin) {
                if ($order->customer_email === $admin->email) {
                    $wefarmOrders[] = array(
                        'name' => $order->order_products,
                        'admin' => $order->customer_email,
                        'quantity' => $order->order_products_quantity,
                        'total_price' => $order->total_price,
                        'date' => $order->created_at,
                        'status' => $order->order_status,
                        'wefarm_tx_ref' => $order->wefarm_tx_ref
                    );
                }
            }
        }
        return view('users.admin.pages.orders.wefarmOrder', compact('wefarmOrders'));
    }

    public function showWefarmOrder($id)
    {
        $order = Order::where('wefarm_tx_ref', $id)->firstOrFail();

        $orderProductsId = explode("****", $order->order_products_id);

        $orderProductsImg = array();
        $orderProductsName = array();

        // loop through the order_products_id in orders table
        // to get the respective front_view picture in products table
        for ($i = 0; $i < count($orderProductsId); $i++) {
            $orderProductsImg[$i] = Product::with('picture')->where('id', $orderProductsId[$i])->first()->picture->front_view;
            $orderProductsName[$i] = Product::where('id', $orderProductsId[$i])->first()->name;
        }

        return view('users.admin.pages.orders.showWefarmOrder', compact('order', 'orderProductsImg', 'orderProductsName'));
    }


    // all orders
    public function orders()
    {
        $orders = Order::all()->sortByDesc('id');

        return view('users.admin.pages.orders.all_orders', compact('orders'));
    }

    // show order
    public function showOrder($id)
    {
        $order = Order::where('wefarm_tx_ref', $id)->firstOrFail();

        $orderProductsId = explode("****", $order->order_products_id);

        $orderProductsImg = array();
        $orderProductsName = array();

        // loop through the order_products_id in orders table
        // to get the respective front_view picture in products table
        for ($i = 0; $i < count($orderProductsId); $i++) {
            $orderProductsImg[$i] = Product::with('picture')->where('id', $orderProductsId[$i])->first()->picture->front_view;
            $orderProductsName[$i] = Product::where('id', $orderProductsId[$i])->first()->name;
        }

        return view('users.admin.pages.orders.showOrder', compact('order', 'orderProductsImg', 'orderProductsName'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::where('wefarm_tx_ref', $id)->firstOrFail();
        $buyer_name = User::where('email', $order->customer_email)->firstOrFail()->name;

        if ($request->update_order_status == 'processing') {
            $order->update([
                'order_status' => $request->update_order_status
            ]);
            $order->buyer_name = $buyer_name;
            // Mail::to($order->customer_email)->send(new UpdateOrderStatus($order));
            return redirect()->route('users.admin.orders')->with('update_order_status', 'Order is currently being processed');
        } elseif ($request->update_order_status == 'shipped') {
            $order->update([
                'order_status' => $request->update_order_status
            ]);
            $order->buyer_name = $buyer_name;
            //Mail::to($order->customer_email)->send(new UpdateOrderStatus($order));
            return redirect()->route('users.admin.orders')->with('update_order_status', 'Order has been shipped successfully');
        } elseif ($request->update_order_status == 'delivered') {
            $order->update([
                'order_status' => $request->update_order_status
            ]);
            $order->buyer_name = $buyer_name;
           // Mail::to($order->customer_email)->send(new UpdateOrderStatus($order));
            return redirect()->route('users.admin.orders')->with('update_order_status', 'Order has been delivered to the buyer successfully');

        } else {
            return redirect()->route('users.admin.orders')->with('update_order_status', 'Wrong value supplied to update order status');
        }

    }


    public function income()
    {
        $orders = Order::all()->sortByDesc('id');

        $buyerOrders = array();

        foreach ($orders as $order) {
            $orderProductsId = explode("****", $order->order_products_id);
            $orderProductsName = explode("****", $order->order_products);
            $orderProductsQty = explode("****", $order->order_products_quantity);
            $orderProductsPrice = explode("****", $order->order_products_price);


            // loop through the order_products_id in orders table
            // to get the respective admin seller of the product
            for ($i = 0; $i < count($orderProductsId); $i++) {
                $product = Product::where('id', $orderProductsId[$i])->first();

                if ($product && $product->role === "admin") {
                    // once the admin seller is gotten, get the products
                    // ordered by the buyers for all the admmin
                    $buyerOrders[] = array(
                        'name' => $orderProductsName[$i],
                        'quantity' => $orderProductsQty[$i],
                        'slug' => $product->slug,
                        'admin' => $product->added_by,
                        'total_price' => $orderProductsPrice[$i] * 0.9 * $orderProductsQty[$i],
                        'buyer' => $order->customer_email,
                        'date' => $order->created_at,
                        'status' => $order->order_status,
                        'wefarm_tx_ref' => $order->wefarm_tx_ref
                    );
                }
            }
        }

        return view('users.admin.pages.orders.income', compact('buyerOrders'));

    }

    public function charges()
    {
        $orders = Order::all()->sortByDesc('id');

        $charges = array();

        foreach ($orders as $order) {
            $orderProductsId = explode("****", $order->order_products_id);
            $orderProductsName = explode("****", $order->order_products);
            $orderProductsQty = explode("****", $order->order_products_quantity);
            $orderProductsPrice = explode("****", $order->order_products_price);

            // loop through the order_products_id in orders table
            // to get the respective admin seller of the product
            for ($i = 0; $i < count($orderProductsId); $i++) {
                $product = Product::where('id', $orderProductsId[$i])->first();

                if($product){
                    $charges[] = array(
                        'name' => $orderProductsName[$i],
                        'quantity' => $orderProductsQty[$i],
                        'slug' => $product->slug,
                        'total_charges' => $orderProductsPrice[$i] * 0.1 * $orderProductsQty[$i],
                        'date' => $order->created_at,
                        'status' => $order->order_status,
                        'wefarm_tx_ref' => $order->wefarm_tx_ref
                    );
                }
            }
        }

        return view('users.admin.pages.orders.charges', compact('charges'));

    }



}