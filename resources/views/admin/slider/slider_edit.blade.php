@extends('admin.admin_master')
@section('index')
    <div class="container-full">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="row">


                <!-- /.col -->

                <div class="col-12">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Slider</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <form method="post" action="{{route('slider.update')}}"  enctype="multipart/form-data">
                                    @csrf

                                  <input type="hidden" name="id" value="{{$sliders->id}}">
                                  <input type="hidden" name="old_image" value="{{$sliders->slider_img}}">
                                    <div class="form-group">
                                        <h5>Slider Title <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="title" class="form-control"  value="{{$sliders->title}}"> <div class="help-block"></div></div>
                                        @error('brand_name_en')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                            </div>

                            <div class="form-group">
                                <h5>Slider Description <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="description" class="form-control"  value="{{$sliders->description}}"> <div class="help-block"></div></div>
                                @error('brand_name_hin')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>



                            <div class="form-group">
                                <h5>slider Image <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="file"  name="slider_img" class="form-control"  value=""> <div class="help-block"></div></div>
                                @error('brand_image')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>


                            <div class="text-xs-right">
                                <input type="submit" class="btn btn-rounded btn-primary" value="Update Slider">
                            </div>
                            </form>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                    <!-- /.box -->
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

    </div>
@endsection
