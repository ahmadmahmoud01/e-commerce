<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index() {

        $data['mightAlsoLike'] = Product::inRandomOrder()->take(4)->get();

        return view('cart')->with($data);

    } // end of index

    public function store(Product $product, Request $request) {

        $duplicates = Cart::search(function ($cartItem) use ($product) {

            return $cartItem->id === $product->id;

        });



        if ($duplicates->isNotEmpty()) {

            return redirect()->route('cart.index')->with('success', 'Item is already in your cart!');

        }

        Cart::add($product->id, $product->name, 1, $product->price)
            ->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('success', 'Item was added to your cart successfully!');

    }// end of store

    public function destroy($id) {

        Cart::remove($id);

        return redirect()->route('cart.index')->with('success', 'Item has been removed!');

    }// end of destroy

    public function switchToSaveForLater($id) {

        $item = Cart::get($id);

        Cart::remove($id);

        $duplicates = Cart::instance('saveForLater')->search(function ($cartItem, $rowId) use ($id) {

            return $rowId === $id;

        });

        if ($duplicates->isNotEmpty()) {

            return redirect()->route('cart.index')->with('success', 'Item is already Saved For Later!');

        }



        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('success', 'item has been saved for later successfully');


    }// end of switchToSaveForLater

    public function update(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if ($validator->fails()) {

            session()->flash('errors', collect(['Quantity must be between 1 and 5.']));

            return response()->json(['success' => false], 400);
        }

        Cart::update($id, $request->quantity);

        session()->flash('success', 'Quantity was updated successfully!');

        return response()->json(['success' => true]);
    }


}
