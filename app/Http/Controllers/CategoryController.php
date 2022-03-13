<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Category;
use File;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function CategoryFatch()
    {
        $category = Category::latest('id')->get();
        return response()->json([
            'category'  => $category
        ]);
    }

    public function AddCategory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_name'   => 'required|max:191',
            'category_image'  => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->messages()
            ]);
        }

        else{

             $category = new Category();

            $category->category_name = $request->category_name;


            if ($request->hasFile('category_image')) {
                $file = $request->file('category_image');
                $extension = $file->getClientOriginalExtension();
                $file_name = time() .".". $extension;
                $file->move('uploads/category/',$file_name);
                $category->category_image = $file_name;


            }
             $category->save();

              return response()->json([
                'status'   => 200,
                'messages'  => 'Category Added Successfully'
            ]);

            }
           
        }

        public function EditFatch($id)
        {
            $category = Category::find($id);

            if ($category) {
                return response()->json([
                     'status'   => 200,
                     'category'  => $category
                ]);
            }

            else{
                return response()->json([
                     'status'   => 404,
                     'messages'  => 'Category Not Found'
                ]);
            }
        }

        public function CategoryUpdate(Request $request, $id)
        {
             $validator = Validator::make($request->all(),[
            'category_name'   => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->messages()
            ]);
        }

        else{

             $category = Category::find($id);

             if ($category) {
                $category->category_name = $request->category_name;


            if ($request->hasFile('category_image')) {

                $image_path = 'uploads/category/'.$category->category_image;

                if (File::exists($image_path)) {
                    File::delete($image_path);
                }


                $file = $request->file('category_image');
                $extension = $file->getClientOriginalExtension();
                $file_name = time() .".". $extension;
                $file->move('uploads/category/',$file_name);
                $category->category_image = $file_name;


            }
             $category->save();

              return response()->json([
                'status'   => 200,
                'messages'  => 'Category Updated Successfully'
             ]);
             }
             else{
                 return response()->json([
                'status'   => 404,
                'messages'  => 'Category Not Found'
             ]);
             }

          

            }
           
        }


  }
    

