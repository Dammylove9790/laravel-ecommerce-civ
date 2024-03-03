<?php

namespace App\Http\Controllers\pages;

use Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function index()
    {
        $products = Product::with('picture')->where('status', 'successful')->where('quantity', '>', 0)->inRandomOrder()->paginate(12);
        return view('pages.home', compact('products'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function product()
    {
        $categories = Category::all()->sortBy('name');
        $products = Product::with('picture')->where('status', 'successful')->where('quantity', '>', 0)->inRandomOrder()->paginate(12);
        return view('pages.product', compact('products', 'categories'));
    }

    public function showProduct($id)
    {
        $product = Product::with('picture')->where('slug', $id)->where('status', 'successful')->firstOrFail();
        return view('pages.showProduct', compact('product'));
    }

    public function searchProduct(Request $request)
    {
        $categories = Category::all()->sortBy('name');
        $value = $request->search;

        // $categoryID = "";
        // foreach($categories as $category){
        //     if(strpos(strtolower($category->name), strtolower($value))){

        //     }
        // }
        $products = Product::with('picture')->where('quantity', '>', 0)
            ->where('name', 'like', "%$value%")
            // ->orwhere('category', 'like', "%$value%")
            ->inRandomOrder()->paginate(12)->appends(['value' => $value]);
        return view('pages.searchProduct', compact('products', 'categories'));

    }

    public function searchProductCategory(Request $request)
    {
        $categories = Category::all()->sortBy('name');

        $category = $request->category;
        $productCategoryID = Category::where('name', $category)->firstOrFail()->id;
        $products = Product::with(['picture'])->where('quantity', '>', 0)->where('categoryID', $productCategoryID)
            ->inRandomOrder()->paginate(12)->appends(['category' => $category]);
        return view('pages.searchProduct', compact(['products', 'categories']));

    }

    public function searchProductSort(Request $request)
    {
        $categories = Category::all()->sortBy('name');

        $new = $request->new;
        $decrease = $request->decrease;
        $increase = $request->increase;
        $high = $request->high;
        $low = $request->low;
        if ($new) {
            $products = Product::with('picture')->where('quantity', '>', 0)
                ->Orderby('id', 'DESC')->paginate(12)->appends(['new' => $new]);
            return view('pages.searchProduct', compact('products', 'categories'));
        }
        if ($increase) {
            $products = Product::with('picture')->where('quantity', '>', 0)
                ->Orderby('name', 'ASC')->paginate(12)->appends(['increase' => $increase]);
            return view('pages.searchProduct', compact('products', 'categories'));
        }
        if ($decrease) {
            $products = Product::with('picture')->where('quantity', '>', 0)
                ->Orderby('name', 'DESC')->paginate(12)->appends(['decrease' => $decrease]);
            return view('pages.searchProduct', compact('products', 'categories'));
        }
        if ($high) {
            $products = Product::with('picture')->where('quantity', '>', 0)
                ->Orderby('price', 'DESC')->paginate(12)->appends(['high' => $high]);
            return view('pages.searchProduct', compact('products', 'categories'));
        }
        if ($low) {
            $products = Product::with('picture')->where('quantity', '>', 0)
                ->Orderby('price', 'ASC')->paginate(12)->appends(['low' => $low]);
            return view('pages.searchProduct', compact('products', 'categories'));
        }

    }

    public function searchProductPrice(Request $request)
    {
        $categories = Category::all()->sortBy('name');

        $least = $request->least;
        $second = $request->second;
        $third = $request->third;
        $max = $request->max;
        if ($least) {
            $products = Product::with(['picture'])->where('quantity', '>', 0)
                ->where('price', '<=', 10000)->Orderby('price', 'ASC')->paginate(12)->appends(['least' => $least]);
            return view('pages.searchProduct', compact('products', 'categories'));
        }
        if ($second) {
            $products = Product::with(['picture'])->where('quantity', '>', 0)
                ->where('price', '>=', 10000)->where('price', '<=', 50000)->Orderby('price', 'ASC')->paginate(12)->appends(['second' => $second]);
            return view('pages.searchProduct', compact('products', 'categories'));
        }
        if ($third) {
            $products = Product::with(['picture'])->where('quantity', '>', 0)
                ->where('price', '>=', 50000)->where('price', '<=', 100000)->Orderby('price', 'ASC')->paginate(12)->appends(['third' => $third]);
            return view('pages.searchProduct', compact('products', 'categories'));
        }
        if ($max) {
            $products = Product::with(['picture'])->where('quantity', '>', 0)
                ->where('price', '>=', 100000)->Orderby('price', 'ASC')->paginate(12)->appends(['max' => $max]);
            return view('pages.searchProduct', compact('products', 'categories'));
        }

    }
}