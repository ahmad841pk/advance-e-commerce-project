<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;


class SubCategoryController extends Controller
{
    public function subCategoryView(){
        $category = Category::orderBy('category_name_en','ASC')->get();
        $subcategory = SubCategory::latest()->get();
        return view('admin.backend.category.subcategory_view',compact('subcategory','category'));

    }// End Method

    public function SubCategoryStore(Request $req){
        $validateData = $req->validate([
            'category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_hin' => 'required',

           ]);

        SubCategory::insert([
            'category_id' => $req->category_id,
            'subcategory_name_en'=> $req->subcategory_name_en,
            'subcategory_name_hin'=> $req->subcategory_name_hin,
            'subcategory_slug_en'=> strtolower(str_replace(' ','-',$req->subcategory_name_en)),
            'subcategory_slug_hin'=> strtolower(str_replace(' ','-',$req->subcategory_name_hin)),


        ]);
          $notification = array(
              'message' => 'SubCategory Updated successfully',
              'alert-type' => 'success'
          );


          return redirect()->back()->with($notification);
      }// End Method


      public function subCategoryEdit($id){
        $category = Category::orderBy('category_name_en','ASC')->get();
        $subcategory = SubCategory::findOrFail($id);
        return view('admin.backend.category.subcategory_edit',compact('subcategory','category'));

      }

      public function subCategoryUpdate(Request $req)
    {
            $id  = $req->id;

            Category::findOrFail($id)->Update([
                'category_id' => $req->category_id,
                'subcategory_name_en'=> $req->subcategory_name_en,
                'subcategory_name_hin'=> $req->subcategory_name_hin,
                'subcategory_slug_en'=> strtolower(str_replace(' ','-',$req->subcategory_name_en)),
                'subcategory_slug_hin'=> strtolower(str_replace(' ','-',$req->subcategory_name_hin)),
            ]);
            $notification = array(
                'message' => 'Category Updated successfully',
                'alert-type' => 'info'
            );


            return redirect()->route('all.category')->with($notification);




    }// End Method

    public function subCategoryDelete($id){

        SubCategory::findOrFail($id)->delete();

           $notification = array(
               'message' => 'SubCategory Deleted successfully',
               'alert-type' => 'info'
           );
           return redirect()->back()->with($notification);
       } // End Method


    //.......Sub->Sub_Category Functions.........

    public function subSubCategoryView(){
        $category = Category::orderBy('category_name_en','ASC')->get();
        $subsubcategory = SubSubCategory::latest()->get();
        return view('admin.backend.category.sub_subcategory_view',compact('subsubcategory','category'));


    }// End Method

    // ...........Ajax Methods...........
    public function getSubcategory($category_id){

        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name_en','ASC')->get();
        return json_encode($subcat);

    }// End Method

    public function getSubSubCategory($subcategory_id){

        $Subsubcat = SubSubCategory::where('subcategory_id',$subcategory_id)->orderBy('subsubcategory_name_en','ASC')->get();
        return json_encode($Subsubcat);

    }// End Method



    public function subSubCategoryStore(Request $req){

        $validateData = $req->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'subsubcategory_name_en' => 'required',
            'subsubcategory_name_hin' => 'required',

        ]);

        SubSubCategory::insert([
            'category_id' => $req->category_id,
            'subcategory_id' => $req->subcategory_id,
            'subsubcategory_name_en'=> $req->subsubcategory_name_en,
            'subsubcategory_name_hin'=> $req->subsubcategory_name_hin,
            'subsubcategory_slug_en'=> strtolower(str_replace(' ','-',$req->subsubcategory_name_en)),
            'subsubcategory_slug_hin'=> strtolower(str_replace(' ','-',$req->subsubcategory_name_hin)),


        ]);
        $notification = array(
            'message' => 'Sub Sub-Category Inserted successfully',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notification);

    }// End Method

    public function subSubCategoryEdit($id){

        $category = Category::orderBy('category_name_en','ASC')->get();
        $subcategory = SubCategory::orderBy('subcategory_name_en','ASC')->get();
        $subsubcategories = SubSubCategory::findOrFail($id);
        return view('admin.backend.category.sub_subcategory_edit',compact('category','subcategory','subsubcategories'));


    }// End Method

    public function subSubCategoryUpdate(Request $req){

        $id  = $req->id;

        SubSubCategory::findOrFail($id)->update([
            'category_id' => $req->category_id,
            'subcategory_id' => $req->subcategory_id,
            'subsubcategory_name_en'=> $req->subsubcategory_name_en,
            'subsubcategory_name_hin'=> $req->subsubcategory_name_hin,
            'subsubcategory_slug_en'=> strtolower(str_replace(' ','-',$req->subsubcategory_name_en)),
            'subsubcategory_slug_hin'=> strtolower(str_replace(' ','-',$req->subsubcategory_name_hin)),


        ]);
        $notification = array(
            'message' => 'Sub Sub-Category Updated successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.subsubcategory')->with($notification);

    }// End Method

    public function  subSubCategoryDelete($id){

        SubSubCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Sub->SubCategory Deleted successfully',
            'alert-type' => 'info'
        );
        return redirect()->back()->with($notification);

    }// End Method
}
