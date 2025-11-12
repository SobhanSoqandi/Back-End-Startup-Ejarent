<?php

namespace App\Http\Controllers\Advertisements;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertisementStoreRequest;
use App\Models\Advertisement;
use Illuminate\Http\Request;
// use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class AdvertisementsController extends Controller
{
    public function show(Advertisement $advertisement)
    {
        return response()->json([
            'message' => ' اطلاعات با موفقیت دریافت شد ',
            "data" => $advertisement
        ]);
    }

    public function index()
    {
        $advertisement = Advertisement::all();
        return response()->json([
            'message' => ' لیست تمامی آگهی ها با موفقیت دریافت شد ',
            'data' => $advertisement,
        ], 200);
    }

    public function update(Advertisement $advertisement, Request $request)
    {
        // dd($request->all()); 
        $advertisement->update(request()->all());
        $advertisement = Advertisement::find($advertisement->id);
        return response()->json([
            'message' => ' آگهی با موفقیت بروزرسانی شد ',
            "data" => $advertisement
        ], status: 200);
    }


    public function delete(Advertisement $advertisement)
    {
        $advertisement->delete();
        return response()->json([
            'message' => ' آگهی با موفقیت حذف شد ',
        ], status: 200);
    }


    public function store(Request $request)
    {
        $advertisement = Advertisement::create($request->all());
        return response()->json([
            'message' => ' آگهی با موفقیت ایجاد شد ',
            'data' => $advertisement
        ], 200);
    }
}
