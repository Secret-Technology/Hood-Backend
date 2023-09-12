<?php

namespace App\Http\Controllers\Api\V1\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\Order\OrderRequest;
use App\Http\Resources\Api\V1\User\Order\OrderResource;
use App\Models\Driver;
use App\Models\Package;
use Illuminate\Http\Request;
use DB;

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
        DB::beginTransaction();
        try {
            $order = auth('user')->user()->orders()->create($request->validated() + ['status' => 'pending']);

            $package = Package::findOrFail($request->package_id);
            $fare_price = $order->distance * $package->km_price;
            $order->update(['fare_price' => $fare_price]);

            $order->address()->create($request->validated());

            if ($package->is_parcel) {
                $order->details()->create($request->validated());
            }

            $this->notifyNearestDrivers($order);

            DB::commit();
            return $this->respondSuccess(OrderResource::make($order), 'Order Success!');
        } catch (\Exception $exception) {
            DB::rollback();
            info($exception);
            return $this->respondInternalError('Oops Something went wrong!');
        }
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

    public function notifyNearestDrivers($order)
    {
        $lat = $order->from['lat'];
        $lng = $order->to['lng'];

        $drivers = Driver::active()->whereHas('package', function ($q) use ($order) {
            $q->where('package_id', $order->package_id);
        })->nearest($lat, $lng)
            ->get();

        \Notification::send($drivers, new FCMNotification($fcm_data, ['database']));
    }
}
