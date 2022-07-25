@extends('admin.admin_master')
@section('index')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <div class="container-full">

        <!-- Main content -->
        <section class="content">

            <!-- Basic Forms -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Admin Profile Edit</h4>
                    <h6 class="box-subtitle">Bootstrap Form Validation check the <a class="text-warning" href="http://reactiveraven.github.io/jqBootstrapValidation/">official website </a></h6>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form method="post" action="{{route('admin.profile.update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">

                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <h5>Admin Username <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="name" class="form-control" required="" value="{{$editData->name}}"> <div class="help-block"></div></div>
                                                </div>

                                            </div>
                                     {{--End col-md-6--}}




                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <h5>Admin Email <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="email" name="email" class="form-control" required="" value="{{$editData->email}}"> <div class="help-block"></div></div>
                                                </div>


                                            </div>
                                       {{--End col-md-6--}}

                                        </div>
                                   {{--  End row--}}

                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <h5>Profile Image<span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="file" id="image" name="profile_photo_path" class="form-control" required=""> <div class="help-block"></div></div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <img id="showimage" src="{{ !empty($adminData->profile_photo_path)
                        ? url('upload/admin_images/'.$adminData->profile_photo_path)
                        : url('upload/no_image.jpg') }}" style="height: 100px; width: 100px;">

                                            </div>

                                        </div>
                                        {{--  End row--}}







                                    </div>

                                </div>

                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-primary" value="Update">
                                </div>
                            </form>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>

    <script type="text/javascript">
           $(document).ready(function (){
               $('#image').change(function (e){
                   var reader = new FileReader();
                   reader.onload = function (e){
                       $('#showimage').attr('src',e.target.result);
                   }
                   reader.readAsDataURL(e.target.files['0']);
               });
           });

    </script>




@endsection
