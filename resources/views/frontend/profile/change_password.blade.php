@extends('frontend.main_master')
@section('index')
    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-2"><br>
                    <img src="{{ !empty($user->profile_photo_path) ? url('upload/user_images/' . $user->profile_photo_path) : url('upload/no_image.jpg') }}"
                        height="100%" width="100%" style="border-radius: 50%;" class="card-img-top">
                    <ul class="list-group list-group-flush"><br>
                        <a href="{{ route('dashboard') }}"class="btn btn-primary btn-sm btn-block">Home</a>
                        <a href="{{ route('user.profile') }}"class="btn btn-primary btn-sm btn-block">Profile Update</a>
                        <a href="{{ route('change.password') }}"class="btn btn-primary btn-sm btn-block">Change Password</a>
                        <a href="{{ route('user.logout') }}"class="btn btn-danger btn-sm btn-block">Logout</a>
                    </ul>

                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h3 class="text-center"><span class="text-danger">Hi.....</span><strong>{{ Auth::user()->name }}</strong> Update Your Password
                        </h3>
                        <div class="card-body">
                           <form action="{{route('user.password.update') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Current Password <span>*</span></label>
                                <input type="password" id="current_password"  class="form-control" name="oldpassword">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">New Password <span>*</span></label>
                                <input type="password"  class="form-control" name="password" id="password" >
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Confirm New password <span>*</span></label>
                                <input type="password"  id="password_confirmation" class="form-control" name="password_confirmation" >
                            </div>

                            <div class="form-group">
                                 <button type="submit">Update Profile</button>
                            </div>
                           </form>

                        </div>
                    </div>

                </div>
            </div>
            {{-- End Of Row --}}
        </div>
    </div>
@endsection
