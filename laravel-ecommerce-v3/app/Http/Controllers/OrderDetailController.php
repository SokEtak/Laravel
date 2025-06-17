<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;

class OrderDetailController extends Controller
{
    public function index(){
        $orderDetail = OrderDetail::with(['user'])->get();
//        dd($orderDetail);
        return view('orderDetails.index', compact('orderDetail'));
    }
}
