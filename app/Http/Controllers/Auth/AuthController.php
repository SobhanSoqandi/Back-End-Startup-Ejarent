<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Facades\Storage::putFile();

class AuthController extends Controller
{
    public function SendOtp(Request $request)
    {
        $otp = rand(1000, 5000);

        if (empty(trim($request->phoneNumber))) {
            return response()->json([
                'message' => 'لطفا شماره تلفن معتبر وارد کنید'
            ], 400);
        }

        $user = User::updateOrCreate(
            ['phoneNumber' => $request->phoneNumber],
            [
                'otp' => $otp,
                'otp_created_at' => now()
            ]
        );
        return response()->json([
            'message' => 'کد چهار رقمی به شماره‌ی ' . $user->phoneNumber . ' ارسال شد',
            'phoneNumber' => $user->phoneNumber,
            'otp' => $user->otp,
        ], 200);
    }


    public function CheckOtp(Request $request)
    {
        $request->validate([
            'phoneNumber' => 'required|string',
            'otp' => 'required|numeric',
        ]);

        $user = User::where('phoneNumber', $request->input('phoneNumber'))->first();
        $token = $user->createToken('auth-token');


        if ($user->otp !== $request->input('otp')) {
            return response()->json([
                'message' => 'کد وارد شده صحیح نمی‌باشد',
                'valid' => false,
            ], 400);
        }

        if ($user->isOtpExpired()) {
            return response()->json([
                'message' => 'کد منقضی شده است، لطفاً مجدداً درخواست ارسال کد بدهید',
                'valid' => false,
            ], 400);
        }

        return response()->json([
            'message' => 'تایید شد، خوش آمدید',
            'token' => $token->plainTextToken,
            'valid' => true,
        ], 200);
    }



    public function CompleteProfile(AuthRequest $authRequest)
    {

        $user = User::where('phoneNumber', $authRequest->phoneNumber)->first();

        if (!$user) {
            return response()->json([
                'message' => ' کاربری یافت نشد , لطفا وارد سایت شوید '
            ], 404);
        }

        // $user_profile_image_url = Storage::putFile('/user/profile_images' , $authRequest->profile_image );

        $user_profile_image_url = 'default/user.png';

        if ($authRequest->hasFile('profile_image')) {
            $user_profile_image_url = Storage::putFile('/user/profile_images', $authRequest->file('profile_image'));
        }

        $user->update(request()->all());

        return response()->json([
            'message' => 'پروفایل با موفقیت تکمیل شد',
            'user' => new UserResource($user)
        ], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'با موفقیت خارج شدید',
            'success' => true,
        ], 200);
    }
}
