<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pages\CartController;
use App\Http\Controllers\pages\PagesController;
use App\Http\Controllers\users\BuyerController;
use App\Http\Controllers\pages\PaymentController;
use App\Http\Controllers\users\LogisticsController;
use App\Http\Controllers\users\admin\AdminRecycleBin;
use App\Http\Controllers\users\admin\AdminOrderController;
use App\Http\Controllers\users\admin\AdminPagesController;
use App\Http\Controllers\users\admin\AdminProductController;
use App\Http\Controllers\users\farmer\FarmerPagesController;
use App\Http\Controllers\users\farmer\FarmerProductController;
use Illuminate\Support\Facades\Artisan;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */


Route::get('/clear-cache', function(){
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('config:cache');
    return 'done';
});


Auth::routes();
Auth::Routes(['verify' => true]);


// define the route for pages
Route::get('/', [PagesController::class, 'index'])->name('pages.index');
Route::get('/about', [PagesController::class, 'about'])->name('pages.about');
Route::get('/contact', [PagesController::class, 'contact'])->name('pages.contact');
Route::get('/products', [PagesController::class, 'product'])->name('pages.products');
Route::get('/products/{id}', [PagesController::class, 'showProduct'])->name('pages.products.show');
Route::get('/search-product', [PagesController::class, 'searchProduct'])->name('pages.searchProduct');
Route::get('/search-product-category', [PagesController::class, 'searchProductCategory'])->name('pages.searchProductCategory');
Route::get('/search-product-sort', [PagesController::class, 'searchProductSort'])->name('pages.searchProductSort');
Route::get('/search-product-sort-price', [PagesController::class, 'searchProductPrice'])->name('pages.searchProductSortPrice');



Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('users')->group(function () {
        //define the route for admin
        Route::prefix('admin')->middleware('admin')->group(function () {
            // pages
            Route::get('/dashboard', [AdminPagesController::class, 'index'])->name('users.admin.dashboard');
            Route::get('/show_user/{id}', [AdminPagesController::class, 'showUser'])->name('users.admin.showUser');
            Route::put('/pending_users/accept/{id}', [AdminPagesController::class, 'acceptUser'])->name('users.admin.pendinguser.accept');
            Route::delete('/delete_user/{id}', [AdminPagesController::class, 'deleteUser'])->name('users.admin.deleteUser');
            // Route::get('/register_user', [AdminPagesController::class, 'registerUser'])->name('users.admin.registerUser');
            // Route::post('/register_user', [AdminPagesController::class, 'storeUser'])->name('users.admin.registerUser.store');
            // Route::get('/manage_admin', [AdminPagesController::class, 'manageAdmin'])->name('users.admin.manageAdmin');
            // Route::get('/manage_farmer', [AdminPagesController::class, 'manageFarmer'])->name('users.admin.manageFarmer');
            Route::get('/manage_buyer', [AdminPagesController::class, 'manageBuyer'])->name('users.admin.manageBuyer');
            // Route::get('/manage_logistics', [AdminPagesController::class, 'manageLogistics'])->name('users.admin.manageLogistics');

            // product
            Route::get('/add_product', [AdminProductController::class, 'create'])->name('users.admin.products.create');
            Route::post('/add_product', [AdminProductController::class, 'store'])->name('users.admin.products.store');
            Route::get('/products', [AdminProductController::class, 'manage'])->name('users.admin.products');
            Route::get('/products/{id}', [AdminProductController::class, 'show'])->name('users.admin.products.show');
            Route::put('/pending_products/accept/{id}', [AdminProductController::class, 'accept'])->name('users.admin.products.accept');
            Route::get('/edit_product/{id}', [AdminProductController::class, 'edit'])->name('users.admin.products.edit');
            Route::put('/edit_product/{id}', [AdminProductController::class, 'update'])->name('users.admin.products.update');
            Route::delete('/products/delete/{id}', [AdminProductController::class, 'delete'])->name('users.admin.products.delete');

            // category
            Route::get('/product_category', [AdminProductController::class, 'category'])->name('users.admin.products.category');
            Route::post('/product_category', [AdminProductController::class, 'storeCategory'])->name('users.admin.products.category.store');

            // order
            // Route::get('/wefarm_product_orders/', [AdminOrderController::class, 'wefarmProductOrders'])->name('users.admin.orders.wefarm_product');
            // Route::get('/wefarm_product_orders/{id}/{slug}', [AdminOrderController::class, 'showWefarmProductOrder'])->name('users.admin.orders.wefarm_product.show');
            // Route::get('/farmer_product_orders/', [AdminOrderController::class, 'farmerProductOrders'])->name('users.admin.orders.farmer_product');
            // Route::get('/farmer_product_orders/{id}/{slug}', [AdminOrderController::class, 'showFarmerProductOrder'])->name('users.admin.orders.farmer_product.show');
            // Route::get('/wefarm_orders/', [AdminOrderController::class, 'wefarmOrder'])->name('users.admin.orders.self');
            // Route::get('/wefarm_orders/{id}', [AdminOrderController::class, 'showWefarmOrder'])->name('users.admin.orders.self.show');
            // all orders
            // Route::get('/orders', [AdminOrderController::class, 'orders'])->name('users.admin.orders');
            // Route::get('/orders/{id}', [AdminOrderController::class, 'showOrder'])->name('users.admin.orders.show');

            // update order
            // Route::put('/orders/update_status/{id}', [AdminOrderController::class, 'updateOrderStatus'])->name('users.admin.orders.update_status');

            // Route::get('/income', [AdminOrderController::class, 'income'])->name('users.admin.income');
            // Route::get('/charges', [AdminOrderController::class, 'charges'])->name('users.admin.charges');

            // recyle bin
            Route::get('/recycle_bin', [AdminRecycleBin::class, 'index'])->name('users.admin.bin');
            Route::post('/recycle_bin/restore_user/{id}', [AdminRecycleBin::class, 'restoreUser'])->name('users.admin.bin.restore.user');
            Route::delete('/recycle_bin/delete_user/{id}', [AdminRecycleBin::class, 'deleteUser'])->name('users.admin.bin.delete.user');
            Route::post('/recycle_bin/restore_product/{id}', [AdminRecycleBin::class, 'restoreProduct'])->name('users.admin.bin.restore.product');
            Route::delete('/recycle_bin/delete_product/{id}', [AdminRecycleBin::class, 'deleteProduct'])->name('users.admin.bin.delete.product');

            // empty specific recycle based on id supplied
            Route::delete('/recycle_bin/empty_speciifc/{id}', [AdminRecycleBin::class, 'emptySpecific'])->name('users.admin.bin.empty.specific');

            // empty all recycle bin
            Route::delete('/recycle_bin/empty_all', [AdminRecycleBin::class, 'emptyAll'])->name('users.admin.bin.empty.all');    
        });

        //define the route for farmer
        // Route::prefix('farmer')->middleware('farmer')->group(function () {
        
        //     // pages
        //     Route::get('/dashboard', [FarmerPagesController::class, 'index'])->name('users.farmer.dashboard');

        //     // product
        //     Route::get('/add_product', [FarmerProductController::class, 'create'])->name('users.farmer.products.create');
        //     Route::post('/add_product', [FarmerProductController::class, 'store'])->name('users.farmer.products.store');
        //     Route::get('/products', [FarmerProductController::class, 'manage'])->name('users.farmer.products');
        //     Route::get('/products/{id}', [FarmerProductController::class, 'show'])->name('users.farmer.products.show');
        //     Route::get('/edit_product/{id}', [FarmerProductController::class, 'edit'])->name('users.farmer.products.edit');
        //     Route::put('/edit_product/{id}', [FarmerProductController::class, 'update'])->name('users.farmer.products.update');
        //     Route::delete('/products/delete/{id}', [FarmerProductController::class, 'delete'])->name('users.farmer.products.delete');
        //     Route::get('/buyer_orders/', [FarmerPagesController::class, 'buyerOrder'])->name('users.farmer.orders.buyer');
        //     Route::get('/buyer_orders/{id}/{slug}', [FarmerPagesController::class, 'showBuyerOrder'])->name('users.farmer.orders.buyer.show');
        //     Route::get('/my_orders/', [FarmerPagesController::class, 'myOrder'])->name('users.farmer.orders.self');
        //     Route::get('/my_orders/{id}', [FarmerPagesController::class, 'showMyOrder'])->name('users.farmer.orders.self.show');

        //     Route::get('/income', [FarmerPagesController::class, 'income'])->name('users.farmer.income');

                
        // });

        //define the route for buyer
        // Route::prefix('buyer')->middleware('buyer')->group(function () {
        //     Route::get('/dashboard', [BuyerController::class, 'index'])->name('users.buyer.dashboard');
        //     Route::get('/orders', [BuyerController::class, 'manage'])->name('users.buyer.orders');
        //     Route::get('/orders/{id}', [BuyerController::class, 'show'])->name('users.buyer.orders.show');
           
        // });
        
        //define the route for logistic
        // Route::get('/logistics/dashboard', [LogisticsController::class, 'index'])->name('users.logistics.dashboard');

    });

});

// define route for cart
Route::get('/cart', [CartController::class, 'show'])->name('cart.index');
Route::post('/add_cart', [CartController::class, 'add'])->name('cart.add');
Route::post('/update_cart', [CartController::class, 'update'])->name('cart.update');
Route::post('/delete_cart_item', [CartController::class, 'delete'])->name('cart.delete');
Route::post('/clear_cart', [CartController::class, 'clear'])->name('cart.clear');

// define route for checkout and payment
// Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [PaymentController::class, 'reviewCart'])->name('order.review');
    Route::post('/checkout', [PaymentController::class, 'verify'])->name('payment.verify');

    Route::post('checkout/single_product/{id}', [PaymentController::class, 'postSingleOrder'])->name('order.single.review.post');
    Route::get('checkout/{id}', [PaymentController::class, 'getSingleOrder'])->name('order.single.review.get');
    Route::post('/checkout/{id}', [PaymentController::class, 'verifySingleOrder'])->name('payment.verify.single');
// });