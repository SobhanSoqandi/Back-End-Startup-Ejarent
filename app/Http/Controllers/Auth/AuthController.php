<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
}
