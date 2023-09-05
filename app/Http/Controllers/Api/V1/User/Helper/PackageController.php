<?php

namespace App\Http\Controllers\Api\V1\User\Helper;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\User\Package\PackageResource;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::active()->latest()->get();
        return PackageResource::collection($packages)->additional(['status' => 200, 'message' => null]);
    }
}
