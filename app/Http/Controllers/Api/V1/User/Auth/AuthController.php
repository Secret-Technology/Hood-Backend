<?php

namespace App\Http\Controllers\Api\V1\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\Auth\CompleteData;
use App\Http\Requests\Api\V1\User\Auth\Login;
use App\Http\Requests\Api\V1\User\Auth\LoginWithOtp;
use App\Http\Requests\Api\V1\User\Auth\CheckCode;
use App\Http\Requests\Api\V1\User\Auth\Register;
use App\Http\Requests\Api\V1\User\Auth\SendOtp;
use App\Http\Requests\Api\V1\User\Auth\VerifyPhone;
use App\Http\Resources\Api\V1\User\User\ProfileResource;
use App\Http\Requests\Api\V1\User\Auth\ForgetPassword;
use App\Http\Requests\Api\V1\User\Auth\UpdatePassword;
use App\Models\Country;
use App\Models\User;
use DB;
use Throwable;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  Register  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Register $request)
    {
        // create new user
        $user = $this->createUser($request);

        // set user token
        $this->loginAndSetToken($user);
        return $this->getResponse(200, __('User registered successfully'), ProfileResource::make($user));
    }

    /**
     * Complete user's data.
     *
     * @param  Register  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function complete_data(CompleteData $request)
    {
        $user = auth('user')->user();
        $user['token'] = auth('user')->tokenById($user->id);

        if ($user->is_data_completed) {
            return $this->getResponse(200, __('Your Data already completed'), ProfileResource::make($user));
        }
        $user->update($request->validated() + ['is_data_completed' => true]);
        $user->addresses()->create([
            'name' => 'home',
            'location' => $request->address,
        ]);
        return $this->getResponse(200, __('Data Completed Successfully'), ProfileResource::make(auth('user')->user()));
    }

    /**
     * Send OTP (One-Time Password) to the user's phone.
     *
     * @param  SendOtp  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send_otp(SendOtp $request)
    {
        // Get the user by phone and phone code
        $user = $this->getUserByPhoneAndCode($request->phone, $request->phone_code);

        if (!$user) {
            return $this->getResponse(401, __('provided phone not found!'));
        }

        // Generate an OTP
        $otp = "1111";
        // Update user's OTP
        $user->update(['otp' => $otp]);

        return $this->getResponse(200, __('Otp Sent successfully'));
    }

    function checkCode(CheckCode $request) {
        $user = $this->checkOtp($request->phone, $request->phone_code, $request->otp);
        $status= true;
        if (!$user) {
            $status = false;
            return $this->getResponse(200, __('Request successfully'), ['status'=>$status]);
        }
        return $this->getResponse(200, __('Request successfully'), ['status'=>$status]);
    }

    /**
     * Verify the user's phone using OTP.
     *
     * @param  VerifyPhone  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify_phone(VerifyPhone $request)
    {
        // Get the user by phone, phone code, and OTP
        $user = $this->getUserByPhoneAndCodeAndOtp($request->phone, $request->phone_code, $request->phone_confirmation_token);

        if (!$user) {
            return $this->getResponse(401, __('provided phone not found!'));
        }

        if ($user->is_active && $user->phone_confirmed) {
            return $this->getResponse(422, __('your account already active.'));
        }

        // Update user as active, verified, and clear OTP
        $this->updateUserAndLogin($user);

        return ProfileResource::make($user)->additional(['status' => 200, 'message' => __('Phone verification success.')]);
    }

    /**
     * User login with phone and password.
     *
     * @param  Login  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Login $request)
    {
        // Attempt user login
        $token = $this->attemptLogin($request->phone, $request->phone_code, $request->password);

        if (!$token) {
            return $this->getResponse(401, __('wrong phone or password!'));
        }

        $user = auth('user')->user();

        // Check if phone is verified and account is active
        if (!$user->phone_confirmed) {
            return $this->getResponse(403, __('Please verify your phone first.'));
        }

        if (!$user->is_active) {
            return $this->getResponse(403, __('your account have been deactivated.'));
        }

        $this->setUserToken($user, $token);

        return ProfileResource::make($user)->additional(['status' => 200, 'message' => __('Login Success.')]);
    }

    /**
     * User login with phone and OTP.
     *
     * @param  Login  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login_with_otp(LoginWithOtp $request)
    {
        // Attempt user login with OTP
        $user = $this->attemptLoginOtp($request->phone, $request->phone_code, $request->otp);

        if (!$user) {
            return $this->getResponse(401, __('wrong phone or otp!'));
        }

        // Clear user's OTP
        $this->updateUserOtp($user);

        // Check if phone is verified and account is active
        if (!$user->phone_confirmed) {
            return $this->getResponse(403, __('Please verify your phone first.'));
        }

        if (!$user->is_active) {
            return $this->getResponse(403, __('your account have been deactivated.'));
        }

        $token = auth('user')->login($user);

        $this->setUserToken($user, $token);

        return ProfileResource::make($user)->additional(['status' => 200, 'message' => __('Login Success.')]);
    }

    /**
     * Send a reset password code to the user's phone.
     *
     * @param  ForgetPassword  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forget_password(ForgetPassword $request)
    {
        // Generate a reset password code
        $forgetPasswordCode = "1111";

        // Fetch the user by matching phone code and phone
        $user = User::where(['phone_code' => $request->phone_code, 'phone' => $request->phone])->firstOrFail();

        // Update user's forget password code
        $user->update(['forget_password_code' => $forgetPasswordCode]);

        // Respond with success message
        return $this->getResponse(200, __('A reset password code has been sent to your email.'));
    }

    /**
     * Update user's password using the reset password code.
     *
     * @param  UpdatePassword  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_password(UpdatePassword $request)
    {
        // Fetch the user by matching phone code, phone, and forget password code
        $user = User::where([
            'phone_code' => $request->phone_code,
            'phone' => $request->phone,
            'forget_password_code' => $request->forget_password_code
        ])->firstOrFail();

        // Update user's password and clear the forget password code
        $user->update(['password' => $request->password, 'forget_password_code' => null]);

        // Respond with success message
        return $this->getResponse(200, __('Password updated successfully.'));
    }

    private function getUserByPhoneAndCode($phone, $phoneCode)
    {
        return User::where(['phone' => $phone, 'phone_code' => $phoneCode])->first();
    }

    private function getUserByPhoneAndCodeAndOtp($phone, $phoneCode, $phone_confirmation_token)
    {
        return User::where(['phone' => $phone, 'phone_code' => $phoneCode, 'phone_confirmation_token' => $phone_confirmation_token])->first();
    }

    private function updateUserAndLogin($user)
    {
        $user->update(['is_active' => true, 'phone_confirmation_token' => null, 'phone_confirmed' => true]);
        $token = auth('user')->login($user);
        $this->setUserToken($user, $token);
    }

    private function attemptLogin($phone, $phoneCode, $password)
    {
        return auth('user')->attempt(['phone' => $phone, 'phone_code' => $phoneCode, 'password' => $password]);
    }

    private function attemptLoginOtp($phone, $phoneCode, $otp)
    {
        return User::where(['phone' => $phone, 'phone_code' => $phoneCode, 'otp' => $otp])->first();
    }

    private function checkOtp($phone, $phoneCode, $otp)
    {
        return User::where(['phone' => $phone, 'phone_code' => $phoneCode, 'forget_password_code' => $otp])->first();
    }

    private function updateUserOtp($user)
    {
        $user->update(['otp' => null]);
    }

    private function setUserToken($user, $token)
    {
        data_set($user, 'token', $token);
    }

    private function loginAndSetToken(User $user)
    {
        $token = auth('user')->login($user);
        data_set($user, 'token', $token);
    }

    private function createUser(Register $request)
    {
        $code = "1111";
        $country = Country::where(['phone_code' => $request->phone_code])->first();
        return User::create($request->validated() + ['phone_confirmation_token' => $code, 'country_id' => $country->id]);
    }

    /**
     * Get a standardized response.
     *
     * @param  int  $status
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function getResponse($status, $message, $data = null,  $code = null)
    {
        return response()->json(['status' => $status, 'data' => $data, 'message' => __($message)], $code ?: $status);
    }
}
