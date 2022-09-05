<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\MultiImage;
use App\Models\SubCategory;
use App\Models\Slider;
use App\Models\Product;
class UserController extends Controller

{
    public function index()
    {

    $products = Product::where('status',1)->orderBy('id','DESC')->get();
    $featured = Product::where('featured',1)->orderBy('id','DESC')->limit(4)->get();
    $hot_deals = Product::where('hot_deals',1)->where('discount_price','!=',NULL)->orderBy('id','DESC')->limit(3)->get();
    $sliders = Slider::where('status',1)->orderBy('id','DESC')->limit(3)->get();
    $categories = Category::orderBy('category_name_en','ASC')->get();

     $skip_category_0 = Category::skip(0)->first();
     $skip_product_0 = Product::where('status',1)->where('category_id',$skip_category_0 ->id)->orderBy('id','DESC')->get();

     $skip_category_1 = Category::skip(1)->first();
     $skip_product_1 = Product::where('status',1)->where('category_id',$skip_category_1 ->id)->orderBy('id','DESC')->get();


     $skip_brand_1 = Brand::skip(1)->first();
     $skip_brand_product_1 = Product::where('status',1)->where('brand_id',$skip_brand_1 ->id)->orderBy('id','DESC')->get();


       return view('frontend.index',compact('categories','sliders','products','featured','hot_deals','skip_category_0','skip_product_0','skip_category_1','skip_product_1','skip_brand_1','skip_brand_product_1'));
    }

    public function userLogout()
    {
        Auth::logout();

        return redirect()->route('login');

    }
     public function userProfile()
     {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.user_profile', compact('user'));
     }

     public function userProfileStore(Request $req)
     {
        $data = User ::find(Auth::user()->id);
        if($req->file('profile_photo_path')){
            $image = $req->file('profile_photo_path');
            $imageul = public_path('upload/user_images/'. $data->profile_photo_path);
           unlink($imageul);

            $name_gen = date('YmdHi').$image->getClientOriginalName();
            $image->move(public_path('upload/user_images'), $name_gen);

             User::find(Auth::user()->id)->update([
                'name' => $req->name,
                'email'=> $req->email,
                'phone' =>$req->phone,
                'profile_photo_path' =>$name_gen
            ]);


        }
        else {
            User::find(Auth::user()->id)->update([
                'name' => $req->name,
                'email'=> $req->email,
                'phone' =>$req->phone,
                ]);

        }

        $notification = array(
            'message' => 'User profile Updated successfully',
            'alert-type' => 'success'

        );
        return redirect()->route('dashboard')->with($notification);
     }// End Method

      public function userChangePassword()
     {
        $id = Auth::user()->id;
        $user = User::find($id);
      return view('frontend.profile.change_password', compact('user'));

     }// End MEthod

      public function userUpdatePassword(Request $req)
     {
        $validateData = $req->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ]);
        $hashedpassword = User::find(Auth::user()->id)->password;

        if (Hash::check($req->oldpassword,$hashedpassword)){

            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($req->password);
            $user->save();
            Auth::logout();
            return redirect()->route('user.logout');
        }else{
            return redirect()->back();
        }
     }// End MEthod

     public function ProductDetails($id , $slug){
           $multiImg = MultiImage::where('product_id',$id)->get();
           $product = Product::findOrFail($id);
           $cat_id = $product->product_category_id;

           $color_en = $product->product_color_en;
           $product_color_en = explode(',',$color_en);

           $color_hin = $product->product_color_hin;
           $product_color_hin = explode(',',$color_hin);

           $size_en = $product->product_size_en;
           $product_size_en = explode(',',$size_en);

           $size_hin = $product->product_size_hin;
           $product_size_hin = explode(',',$size_hin);

           $related_product = Product::where('category_id',$cat_id)->orderBy('id','DESC')->get();

           return view('frontend.product.product_details',compact('product','multiImg','product_color_en','product_color_hin','product_size_en','product_size_hin','related_product'));

     }// End Method

     public function tagWiseProduct($tag){
        $products = Product::where('status',1)->where('product_tags_en',$tag)->where('product_tags_hin',$tag)->orderBy('id','DESC')->get();
        return view('frontend.tags_view',compact('products'));


     }// End Method

     // Product view with Modal

     public function productViewAjax($id){

        $product = Product::with('category','brand')->findOrFail($id);
        $color = $product->product_color_en;
           $product_color_en = explode(',',$color);

           $size = $product->product_size_en;
           $product_size_en = explode(',',$size);


           return response()->json(array(
               'product' =>$product,
               'color' => $product_color_en,
               'size'   => $product_size_en,


           ));
     }// End Method
}
