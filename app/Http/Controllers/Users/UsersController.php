<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getUsers()
    {
        $users = User::all();

        return response()->json([
            'message' => ' اطلاعات کاربران با موفقیت دریافت شد ',
            'data' => $users
        ], 200);
    }

    public function getUser(User $user)
    {
        $user = User::find($user->id);

        return response()->json([
            'message' => ' اطلاعات کاربر ردیافت شد ',
            'data' =>  $user
        ], 200);
    }





    

    public function show(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => ' لطفا ابتدا وارد سایت شوید '
            ], 401);
        }


        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ]
        ]);
    }
}
