<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function categoryView(){
        $category = Category::latest()->get();
        return view('admin.backend.category.category_view',compact('category'));

    }// End Method


    public function categoryStore(Request $req){
        $validateData = $req->validate([
            'category_name_en' => 'required',
            'category_name_hin' => 'required',
            'category_icon' => 'required'
           ]);

        Category::insert([
            'category_name_en'=> $req->category_name_en,
            'category_name_hin'=> $req->category_name_hin,
            'category_slug_en'=> strtolower(str_replace(' ','-',$req->category_name_en)),
            'category_slug_hin'=> strtolower(str_replace(' ','-',$req->category_name_hin)),
            'category_icon'=> $req->category_icon

        ]);
          $notification = array(
              'message' => 'Category Added successfully',
              'alert-type' => 'success'
          );


          return redirect()->back()->with($notification);
      }// End Method

      public function categoryEdit($id){
        $category = Category::findOrFail($id);
        return view('admin.backend.category.category_edit',compact('category'));


    }// End Method

    public function categoryUpdate(Request $req)
    {
        $id  = $req->id;

            Category::findOrFail($id)->Update([
                'category_name_en'=> $req->category_name_en,
                'category_name_hin'=> $req->category_name_hin,
                'category_slug_en'=> strtolower(str_replace(' ','-',$req->category_name_en)),
                'category_slug_hin'=> strtolower(str_replace(' ','-',$req->category_name_hin)),
                'category_icon' => $req->category_icon
            ]);
            $notification = array(
                'message' => 'Category Updaed successfully',
                'alert-type' => 'info'
            );


            return redirect()->route('all.category')->with($notification);




    }// End Method

    public function categoryDelete($id){

        Category::findOrFail($id)->delete();

           $notification = array(
               'message' => 'Category Deleted successfully',
               'alert-type' => 'info'
           );
           return redirect()->back()->with($notification);
       } // End Method

}
