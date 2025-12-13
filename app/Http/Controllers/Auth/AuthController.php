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
                'otp_expires_at' => now()->addMinutes(2)
            ]
        );

        return response()->json([
            'message' => 'کد چهار رقمی به شماره‌ی ' . $user->phoneNumber . ' ارسال شد',
            'phoneNumber' => $user->phoneNumber,
            'otp' => $user->otp
        ], 200);
    }


    public function CheckOtp(Request $request)
    {
        $request->validate([
            'phoneNumber' => 'required|string',
            'otp' => 'required|numeric',
        ]);

        $user = User::where('phoneNumber', $request->input('phoneNumber'))->first();

        if ($user->otp !== $request->input('otp')) {
            return response()->json([
                'message' => 'کد وارد شده صحیح نمی‌باشد',
                'valid' => false,
            ], 400);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return response()->json([
                'message' => 'کد منقضی شده است، لطفاً مجدداً درخواست ارسال کد بدهید',
                'valid' => false,
            ], 400);
        }

        return response()->json([
            'message' => 'تایید شد، خوش آمدید',
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

    // public function CompleteProfile(AuthRequest $authRequest)
    // {
    //     // 1. پیدا کردن کاربر
    //     $user = User::where('phoneNumber', $authRequest->phoneNumber)->first();

    //     if (!$user) {
    //         return response()->json([
    //             'message' => 'کاربری یافت نشد، لطفا وارد سایت شوید'
    //         ], 404);
    //     }

    //     // 2. آماده کردن داده‌ها برای آپدیت
    //     $updateData = [
    //         'name' => $authRequest->name,
    //         'national_code' => $authRequest->national_code,
    //     ];

    //     // 3. بررسی و آپلود عکس جدید
    //     $profileImage = $authRequest->file('profile_image');

    //     if ($profileImage) {
    //         // 3.1 پاک کردن عکس قبلی (اگر وجود داشت)
    //         if ($user->profile_image && Storage::exists($user->profile_image)) {
    //             Storage::delete($user->profile_image);
    //         }

    //         // 3.2 آپلود عکس جدید
    //         $user_profile_image_url = Storage::putFile('user/profile_images', $profileImage);
    //         $updateData['profile_image'] = $user_profile_image_url;
    //     }
    //     // اگر عکس جدید ارسال نشد، فیلد profile_image در $updateData قرار نمی‌گیرد
    //     // و عکس قبلی حفظ می‌شود

    //     // 4. آپدیت کاربر
    //     $user->update($updateData);

    //     // 5. بازگرداندن پاسخ
    //     return response()->json([
    //         'message' => 'پروفایل با موفقیت تکمیل شد',
    //         'user' => new UserResource($user)
    //     ], 200);
    // }
}
