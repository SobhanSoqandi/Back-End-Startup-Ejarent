<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class categorycontroller extends Controller
{
    public function store(Request $request)
    {
        $category = Category::create($request->all());

        return response()->json([
            'message' => ' دسته بندی با موفقیت ایجاد شد ',
            'data' => $category
        ], 200);
    }

    public function delete(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => ' دسته بندی با موفقیت حذف شد ',
        ], status: 200);
    }

    public function update(Request $request, Category $category)
    {
        $category->update(request()->all());
        $category = Category::find($category->id);
        return response()->json([
            'message' => ' دسته بندی با موفقیت آپدیت شد ',
        ], status: 200);
    }

    public function show(Category $category)
    {
        return response()->json([
            'message' => ' اطلاعات با موفقیت دریافت شد ',
            "data" => $category
        ]);
    }
}
