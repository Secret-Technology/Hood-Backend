<?php

namespace App\Http\Controllers\Api\V1\User\Helper;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\User\ParcelCategory\ParcelCategoryResource;
use App\Models\ParcelCategory;

class ParcelCategoryController extends Controller
{
    public function index()
    {
        $parcel_categories = ParcelCategory::active()->latest()->get();
        return ParcelCategoryResource::collection($parcel_categories)->additional(['status' => 200, 'message' => null]);
    }
}
