<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubSubCategory;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\MultiImage;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function addProduct(){
     $categoryZ                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 = Category::latest()->get();
     $brands = Brand::latest()->get();

     return view('admin.backend.product.product_add',compact('category','brands'));

    }// End Method

    public function storeProduct(Request $req)

    {   $image =$req->file('product_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(917,1000)->save('upload/products/thumbnail/'.$name_gen);
        $save_url = 'upload/products/thumbnail/'.$name_gen;

        $product_id = Product::insertGetId([

             'brand_id'  => $req->brand_id,
             'category_id' => $req->category_id,
             'subcategory_id' => $req->subcategory_id,
             'subsubcategory_id' => $req->subsubcategory_id,
             'product_name_en' => $req->product_name_en,
             'product_name_hin' => $req->product_name_hin,
             'product_slug_en' => strtolower(str_replace('','-',$req->product_name_en)),
             'product_slug_hin' => strtolower(str_replace('','-',$req->product_name_hin)),
             'product_code' => $req->product_code,
             'product_qty' => $req->product_qty,
             'product_tags_en' => $req->product_tags_en,
             'product_tags_hin' => $req->product_tags_hin,
             'product_size_en' => $req->product_size_en,
             'product_size_hin' => $req->product_size_hin,
             'product_color_en' => $req->product_color_en,
             'product_color_hin' => $req->product_color_hin,
             'selling_price' => $req->selling_price,
             'discount_price' => $req->discount_price,
             'short_descp_en' => $req->short_descp_en,
             'short_descp_hin' => $req->short_descp_hin,
             'long_descp_en' => $req->long_descp_en,
             'long_descp_hin' => $req->long_descp_hin,

             'product_thumbnail' => $save_url,
             'status' => 1,

             'hot_deals' => $req->hot_deals,
             'featured' => $req->featured,
             'special_offer' => $req->special_offer,
             'special_deals' => $req->special_deals,

             'created_at' => Carbon::now(),


        ]);

                     /////////Multiple Image Upload start////////////////

   $images =$req->file('multi_img');
   foreach ($images as $img){
    $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        Image::make($img)->resize(917,1000)->save('upload/products/multi-image/'.$make_name);
        $uploadPath = 'upload/products/multi-image/'.$make_name;

        MultiImage::insert([

            'product_id' => $product_id,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(),
       ]);
   }
     //////// End Multiple Image ///////////

     $notification = array(
        'message' => 'Product inserted successfully',
        'alert-type' => 'success'
    );
    return redirect()->route('manage.product')->with($notification);


    }// End Method

    public function manageProduct()
    {
         $products = Product::latest()->get();

        return view('admin.backend.product.product_view', compact('products'));
    }// End Method

    public function editProduct($id)
    {

      $multiImgs =MultiImage::where('product_id',$id)->get();


       $products = Product::findOrFail($id);
       $category = Category::latest()->get();
       $brands = Brand::latest()->get();
       $subcategory = SubCategory::latest()->get();
       $subsubcategory = SubSubCategory::latest()->get();

       return view('admin.backend.product.product_edit',compact('products','category','brands','subcategory','subsubcategory','multiImgs'));


    }// End Method

    public function updateProduct(Request $req)
    {
           $product_id = $req->id;

             Product::findOrFail($product_id)->update([

            'brand_id'  => $req->brand_id,
            'category_id' => $req->category_id,
            'subcategory_id' => $req->subcategory_id,
            'subsubcategory_id' => $req->subsubcategory_id,
            'product_name_en' => $req->product_name_en,
            'product_name_hin' => $req->product_name_hin,
            'product_slug_en' => strtolower(str_replace('','-',$req->product_name_en)),
            'product_slug_hin' => strtolower(str_replace('','-',$req->product_name_hin)),
            'product_code' => $req->product_code,
            'product_qty' => $req->product_qty,
            'product_tags_en' => $req->product_tags_en,
            'product_tags_hin' => $req->product_tags_hin,
            'product_size_en' => $req->product_size_en,
            'product_size_hin' => $req->product_size_hin,
            'product_color_en' => $req->product_color_en,
            'product_color_hin' => $req->product_color_hin,
            'selling_price' => $req->selling_price,
            'discount_price' => $req->discount_price,
            'short_descp_en' => $req->short_descp_en,
            'short_descp_hin' => $req->short_descp_hin,
            'long_descp_en' => $req->long_descp_en,
            'long_descp_hin' => $req->long_descp_hin,

            'status' => 1,

            'hot_deals' => $req->hot_deals,
            'featured' => $req->featured,
            'special_offer' => $req->special_offer,
            'special_deals' => $req->special_deals,

            'created_at' => Carbon::now(),


       ]);

       $notification = array(
        'message' => 'Product Updated Without Image successfully',
        'alert-type' => 'success'
    );
    return redirect()->route('manage.product')->with($notification);

    }// End Method


    // Multiple Image Update
    public function MultiImageUpdate(Request $req)
    {

       $imgs = $req->multi_img;
       foreach($imgs as $id => $img){
        $imgDel =MultiImage::findOrFail($id);
        unlink($imgDel->photo_name);
       $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        Image::make($img)->resize(917,1000)->save('upload/products/multi-image/'.$make_name);
        $uploadPath = 'upload/products/multi-image/'.$make_name;

        MultiImage::where('id',$id)->update([
            'photo_name' => $uploadPath,
            'updated_at' => Carbon::now(),
        ]);

       }// End foreach

       $notification = array(
        'message' => 'Product Updated With Image successfully',
        'alert-type' => 'info'
    );
    return redirect()->back()->with($notification);

    }// End Method


    /// Product Main Thumbnail

    public  function thumbnailImageUpdate(Request $req){
        $pro_id =  $req->id;
        $oldImage = $req->old_img;
        unlink($oldImage);
        $image =$req->file('product_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(917,1000)->save('upload/products/thumbnail/'.$name_gen);
        $uploadPath= 'upload/products/thumbnail/'.$name_gen;

        Product::findOrFail($pro_id)->update([
            'product_thumbnail' => $uploadPath,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Producthumbnail Updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
     }// End Method


     //........Multi Image Delete.........//
     public function MultiImageDelete($id){

        $oldimg = MultiImage::findOrFail($id);
        unlink($oldimg->photo_name);
        MultiImage::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Multi_Image Deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

     }// End Method

     public function productInactive($id)
     {
         Product::findOrFail($id)->update([

            'status' => '0'
         ]);
         $notification = array(
            'message' => 'Product Now Inactive',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);



     }// End Method


     public function productActive($id)
     {
        Product::findOrFail($id)->update([

            'status' => '1'
         ]);
         $notification = array(
            'message' => 'Product Now Active',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
     }// End Method

     public function productDelete($id){

        $product = product::findOrFail($id);
        unlink($product->product_thumbnail);
        product::findOrFail($id)->delete();

        $images = MultiImage::where('product_id',$id)->get();

        foreach($images as $img){
            unlink($img->photo_name);
            MultiImage::where('product_id',$id)->delete();
        }
        $notification = array(
            'message' => 'Product Deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);



     }// End Method


}
