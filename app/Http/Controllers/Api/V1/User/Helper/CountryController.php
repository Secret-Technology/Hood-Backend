<?php

namespace App\Http\Controllers\Api\V1\User\Helper;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Country\Country as CountryResource;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::latest()->get();
        // $countries = Country::active()->latest()->get();
        return CountryResource::collection($countries)->additional(['status' => 200, 'message' => null]);
    }
}
