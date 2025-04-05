<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularProducts = Product::take(4)->get();
        return view('home', compact('popularProducts'));
    }

    public function menu()
    {
        $products = Product::all();
        return view('menu', compact('products'));
    }

    public function cart()
    {
        return view('cart');
    }
}
