@extends('admin.admin_master')
@section('index')

    <div class="container-full">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="row">


                <!-- Edit Sub Sub Category -->

                <div class="col-12">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Sub Sub Category</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <form method="post" action="{{route('subsubcategory.update')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$subsubcategories->id}}">
                                    <div class="form-group">
                                        <h5>Caegory Select <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="category_id"  class="form-control">
                                                <option value="" selected="" disabled="">Select Category</option>
                                                @foreach ($category as $sub )

                                                        <option value="{{$sub->id}}" {{($sub->id == $subsubcategories->category_id)? 'selected':  ""}}>{{ $sub->category_name_en }}</option>

                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>SubCaegory Select <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="subcategory_id"  class="form-control">
                                                <option value="" selected="" disabled="">Select SubCategory</option>
                                                @foreach ($subcategory as $sub )

                                                    <option value="{{$sub->id}}" {{($sub->id == $subsubcategories->subcategory_id)? 'selected':  ""}}>{{ $sub->subcategory_name_en }}</option>

                                                @endforeach

                                            </select>
                                            @error('subcategory_id')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>sub Sub Category Name English <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="subsubcategory_name_en" class="form-control"  value="{{$subsubcategories->subsubcategory_name_en}}"> <div class="help-block"></div></div>
                                        @error('subsubcategory_name_en')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <h5>Sub sub Category Name Hindi <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="subsubcategory_name_hin" class="form-control"  value="{{$subsubcategories->subsubcategory_name_hin}}"> <div class="help-block"></div></div>
                                        @error('subsubcategory_name_hin')
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
