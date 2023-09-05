<?php

namespace App\Http\Controllers\Api\V1\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\Order\OrderRequest;
use App\Http\Resources\Api\V1\User\Order\OrderResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = auth('user')->user()->orders()->latest()->paginate(10);
        return $this->respondSuccess(OrderResource::collection($orders));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $order = auth('user')->user()->orders()->create($request->validated() + ['status' => 'pending']);
        $order->address()->create($request->validated());
        $order->details()->create($request->validated());
        return $this->respondSuccess(OrderResource::make($order), 'Order Success!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = auth('user')->user()->orders()->findOrFail($id);
        return $this->respondSuccess(OrderResource::make($order));
    }

    /**
     * Update the specified resource in storage.
     */
    public function cancel(Request $request, string $id)
    {
        $order = auth('user')->user()->orders()->findOrFail($id);
        $order->update(['status' => 'cancel']);
        return $this->respondSuccess(OrderResource::make($order));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = auth('user')->user()->orders()->findOrFail($id);
        $order->delete();
        return $this->respondSuccess();
    }
}
