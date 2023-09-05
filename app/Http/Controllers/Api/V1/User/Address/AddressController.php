<?php

namespace App\Http\Controllers\Api\V1\User\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\Address\{AddressRequest, AddressUpdateRequest};
use App\Http\Resources\Api\V1\User\Address\AddressResource;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses_collection = AddressResource::collection(auth('user')->user()->addresses()->active()->get());
        return $this->respondOk($addresses_collection);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
        $address = auth('user')->user()->addresses()->create($request->validated());
        return $this->respondSuccess(AddressResource::make($address));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $address = auth('user')->user()->addresses()->findOrFail($id);
        return $this->respondSuccess(AddressResource::make($address));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressUpdateRequest $request, string $id)
    {
        $address = auth('user')->user()->addresses()->findOrFail($id);
        $address->update($request->validated());
        return $this->respondSuccess(AddressResource::make($address));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = auth('user')->user()->addresses()->findOrFail($id);
        $address->delete();
        return $this->respondSuccess();
    }
}
