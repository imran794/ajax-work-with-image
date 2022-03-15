<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use File;
use App\Models\Brnad;
use App\Models\Category;
use App\Models\Product;


class ProductController extends Controller
{
    public function Index()
    {
        $brands = Brnad::latest('id')->where('deleted','no')->get();
        $categories = Category::latest('id')->get();
        return view('product.index',compact('brands','categories'));
    }


     public function ProductFatch()
    {
        $product = Product::latest('id')->where('deleted','no')->get();
        return response()->json([
                'product'  => $product
        ]);
    }

    

    public function AddProduct(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'brand_id'               => 'required',
            'category_id'            => 'required',
            'product_name'           => 'required|max:191',
            'product_price'          => 'required',
            'product_qty'            => 'required',
            'product_description'    => 'required',
            'product_image'          => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
             return response()->json([
                'status'  => 400,
                'errors'  => $validator->messages()
            ]);
        }

        else{

            $product = new Product();
            $product->brand_id            = $request->brand_id;
            $product->category_id         = $request->category_id;
            $product->product_name        = $request->product_name;
            $product->product_price       = $request->product_price;
            $product->product_qty         = $request->product_qty;
            $product->product_description = $request->product_description;
            $product->added_by            = Auth::id();
            $product->created_by          = Auth::id();

            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $extension = $file->getClientOriginalExtension();
                $filename  = time().'.'.$extension;
                $file->move('uploads/product/',$filename);
                $product->product_image = $filename;
            }

            $product->save();

               return response()->json([
                'status'    => 200,
                'messages'  => 'Product Added Successfully'
            ]);

        }
    }

    public function EditProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json([
                'status'   => 200,
                'product'  => $product 
            ]);
        }
        else{
            return response()->json([
                'status'    => 404,
                'messages'  => 'Product Not Found' 
            ]);
        }
    }

    public function ProductUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'brand_id'               => 'required',
            'category_id'            => 'required',
            'product_name'           => 'required|max:191',
            'product_price'          => 'required',
            'product_qty'            => 'required',
            'product_description'    => 'required',
        ]);

        if ($validator->fails()) {
             return response()->json([
                'status'  => 400,
                'errors'  => $validator->messages()
            ]);
        }

        else{

            $product = Product::find($id);

            if ($product) {
                
            $product->brand_id            = $request->brand_id;
            $product->category_id         = $request->category_id;
            $product->product_name        = $request->product_name;
            $product->product_price       = $request->product_price;
            $product->product_qty         = $request->product_qty;
            $product->product_description = $request->product_description;
            $product->updated_by            = Auth::id();

            if ($request->hasFile('product_image')) {

                $image_path = 'uploads/product/'.$product->product_image;

                if (File::exists($image_path)) {
                    File::delete($image_path);
                }

                $file = $request->file('product_image');
                $extension = $file->getClientOriginalExtension();
                $filename  = time().'.'.$extension;
                $file->move('uploads/product/',$filename);
                $product->product_image = $filename;
            }

            $product->save();

               return response()->json([
                'status'    => 200,
                'messages'  => 'Product Added Successfully'
            ]);


            }

            else{

               return response()->json([
                'status'    => 404,
                'messages'  => 'Product Not Found'
            ]);


            }

        }
    }


   public function ProductDelete($id)
   {
       
            $product = Product::find($id);
            $product->product_name = $product->product_name.'deleted'.$id;
            $user  = Auth::id();
            $product->deleted_by = $user;
            $product->deleted = 'yes';
            $product->status= 'Inactive';
            $product->save();


        if ($product) {
            return response()->json([
                    'status'      => 200,
                    'messages'   => 'Product Delete Successfully'
              ]);
        }

        else{
                return response()->json([
                    'status'      => 404,
                    'messages'   => 'Product Not Found'
              ]);
        }
   }

    

   
}
