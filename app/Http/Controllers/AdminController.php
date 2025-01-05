<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
class AdminController extends Controller
{
    public function index(){

        $productsCount = Product::count();
        $products = Product::all();
        $usersCount = User::count();
        return view('admin.main-dashboard', compact('products', 'productsCount', 'usersCount'));
    }
}
