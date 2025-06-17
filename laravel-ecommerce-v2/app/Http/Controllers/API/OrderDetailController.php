<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDetailResource;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderDetail = OrderDetail::with(['user','items'])->get(); // Make sure 'item' is eager loaded too
        return OrderDetailResource::collection($orderDetail);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'total'=>'required|numeric|min:0',

        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
        $orderDetail = OrderDetail::create($validator->validated());
        $orderDetail->load('item');

        return new OrderDetailResource($orderDetail);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $orderDetail = OrderDetail::findOrFail($id);

        if(!$orderDetail){
            return response()->json(['message' => 'Order Detail not found'], 404);
        }

        return new OrderDetailResource($orderDetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $orderDetail = OrderDetail::findOrFail($id);

        if(!$orderDetail){
            return response()->json(['message' => 'Order Detail not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'total'=>'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $orderDetail->update($validator->validated());
        return new OrderDetailResource($orderDetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $orderDetail=OrderDetail::findOrFail($id);

        if(!$orderDetail){
            return response()->json(['message' => 'Order Detail not found'], 404);
        }

        $orderDetail->delete();
        return response()->json(null, 204);
    }
}
