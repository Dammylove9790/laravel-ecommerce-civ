<?php

namespace App\Http\Controllers\users\admin;

use App\Http\Controllers\Controller;
use App\Mail\RestoreMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminRecycleBin extends Controller
{
    public function index()
    {
        // users recylce bin
        $recycle_users = User::onlyTrashed()->orderByDesc('deleted_at')->get();

        // products recycle bin
        $recycle_products = Product::onlyTrashed()->with('picture')->orderByDesc('deleted_at')->get();

        return view('users.admin.pages.recycle_bin', compact('recycle_users', 'recycle_products'));

    }

    public function restoreUser($id)
    {
        $restore = User::onlyTrashed()->where('slug', $id)->firstOrFail();
        $restore->restore();

        $restore->item = "account";
        //Mail::to($restore->email)->send(new RestoreMail($restore));

        return redirect()->route('users.admin.bin')->with('success', "User has been restored successfully");
    }

    public function deleteUser($id)
    {
        User::onlyTrashed()->where('slug', $id)->forceDelete();
        return redirect()->route('users.admin.bin')->with('success', "User has been deleted permanently!");
    }

    public function restoreProduct($id)
    {
        $restore = Product::onlyTrashed()->where('slug', $id)->firstOrFail();
        $restore->restore();

        $restore->item = "product";
        $extract = explode("/", $restore->added_by);
       // Mail::to(end($extract))->send(new RestoreMail($restore));

        return redirect()->route('users.admin.bin')->with('success', "Product has been restored successfully");
    }

    public function deleteProduct($id)
    {
        Product::onlyTrashed()->where('slug', $id)->forceDelete();
        return redirect()->route('users.admin.bin')->with('success', "Product has been deleted permanently!");
    }

    public function emptySpecific($id)
    {
        if ($id === "Users") {
            User::onlyTrashed()->forceDelete();
        }
        if ($id === "Products") {
            Product::onlyTrashed()->forceDelete();
        }
        return redirect()->route('users.admin.bin')->with('success', "$id recycle bin emptied!");
    }

    public function emptyAll()
    {
        User::onlyTrashed()->forceDelete();
        Product::onlyTrashed()->forceDelete();
        return redirect()->route('users.admin.bin')->with('success', "Recycle bin emptied!");
    }
}