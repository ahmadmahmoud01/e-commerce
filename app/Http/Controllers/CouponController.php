<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CouponController extends Controller
{
    public function store(Request $request) {

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if(!$coupon) {
            return redirect()->route('checkout.index')->withErrors('coupon you entered is not valid!');
        }

        session()->put('coupon', [
            'name' => $coupon->code,
            'discount' => $coupon->discount((int)Cart::subtotal())
        ]);

        // $newSubtotal = Cart::subtotal() - session()->get('coupon')['discount'];

        return redirect()->route('checkout.index')->with('success', 'coupon applied successfully!');

    }

    public function destroy() {

        session()->forget('coupon');

        return redirect()->route('checkout.index')->with('success', 'coupon has been removed!');


    }
}
