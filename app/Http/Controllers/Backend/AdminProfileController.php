<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\Concerns\Has;
use Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public  function adminProfile(){

        $adminData = Admin::find(1);

        return view('admin.admin_profile_view' , compact('adminData'));

    }// End Method

    public function adminProfileEdit(){

        $editData = Admin::find(1);

        return view('admin.admin_profile_edit' , compact('editData'));

    }//End Method

    public function adminProfileUpdate(Request $req){
        $data = Admin::find(1);
        if($req->file('profile_photo_path')){
            $image = $req->file('profile_photo_path');
            $imageul = public_path('upload/admin_images/'. $data->profile_photo_path);
            unlink($imageul);

            $name_gen = date('YmdHi').$image->getClientOriginalName();
            $image->move(public_path('upload/admin_images'), $name_gen);

             Admin::findOrFail(1)->update([
                'name' => $req->name,
                'email'=> $req->email,
                'profile_photo_path' =>$name_gen
            ]);


        }
        else {
            Admin::findOrFail(1)->update([
                'name' => $req->name,
                'email'=> $req->email,
                ]);

        }

        $notification = array(
            'message' => 'Admin profile Updated successfully',
            'alert-type' => 'success'

        );
        return redirect()->route('admin.profile')->with($notification);

    }// End Method

    public function adminChangePassword(){

        return view('admin.admin_change_password');
    }

    public function adminUpdatePassword(Request $req){
        $validateData = $req->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ]);
        $hashedpassword = Admin::find(1)->password;

        if (Hash::check($req->oldpassword,$hashedpassword)){

            $admin = Admin::find(1);
            $admin->password = Hash::make($req->password);
            $admin->save();
            Auth::logout();
            return redirect()->route('admin.logout');
        }else{
            return redirect()->back();
        }

    }// End Method
}
