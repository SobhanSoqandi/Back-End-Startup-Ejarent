<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $reserve = Reservation::create($request->all());
        return response()->json([
            'message' => ' درخواست با موفقیت ثبت شد ',
            'data' => $reserve,
        ], 201);
    }


    public function myRequest($userId)
    {
        $reserve = Reservation::where('user_id', $userId)->get();

        return response()->json([
            'message' => ' رزور ها با موفقیت دریافت شد ',
            'user_id' => $userId,
            'data' => $reserve,
        ], 200);
    }


    public function myAdvertisementRequest($AdId)
    {
        $reserve = Reservation::where('advertisement_id', $AdId)->get();

        return response()->json([
            'message' => ' درخواست های رزرو آگهی ها موفقیت دریافت شد ',
            'Ad_id' => $AdId,
            'data' => $reserve
        ], 200);
    }




    public function UpdateStatus(Request $request, $reserveid)
    {
        $reservation = Reservation::find($reserveid);

        $reservation->update([
            'status' => $request->status
        ]);

        // mathc or swithc case : 
        $statusMessage = match ($request->status) {
            0 => 'وضعیت به "رد شده" تغییر یافت.',
            1 => 'وضعیت به "در حال بررسی" تغییر یافت.',
            2 => 'وضعیت به "تایید شده" تغییر یافت.',
            default => 'وضعیت بروزرسانی شد.'
        };


        return response()->json([
            'message' => $statusMessage,
            'data' => $reservation
        ], 200);
    }
}
