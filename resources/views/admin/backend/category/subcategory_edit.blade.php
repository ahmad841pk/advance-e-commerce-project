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
                            <h3 class="box-title">Edit SubCategory</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <form method="POST" action="{{route('subcategory.update')}}" >
                                    @csrf
                                    <input type="hidden" name="id" value="$subcategory->id">

                                    <div class="form-group">
                                        <h5>Caegory Select <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="category_id"  class="form-control">
                                                <option value="" selected="" disabled="">Select Category</option>
                                                @foreach ($category as $sub )

                                                <option value="{{$sub->id}}" {{ ($sub->id == $subcategory->category_id)? "selected": "" }}>{{ $sub->category_name_en }}</option>

                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>SubCategory Name English <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="subcategory_name_en" class="form-control"  value="{{ $subcategory->subcategory_name_en}}"> <div class="help-block"></div></div>
                                        @error('subcategory_name_en')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <h5>SubCategory Name Hindi <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="subcategory_name_hin" class="form-control"  value="{{ $subcategory->subcategory_name_hin }}"> <div class="help-block"></div></div>
                                        @error('subcategory_name_hin')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div class="text-xs-right">
                                        <input type="submit" class="btn btn-rounded btn-primary" value="Update">
                                    </div>
                               </form>

                            </div>



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
