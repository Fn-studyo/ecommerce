<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;
use App\Jobs\UpdateCoupon;
class CouponsController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();
        if(!$coupon){
            return redirect()->route('checkout.index')->withErrors('Invalid coupon code. Please try again');
        }
        dispatch_now( new UpdateCoupon($coupon));  
        return redirect()->route('checkout.index')->with('success_message', 'Coupon as been applied');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        session()->forget('coupon');
        return redirect()->route('checkout.index')->with('success_message', 'Your coupon has been removed');
    }
}
