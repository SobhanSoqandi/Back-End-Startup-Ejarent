<?php

namespace App\Http\Controllers\Advertisements;

use App\Http\Controllers\Controller;
// use App\Http\Requests\requ$request;
use App\Models\Advertisement;
use App\Models\AdvertisementAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class AdvertisementsController extends Controller
{
    public function show(Advertisement $advertisement)
    {

        $advertisement->load('images');

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

        $this->authorize('update', $advertisement);


        $advertisement->update(request()->all());
        $advertisement = Advertisement::find($advertisement->id);
        return response()->json([
            'message' => ' آگهی با موفقیت بروزرسانی شد ',
            "data" => $advertisement
        ], status: 200);
    }


    public function delete(Advertisement $advertisement)
    {

        $this->authorize('delete', $advertisement);


        $advertisement->delete();
        return response()->json([
            'message' => ' آگهی با موفقیت حذف شد ',
        ], status: 200);
    }


    public function store(Request $request)
    {
        // $advertisement = Advertisement::create($request->all());

        $advertisement = Advertisement::create(
            $request->except('user_id') + ['user_id' => auth()->id()]
        );


        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {


                $path = Storage::putFile('advertisements/images', $image);

                $advertisement->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        $attributes = $request->input('attributes', []);

        foreach ($attributes as $attr) {
            AdvertisementAttributeValue::create([
                'advertisement_id' => $advertisement->id,
                'attribute_id'     => $attr['id'],
                'value'            => $attr['value'],
            ]);
        }

        return response()->json([
            'message' => ' آگهی با موفقیت ایجاد شد ',
            'data' => $advertisement,
        ], 201);
    }


    public function myAdvertisements()
    {
        $userId = auth()->id();

        // $advertisements = Advertisement::where('user_id', $userId)->get();
        $advertisements = Advertisement::with('images')
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'message' => 'لیست آگهی‌های شما با موفقیت دریافت شد',
            'data' => $advertisements,
        ], 200);
    }




    public function search(Request $request)
    {
        $query = Advertisement::with('images');

        // 🔍 جستجو
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 📂 دسته‌بندی
        if ($request->filled('category')) {
            $query->where('Id_category', $request->category);
        }

        // 🔃 مرتب‌سازی
        if ($request->filled('sort')) {
            match ($request->sort) {
                'cheap'     => $query->orderBy('price', 'asc'),
                'expensive' => $query->orderBy('price', 'desc'),
                default     => null,
            };
        }

        $advertisements = $query->get();

        return response()->json([
            'data'  => $advertisements,
            'total' => $advertisements->count(),
        ], 200);
    }
}
