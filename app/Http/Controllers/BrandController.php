<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brnad;
use Validator;
use Auth;
use File;


class BrandController extends Controller
{
    public function Index()
    {
        return view('brand.index');
    }

    public function BrandFetchData()
    {
        $brand = Brnad::latest('id')->get();
        return response()->json([
            'brand'  => $brand
        ]);
    }


    public function BrandStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'brand_name'      => 'required|max:191',
            'brand_number'    => 'required|numeric|digits:11',
            'brand_location'  => 'required|max:191',
            'brand_image'     => 'required|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

          if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->messages()
            ]);
        }


        else{

            $brand = new Brnad();
            $brand->brand_name         = $request->brand_name;
            $brand->brand_number       = $request->brand_number;
            $brand->brand_location     = $request->brand_location;
            $brand->added_by           = Auth::id();
            $brand->created_by         = Auth::id();

            if ($request->hasFile('brand_image')) {
                $file = $request->file('brand_image');
                $extension = $file->getClientOriginalExtension();
                $filename = time().".".$extension;
                $file->move('uploads/brand/',$filename);
                $brand->brand_image = $filename;

            }

            $brand->save();

            return response()->json([
             'status'     => 200,
             'messages'   => 'Brand Added Successfully'
           ]);

        }
    }

    public function BrandEdit($id)
    {
        $brand = Brnad::find($id);
        if ($brand) {
              return response()->json([
             'status'     => 200,
             'brand'   => $brand
           ]);
        }else{
             return response()->json([
             'status'     => 404,
             'messages'   => 'Brand Not Found'
           ]);
        }
        
    }
}
