<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {

        $products = Product::where('featured', true)->take(8)->inRandomOrder()->get();

        return view('home', compact('products'));

    }
}
