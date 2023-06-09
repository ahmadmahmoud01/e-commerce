<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index() {

        $pagination = 9;
        $categories = Category::all();

        if (request()->category) {

            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            });

            $categoryName = optional($categories->where('slug', request()->category)->first())->name;

        } else {

            $products = Product::where('featured', true);
            $categoryName = 'Featured';

        }

        if (request()->sort == 'low_high') {

            $products = $products->orderBy('price')->paginate($pagination);

        } elseif (request()->sort == 'high_low') {

            $products = $products->orderBy('price', 'desc')->paginate($pagination);

        } else {

            $products = $products->paginate($pagination);
        }


        return view('shop', compact('products', 'categories', 'categoryName'));

    }// end of index

    public function show($slug) {

        $product = Product::where('slug', $slug)->firstOrfail();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->inRandomOrder()->take(4)->get();

        if($product->quantity > 5) {

            $stockLevel = '<div class="badge badge-success">in stock</div>';

        } elseif($product->quantity <= 5 && $product->quantity > 0) {

            $stockLevel = '<div class="badge badge-warning">low stock</div>';

        } else {

            $stockLevel = '<div class="badge badge-danger">not available</div>';

        }


        return view('product', compact('product', 'mightAlsoLike', 'stockLevel'));

    }

    // search function

    public function search(Request $request) {

        $request->validate([
            'query' => 'required|min:3'
        ]);

        $query = $request->input('query');

        $products = Product::where('name', 'like', "%$query%")
                                ->orWhere('details', 'like', "%$query%")
                                ->orWhere('description', 'like', "%$query%")
                                ->paginate(10);

        return view('search-results', compact('products'));

    }



}
