<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function generateOtp(Request $request)
    {

        $otp = rand(1000, 9999);
        
        $user = User::updateOrCreate(
            ['phoneNumber' => $request->phoneNumber],
            ['otp' => $otp]
        );

        return response()->json([
            'message' => 'کد چهار رقمی به شماره‌ی ' . $user->phoneNumber . ' ارسال شد',
            'phoneNumber' => $user->phoneNumber,
            'otp' => $user->otp
        ], 200);
    }
}
