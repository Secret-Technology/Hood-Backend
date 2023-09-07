<?php

namespace App\Http\Controllers\Api\V1\User\Rate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\Rate\RateRequest;
use App\Models\Order;
use App\Models\Rate;
use DB;

class RateController extends Controller
{
    public function rate(RateRequest $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::where(['id' => $request->order_id, 'user_id' => auth('user')->id()])->first();
            Rate::updateOrCreate(['order_id' => $order->id], $request->validated() +['driver_id' => $order->driver_id]);
            DB::commit();
            return response()->json(['status' => 200, 'data' => null, 'message' => 'success']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'fail', 'data' => null, 'message' =>'error'], 500);
        }
    }
}
