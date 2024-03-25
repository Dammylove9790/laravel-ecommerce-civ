<?php

namespace App\Http\Controllers\users\admin;

use App\Mail\product\DeleteProduct;
use App\Models\Picture;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Mail\product\ProductLive;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Models\Color;
use App\Models\Size;

class AdminProductController extends Controller
{
    public function create()
    {
        $categories = Category::all()->sortBy('name');
        $colors = Color::all()->sortBy('name');
        $sizes = Size::all()->sortBy('name');

        return view('users.admin.pages.product.addProduct', compact('categories', 'sizes', 'colors'));
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

        $colors = Color::pluck('id')->toArray();
        $sizes = Size::pluck('id')->toArray();

        $productColor = [];
        $productSize = [];

        if(isset($request->productColor) && count($request->productColor) > 0){
            $productColor = $request->productColor;
        }

        if(isset($request->productSize) && count($request->productSize) > 0){
            $productSize = $request->productSize;
        }

        foreach($productColor as $prodCol) {
            if(!in_array($prodCol, $colors)) {
                $customErrors['color'] = "One or more of the Product Color is invalid.";
            }
        }
        
        foreach($productSize as $prodSize) {
            if(!in_array($prodSize, $sizes)) {
                $customErrors['size'] = "One or more of the Product Size is invalid.";
            }
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
            // save pictures with watermark to computer if admin
            $frontImg = Image::make($frontViewFile)->resize(300, 250);//->insert('img/Wefarm.png');
            $frontImg->save('pictures/' . $frontViewName);

            if ($request->hasFile('productBackView')) {
                $backImg = Image::make($backViewFile)->resize(300, 250);//->insert('img/Wefarm.png');
                $backImg->save('pictures/' . $backViewName);
            }

            if ($request->hasFile('productLeftView')) {
                $leftImg = Image::make($leftViewFile)->resize(300, 250);//->insert('img/Wefarm.png');
                $leftImg->save('pictures/' . $leftViewName);
            }

            if ($request->hasFile('productRightView')) {
                $rightImg = Image::make($rightViewFile)->resize(300, 250);//->insert('img/Wefarm.png');
                $rightImg->save('pictures/' . $rightViewName);
            }

            Picture::create([
                'front_view' => $frontViewName,
                'back_view' => $backViewName,
                'left_view' => $leftViewName,
                'right_view' => $rightViewName
            ]);

            $pictureId = Picture::where('front_view', $frontViewName)->firstOrFail()->id;

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
                'color' => json_encode($productColor),
                'size' => json_encode($productSize),
                // 'address' => $request->productAddress,
                // 'city' => ucfirst(strtolower($request->productCity)),
                // 'state' => ucfirst(strtolower($request->productState)),
                'status' => 'successful',
            ]);

            $create_product->user_name = Auth::user()->name;
           // Mail::to(Auth::user()->email)->send(new ProductLive($create_product));

            return response()->json([
                'productSuccess' => true,
            ]);
        }
    }

    public function manage()
    {
        $allProduct = Product::with('picture')->orderByDesc('id')->get();

        $allProduct->map(function ($item) {
            $sizes = [];
            $colors = [];

            foreach(json_decode($item->size) as $size) {
                $size = Size::find($size);
                if($size){
                    $sizes[] = $size->name;
                }
            }

            foreach(json_decode($item->color) as $color) {
                $color = Color::find($color);
                if($color){
                    $colors[] = $color->name;
                }
            }

            $item->color = $colors;
            $item->size = $sizes;

            return $item;
        });
        return view('users.admin.pages.product.manageProduct', compact(['allProduct']));
    }

    public function show($id)
    {
        $product = Product::with('picture')->where('slug', $id)->firstOrFail();
        $productCategory = Category::where('id', $product->categoryID)->firstOrFail()->name;

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

        return view('users.admin.pages.product.showProduct', compact('product', 'productCategory'));
    }

    public function accept($id)
    {
        $accept_product = Product::where('slug', $id)->firstOrFail();
        $accept_product->update([
            'status' => 'successful'
        ]);

        $extract = explode("/", $accept_product->added_by);
        $accept_product->user_name = trim($extract[0]);
        //Mail::to(trim(end($extract)))->send(new ProductLive($accept_product));

        return redirect()->route('users.admin.products')->with('success', 'Product has been accepted successfully');
    }

    public function edit($id)
    {
        $categories = Category::all()->sortBy('name');
        $product = Product::where('slug', $id)->where('role', 'admin')->firstOrFail();
        $colors = Color::all()->sortBy('name');
        $sizes = Size::all()->sortBy('name');

        $psizes = [];
        $pcolors = [];
        foreach(json_decode($product->size) as $size) {
            $size = Size::find($size);
            if($size){
                $psizes[] = $size->id;
            }
        }

        foreach(json_decode($product->color) as $color) {
            $color = Color::find($color);
            if($color){
                $pcolors[] = $color->id;
            }
        }

        $product->color = $pcolors;
        $product->size = $psizes;

        $prodCatSlug = Category::where('id', $product->categoryID)->firstOrFail()->slug;
        return view('users.admin.pages.product.editProduct', compact('product', 'categories', 'prodCatSlug', 'sizes', 'colors'));
    }

    public function update(EditProductRequest $request, $id)
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

        $colors = Color::pluck('id')->toArray();
        $sizes = Size::pluck('id')->toArray();

        $productColor = [];
        $productSize = [];

        if(isset($request->productColor) && count($request->productColor) > 0){
            $productColor = $request->productColor;
        }

        if(isset($request->productSize) && count($request->productSize) > 0){
            $productSize = $request->productSize;
        }

        foreach($productColor as $prodCol) {
            if(!in_array($prodCol, $colors)) {
                $customErrors['color'] = "One or more of the Product Color is invalid.";
            }
        }

        foreach($productSize as $prodSize) {
            if(!in_array($prodSize, $sizes)) {
                $customErrors['size'] = "One or more of the Product Size is invalid.";
            }
        }

        // get the product before upload
        $product = Product::with('picture')->where('slug', $id)->where('role', 'admin')->firstOrFail();

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
            // from the storage. Then save the new pictures with 
            // watermark to computer if admin
            if ($request->hasFile('productFrontView')) {
                $frontImg = Image::make($frontViewFile)->resize(300, 250);//->insert('img/Wefarm.png');
                unlink(public_path() . '/pictures/' . $product->picture->front_view);
                $frontImg->save('pictures/' . $frontViewName);
            }

            if ($request->hasFile('productBackView')) {
                $backImg = Image::make($backViewFile)->resize(300, 250);//->insert('img/Wefarm.png');
                if ($product->picture->back_view) {
                    unlink(public_path() . '/pictures/' . $product->picture->back_view);
                }
                $backImg->save('pictures/' . $backViewName);
            }

            if ($request->hasFile('productLeftView')) {
                $leftImg = Image::make($leftViewFile)->resize(300, 250);//->insert('img/Wefarm.png');
                if ($product->picture->left_view) {
                    unlink(public_path() . '/pictures/' . $product->picture->left_view);
                }
                $leftImg->save('pictures/' . $leftViewName);
            }

            if ($request->hasFile('productRightView')) {
                $rightImg = Image::make($rightViewFile)->resize(300, 250);//->insert('img/Wefarm.png');
                if ($product->picture->right_view) {
                    unlink(public_path() . '/pictures/' . $product->picture->right_view);
                }
                $rightImg->save('pictures/' . $rightViewName);
            }

            $slug = str_replace(' ', '-', $request->productName);
            $updated_by = Auth::user()->name . " / " . Auth::user()->email;
            $productCategoryID = Category::where('slug', $request->productCategory)->firstOrFail()->id;

            Product::where('slug', $id)->where('role', 'admin')->update([
                'name' => ucfirst($request->productName),
                'categoryID' => $productCategoryID,
                'slug' => ucfirst($slug),
                'price' => $request->productPrice,
                'quantity' => $request->productQuantity,
                'measurement' => $request->productMeasurement,
                'description' => ucfirst($request->productDescription),
                'color' => json_encode($productColor),
                'size' => json_encode($productSize),
                // 'address' => $request->productAddress,
                // 'city' => ucfirst(strtolower($request->productCity)),
                // 'state' => ucfirst(strtolower($request->productState)),
                'updated_by' => $updated_by
            ]);

            $pictureId = Product::where('slug', $slug)->firstOrFail()->picture_id;

            Picture::where('id', $pictureId)->update([
                'front_view' => $frontViewName,
                'back_view' => $backViewName,
                'left_view' => $leftViewName,
                'right_view' => $rightViewName
            ]);

            $update_product = Product::where('id', $product->id)->firstOrFail();

            $update_product->user_name = Auth::user()->name;
           // Mail::to(Auth::user()->email)->send(new ProductLive($update_product));

            return response()->json([
                'updateSuccess' => true,
            ]);
        }
    }

    public function delete($id)
    {
        $product = Product::where('slug', $id)->firstOrFail();
        $product->delete();

        $extract = explode("/", $product->added_by);
        $product->user_name = trim($extract[0]);

       // Mail::to(end($extract))->send(new DeleteProduct($product));
        return redirect()->route('users.admin.products')->with('success', 'Product has been deleted successfully');
    }

    public function category()
    {
        $categories = Category::all()->sortBy('name');
        return view('users.admin.pages.product.category', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:25|unique:categories,name'
        ]);

        $categoryName = ucwords(strtolower(trim($request->category)));
        $categorySlug = strtolower(str_replace(" ", "-", $categoryName));

        Category::create([
            'name' => $categoryName,
            'slug' => $categorySlug
        ]);

        return response()->json([
            'success' => true,
        ]);

    }

    public function updateCategory(Request $request, $id){
        $request->validate([
            'new_name' => [
                'required', 'string', function($attribute, $value, $fail) use ($id){
                    $exist = Category::where('id', '!=', $id)->where('name', $value)->exists();
                    if($exist){
                        $fail("The specified category name is already taken");
                    }
                }
            ],
        ]);

        $categoryName = ucwords(strtolower(trim($request->new_name)));
        $categorySlug = strtolower(str_replace(" ", "-", $categoryName));

        Category::where('id', $id)->update([
            'name' => $categoryName,
            'slug' => $categorySlug
        ]);

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function deleteCategory($id){
        Category::where('id', $id)->delete();
        
        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    public function size()
    {
        $sizes = Size::all()->sortBy('name');
        return view('users.admin.pages.product.size', compact('sizes'));
    }

    public function storeSize(Request $request)
    {
        $request->validate([
            'size' => 'required|string|max:25|unique:sizes,name'
        ]);

        $sizeName = ucwords(strtolower(trim($request->size)));

        Size::create([
            'name' => $sizeName,
        ]);

        return response()->json([
            'success' => true,
        ]);

    }

    public function updateSize(Request $request, $id){
        $request->validate([
            'new_name' => [
                'required', 'string', function($attribute, $value, $fail) use ($id){
                    $exist = Size::where('id', '!=', $id)->where('name', $value)->exists();
                    if($exist){
                        $fail("The specified size is already taken");
                    }
                }
            ],
        ]);

        $sizeName = ucwords(strtolower(trim($request->new_name)));

        Size::where('id', $id)->update([
            'name' => $sizeName,
        ]);

        return redirect()->back()->with('success', 'Size updated successfully');
    }

    public function deleteSize($id){
        Size::where('id', $id)->delete();
        
        return redirect()->back()->with('success', 'Size deleted successfully');
    }

    public function color()
    {
        $colors = Color::all()->sortBy('name');
        return view('users.admin.pages.product.color', compact('colors'));
    }

    public function storeColor(Request $request)
    {
        $request->validate([
            'color' => 'required|string|max:25|unique:colors,name'
        ]);

        $colorName = ucwords(strtolower(trim($request->color)));

        Color::create([
            'name' => $colorName,
        ]);

        return response()->json([
            'success' => true,
        ]);

    }

    public function updateColor(Request $request, $id){
        $request->validate([
            'new_name' => [
                'required', 'string', function($attribute, $value, $fail) use ($id){
                    $exist = Color::where('id', '!=', $id)->where('name', $value)->exists();
                    if($exist){
                        $fail("The specified color is already taken");
                    }
                }
            ],
        ]);

        $colorName = ucwords(strtolower(trim($request->new_name)));

        Color::where('id', $id)->update([
            'name' => $colorName,
        ]);

        return redirect()->back()->with('success', 'Color updated successfully');
    }

    public function deleteColor($id){
        Color::where('id', $id)->delete();
        
        return redirect()->back()->with('success', 'Color deleted successfully');
    }


}