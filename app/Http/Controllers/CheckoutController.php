<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;

class CheckoutController extends Controller
{
    public function index() {

        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $discount = (float) $discount;
        $subtotal = floatval(Cart::subtotal());
        // dd($discount);
        $newSubtotal = $subtotal - $discount;
        if($newSubtotal < 0) {
            $newSubtotal = 0;
        }

        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal * (1 + $tax);
        // $newTotal = $newSubtotal + $tax * $newSubtotal;


        return view('checkout', compact('tax', 'discount', 'newSubtotal', 'newTax', 'newTotal'));

    }

    public function store(Request $request) {

        // dd($request->all());
        // return redirect()->route('confirmation.index')->with('success', 'Thank you! Your payment has been successfully accepted!');


        // $contents = Cart::content()->map(function ($item) {
        //     return $item->model->slug.', '.$item->qty;
        // })->values()->toJson();

         // Insert into orders table
         $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_postalcode' => $request->postalcode,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->name_on_card,
            // 'billing_discount' => $this->getNumbers()->get('discount'),
            'billing_discount' => null,
            // 'billing_discount_code' => $this->getNumbers()->get('code'),
            'billing_discount_code' => null,
            // 'billing_subtotal' => $this->getNumbers()->get('newSubtotal'),
            'billing_subtotal' => null,
            // 'billing_tax' => $this->getNumbers()->get('newTax'),
            'billing_tax' => null,
            // 'billing_total' => $this->getNumbers()->get('newTotal'),
            'billing_total' => null,
            'error' => null,
        ]);

        // Insert into order_product table
        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
            ]);
        }

        // try {
        //     $charge = Stripe::charges()->create([
        //         'amount' => (int)Cart::total() / 100,
        //         'currency' => 'CAD',
        //         'source' => $request->stripeToken,
        //         'description' => 'Order',
        //         'receipt_email' => $request->email,
        //         'metadata' => [
        //             //change to Order ID after we start using DB
        //             'contents' => $contents,
        //             'quantity' => Cart::instance('default')->count(),
        //         ],
        //     ]);

        //     // SUCCESSFUL
        //     Cart::instance('default')->destroy();
        //     // return back()->with('success_message', 'Thank you! Your payment has been successfully accepted!');
            return redirect()->route('confirmation.index')->with('success', 'Thank you! Your payment has been successfully accepted!');
        // } catch (CardErrorException $e) {
        //     return back()->withErrors('Error! ' . $e->getMessage());
        // }

    }
}
