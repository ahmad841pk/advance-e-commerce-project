<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function SliderView(){
    $sliders = Slider::latest()->get();
    return view('admin.slider.slider_view', compact('sliders'));


    }// End Methods

    public function sliderStore(Request $req){
        $validateData = $req->validate([
             'slider_img' => 'required',
           ]);
        $image =$req->file('slider_img');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(870,370)->save('upload/slider/'.$name_gen);
        $save_url = 'upload/slider/'.$name_gen;
        Slider::insert([
            'title'=> $req->title,
            'description'=> $req->description,
            'slider_img'=> $save_url,
        ]);
          $notification = array(
              'message' => 'Slider Added successfully',
              'alert-type' => 'success'
          );


          return redirect()->back()->with($notification);
      }// End Method

      public function sliderEdit($id)
      {
        $sliders = Slider::findOrFail($id);
        return view('admin.slider.slider_edit', compact('sliders'));


      }// End Method

      public function sliderUpdate(Request $req){
        $id  = $req->id;
        $old_image = $req->old_image;
        if($req->file('slider_img')){
            unlink($old_image);
            $image =$req->file('slider_img');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(870,370)->save('upload/slider/'.$name_gen);
            $save_url = 'upload/slider/'.$name_gen;
            Slider::findOrFail($id)->Update([
                'title'=> $req->title,
                'description'=> $req->description,
                 'slider_img' => $save_url,
            ]);
            $notification = array(
                'message' => 'Slider Updated successfully with Image',
                'alert-type' => 'info'
            );


            return redirect()->route('manage.slider')->with($notification);
        }else{
            Slider::findOrFail($id)->Update([
                'title'=> $req->title,
                'description'=> $req->description,
            ]);
            $notification = array(
                'message' => 'Slider Updated successfully without Image',
                'alert-type' => 'info'
            );


            return redirect()->route('manage.slider')->with($notification);
        }


    }// End Method

    public function sliderDelete($id)
    {
        $slider = Slider::findOrfail($id);
        unlink($slider->slider_img);
        $slider->delete();

        $notification = array(
            'message' => 'Slider Deleted successfully',
            'alert-type' => 'info'
        );


        return redirect()->back()->with($notification);


    }// End Method
    public function sliderInactive($id)
     {
         Slider::findOrFail($id)->update([

            'status' => '0'
         ]);
         $notification = array(
            'message' => 'Slider Now Inactive',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);



     }// End Method

     public function sliderActive($id)
     {
        Slider::findOrFail($id)->update([

            'status' => '1'
         ]);
         $notification = array(
            'message' => 'Slider Now Active',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
     }// End Method
}
