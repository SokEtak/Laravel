<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index(){
        $orderDetail = OrderDetail::with(['user'])->get();
        return view('orderDetails.index', compact('orderDetail'));
    }
}
