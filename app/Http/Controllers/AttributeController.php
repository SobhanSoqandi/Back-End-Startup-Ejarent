<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Dom\Attr;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index(){
        $attribute = Attribute::all();
        return response()->json([
            'message' => ' لیست ویژگی ها دریافت شد ',
            'data' => $attribute,
        ] , 201);
    }


    public function store(Request $request){
        $attribute = Attribute::create($request->all());
        return response()->json([
            'message' => ' ویژگی با موفقیت اضافه شد ',
            'data' => $attribute,
        ] , 201 );
    }

    public function update(Request $request , Attribute $attribute){
        $attribute->update(request()->all());
        $attribute = Attribute::find($attribute->id);
        return response()->json([
            'message' => ' ویژگی با موفقیت بروز رسانی شد  ',
            'data' => $attribute,
        ] , 201);
    }


}
