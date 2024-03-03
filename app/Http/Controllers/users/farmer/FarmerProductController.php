<?php

namespace App\Http\Controllers\users\farmer;

use App\Models\Picture;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Mail\product\DeleteProduct;
use App\Mail\product\ProductCreate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\EditProductRequest;

class FarmerProductController extends Controller
{
    public function create()
    {
        $categories = Category::all()->sortBy('name');

        return view('users.farmer.pages.addProduct', compact('categories'));
    }

    public function store(AddProductRequest $request)
    {
        $customErrors = array();

        $categories = Category::all();

        $categories_slug = array();
        foreach ($categories as $category) {
            array_push($categories_slug, $category->slug);
        }

        if (!in_array($request->productCategory, $categories_slug)) {
            $customErrors['category'] = "Invalid Product Category";
        }



        $backViewName = null;
        $leftViewName = null;
        $rightViewName = null;


        if ($frontViewFile = $request->File('productFrontView')) {
            $extension = $frontViewFile->getClientOriginalExtension();
            $frontViewName = str_replace(' ', '-', $request->productName) . "-front.$extension";
        }

        if ($request->hasFile('productBackView')) {
            $backViewFile = $request->File('productBackView');
            $extension = $backViewFile->getClientOriginalExtension();
            $backViewName = str_replace(' ', '-', $request->productName) . "-back.$extension";
        }
        if ($request->hasFile('productLeftView')) {
            $leftViewFile = $request->File('productLeftView');
            $extension = $leftViewFile->getClientOriginalExtension();
            $leftViewName = str_replace(' ', '-', $request->productName) . "-left.$extension";
        }
        if ($request->hasFile('productRightView')) {
            $rightViewFile = $request->File('productRightView');
            $extension = $rightViewFile->getClientOriginalExtension();
            $rightViewName = str_replace(' ', '-', $request->productName) . "-right.$extension";
        }

        if ($customErrors) {
            return response()->json([$customErrors]);
        } else {
            // save pictures without watermark to computer
            $frontImg = Image::make($frontViewFile)->resize(300, 250);
            $frontImg->save('pictures/' . $frontViewName);

            if ($request->hasFile('productBackView')) {
                $backImg = Image::make($backViewFile)->resize(300, 250);
                $backImg->save('pictures/' . $backViewName);
            }

            if ($request->hasFile('productLeftView')) {
                $leftImg = Image::make($leftViewFile)->resize(300, 250);
                $leftImg->save('pictures/' . $leftViewName);
            }

            if ($request->hasFile('productRightView')) {
                $rightImg = Image::make($rightViewFile)->resize(300, 250);
                $rightImg->save('pictures/' . $rightViewName);
            }

            Picture::create([
                'front_view' => $frontViewName,
                'back_view' => $backViewName,
                'left_view' => $leftViewName,
                'right_view' => $rightViewName
            ]);

            $pictureId = Picture::where('front_view', $frontViewName)->first()->id;

            $addedBy = Auth::user()->name . " / " . Auth::user()->email;
            $slug = str_replace(' ', '-', $request->productName);
            $productCategoryID = Category::where('slug', $request->productCategory)->firstOrFail()->id;

            $create_product = Product::create([
                'added_by' => $addedBy,
                'role' => Auth::user()->role,
                'name' => ucfirst($request->productName),
                'categoryID' => $productCategoryID,
                'slug' => ucfirst($slug),
                'picture_id' => $pictureId,
                'price' => $request->productPrice,
                'quantity' => $request->productQuantity,
                'measurement' => $request->productMeasurement,
                'description' => ucfirst($request->productDescription),
                'address' => $request->productAddress,
                'city' => ucfirst(strtolower($request->productCity)),
                'state' => ucfirst(strtolower($request->productState)),
                'status' => 'pending'
            ]);

            $create_product->user_name = Auth::user()->name;
            Mail::to(Auth::user()->email)->send(new ProductCreate($create_product));

            return response()->json([
                'productSuccess' => true,
            ]);
        }
    }

    public function manage()
    {
        $addedBy = Auth::user()->name . " / " . Auth::user()->email;
        $allProduct = Product::with('picture')->where('added_by', $addedBy)->orderByDesc('id')->get();
        return view('users.farmer.pages.manageProduct', compact(['allProduct']));
    }

    public function show($id)
    {
        $addedBy = Auth::user()->name . " / " . Auth::user()->email;
        $product = Product::with('picture')->where('slug', $id)->where('added_by', $addedBy)->firstOrFail();

        $productCategory = Category::where('id', $product->categoryID)->firstOrFail()->name;

        return view('users.farmer.pages.showProduct', compact('product', 'productCategory'));
    }

    public function edit($id)
    {
        $categories = Category::all()->sortBy('name');
        $addedBy = Auth::user()->name . " / " . Auth::user()->email;
        $product = Product::where('slug', $id)->where('added_by', $addedBy)->first();

        $prodCatSlug = Category::where('id', $product->categoryID)->firstOrFail()->slug;
        return view('users.farmer.pages.editProduct', compact('product', 'categories', 'prodCatSlug'));
    }

    public function update(EditProductRequest $request, $id)
    {
        $addedBy = Auth::user()->name . " / " . Auth::user()->email;
        $customErrors = array();

        $categories = Category::all();

        $categories_slug = array();
        foreach ($categories as $category) {
            array_push($categories_slug, $category->slug);
        }

        if (!in_array($request->productCategory, $categories_slug)) {
            $customErrors['category'] = "Invalid Product Category";
        }

        // get the product before upload
        $product = Product::with('picture')->where('slug', $id)->where('added_by', $addedBy)->first();

        // get all products to check if the name is different from the previous
        // name and has already been taken
        if ($product->name != ucfirst($request->productName)) {
            $allProducts = Product::where('name', '<>', $product->name)->get();
            foreach ($allProducts as $eachProduct) {
                if ($eachProduct->name === ucfirst($request->productName)) {
                    $customErrors['productName'] = 'The product name has already been taken.';
                    break;
                }
            }
        }

        // validate the pictures
        if ($request->hasFile('productFrontView')) {
            $frontViewFile = $request->File('productFrontView');
            $extension = $frontViewFile->getClientOriginalExtension();
            $frontViewName = str_replace(' ', '-', $request->productName) . "-front.$extension";
        } else {
            $frontViewName = $product->picture->front_view;
        }

        if ($request->hasFile('productBackView')) {
            $backViewFile = $request->File('productBackView');
            $extension = $backViewFile->getClientOriginalExtension();
            $backViewName = str_replace(' ', '-', $request->productName) . "-back.$extension";
        } else {
            $backViewName = $product->picture->back_view;
        }

        if ($request->hasFile('productLeftView')) {
            $leftViewFile = $request->File('productLeftView');
            $extension = $leftViewFile->getClientOriginalExtension();
            $leftViewName = str_replace(' ', '-', $request->productName) . "-left.$extension";
        } else {
            $leftViewName = $product->picture->left_view;
        }

        if ($request->hasFile('productRightView')) {
            $rightViewFile = $request->File('productRightView');
            $extension = $rightViewFile->getClientOriginalExtension();
            $rightViewName = str_replace(' ', '-', $request->productName) . "-right.$extension";
        } else {
            $rightViewName = $product->picture->right_view;
        }

        // check if there is any custom error
        if ($customErrors) {
            return response()->json([$customErrors]);
        } else {
            // check for picture if already exist and delete
            // from the storage. Then save the new pictures
            if ($request->hasFile('productFrontView')) {
                $frontImg = Image::make($frontViewFile)->resize(300, 250);
                unlink(public_path() . '/pictures/' . $product->picture->front_view);
                $frontImg->save('pictures/' . $frontViewName);
            }

            if ($request->hasFile('productBackView')) {
                $backImg = Image::make($backViewFile)->resize(300, 250);
                if ($product->picture->back_view) {
                    unlink(public_path() . '/pictures/' . $product->picture->back_view);
                }
                $backImg->save('pictures/' . $backViewName);
            }

            if ($request->hasFile('productLeftView')) {
                $leftImg = Image::make($leftViewFile)->resize(300, 250);
                if ($product->picture->left_view) {
                    unlink(public_path() . '/pictures/' . $product->picture->left_view);
                }
                $leftImg->save('pictures/' . $leftViewName);
            }

            if ($request->hasFile('productRightView')) {
                $rightImg = Image::make($rightViewFile)->resize(300, 250);
                if ($product->picture->right_view) {
                    unlink(public_path() . '/pictures/' . $product->picture->right_view);
                }
                $rightImg->save('pictures/' . $rightViewName);
            }

            $slug = str_replace(' ', '-', $request->productName);
            $productCategoryID = Category::where('slug', $request->productCategory)->firstOrFail()->id;

            Product::where('slug', $id)->where('added_by', $addedBy)->update([
                'name' => ucfirst($request->productName),
                'categoryID' => $productCategoryID,
                'slug' => ucfirst($slug),
                'price' => $request->productPrice,
                'quantity' => $request->productQuantity,
                'measurement' => $request->productMeasurement,
                'description' => ucfirst($request->productDescription),
                'address' => $request->productAddress,
                'city' => ucfirst(strtolower($request->productCity)),
                'state' => ucfirst(strtolower($request->productState)),
                'status' => 'pending'
            ]);

            $pictureId = Product::where('slug', $slug)->first()->picture_id;

            Picture::where('id', $pictureId)->update([
                'front_view' => $frontViewName,
                'back_view' => $backViewName,
                'left_view' => $leftViewName,
                'right_view' => $rightViewName
            ]);

            $update_product = Product::where('id', $product->id)->firstOrFail();

            $update_product->user_name = Auth::user()->name;
            Mail::to(Auth::user()->email)->send(new ProductCreate($update_product));

            return response()->json([
                'updateSuccess' => true,
            ]);
        }
    }

    public function delete($id)
    {
        $addedBy = Auth::user()->name . " / " . Auth::user()->email;

        $product = Product::where('slug', $id)->where('added_by', $addedBy)->firstOrFail();
        $product->delete();

        $product->user_name = Auth::user()->name;

        Mail::to(Auth::user()->email)->send(new DeleteProduct($product));
        return redirect()->route('users.farmer.products')->with('success', 'Product has been deleted successfully');

    }
}