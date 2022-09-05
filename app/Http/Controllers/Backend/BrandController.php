<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Intervention\Image\Facades\Image;


class BrandController extends Controller
{

    public function brandView(){
        $brands = Brand::latest()->get();
        return view('admin.backend.brand.brand_view',compact('brands'));

    }

    public function brandStore(Request $req){
      $validateData = $req->validate([
          'brand_name_en' => 'required',
          'brand_name_hin' => 'required',
          'brand_image' => 'required'
         ]);
      $image =$req->file('brand_image');
      $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
      Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
      $save_url = 'upload/brand/'.$name_gen;
      Brand::insert([
          'brand_name_en'=> $req->brand_name_en,
          'brand_name_hin'=> $req->brand_name_hin,
          'brand_slug_en'=> strtolower(str_replace(' ','-',$req->brand_name_en)),
          'brand_slug_hin'=> strtolower(str_replace(' ','-',$req->brand_name_hin)),
          'brand_image' => $save_url,
      ]);
        $notification = array(
            'message' => 'Brand Added successfully',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notification);
    }// End Method

    public function brandEdit($id){
        $brand = Brand::findOrFail($id);
        return view('admin.backend.brand.brand_edit',compact('brand'));


    }// End Method

    public function brandUpdate(Request $req){
        $id  = $req->id;
        $old_image = $req->old_image;
        if($req->file('brand_image')){
            unlink($old_image);
            $image =$req->file('brand_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
            $save_url = 'upload/brand/'.$name_gen;
            Brand::findOrFail($id)->Update([
                'brand_name_en'=> $req->brand_name_en,
                'brand_name_hin'=> $req->brand_name_hin,
                'brand_slug_en'=> strtolower(str_replace(' ','-',$req->brand_name_en)),
                'brand_slug_hin'=> strtolower(str_replace(' ','-',$req->brand_name_hin)),
                'brand_image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Brand Updaed successfully with Image',
                'alert-type' => 'info'
            );


            return redirect()->route('all.brand')->with($notification);
        }else{
            Brand::findOrFail($id)->Update([
                'brand_name_en'=> $req->brand_name_en,
                'brand_name_hin'=> $req->brand_name_hin,
                'brand_slug_en'=> strtolower(str_replace(' ','-',$req->brand_name_en)),
                'brand_slug_hin'=> strtolower(str_replace(' ','-',$req->brand_name_hin)),
            ]);
            $notification = array(
                'message' => 'Brand Updaed successfully without Image',
                'alert-type' => 'info'
            );


            return redirect()->route('all.brand')->with($notification);
        }


    }// End Method

    public function brandDelete($id){
     $brand =Brand::findOrFail($id);
     $img = $brand->brand_image;
     unlink($img);
     Brand::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Brand Deleted successfully with Image',
            'alert-type' => 'info'
        );
        return redirect()->back()->with($notification);
    } // End Method
}
