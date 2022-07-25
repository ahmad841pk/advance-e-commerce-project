<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index()
    {
       return view('frontend.index');
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
}
