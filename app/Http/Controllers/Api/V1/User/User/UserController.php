<?php

namespace App\Http\Controllers\Api\V1\User\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\User\ChangePasswordRequest;
use App\Http\Requests\Api\V1\User\User\UpdateProfile;
use App\Http\Resources\Api\V1\User\User\ProfileResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        return ProfileResource::make(auth('user')->user())->additional(['status' => 200, 'message' => null]);
    }


    public function update_profile(UpdateProfile $request)
    {
        auth('user')->user()->update($request->validated());
        return ProfileResource::make(auth('user')->user())->additional(['status' => 200, 'message' => __('Profile Updated Successfully!')]);
    }

    public function change_password(ChangePasswordRequest $request)
    {
        $user = auth('user')->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->respondFailed('Incorrect Password.');
        }

        $user->update(['password' => $request->password]);

        return $this->respondSuccess(null, 'Password Changed Successfully!');
    }
}
