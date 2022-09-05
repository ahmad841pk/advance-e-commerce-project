@extends('admin.admin_master')
@section('index')
    <div class="container-full">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-8">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Category List</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Category Icon</th>
                                        <th>Category English</th>
                                        <th>Category Hindi</th>
                                        <th>Actions</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($category as $item)
                                        <tr>
                                            <td><span><i class ="{{$item->category_icon}}"></i></span></td>
                                            <td>{{$item->category_name_en}}</td>
                                            <td>{{$item->category_name_hin}} </td>
                                            <td>
                                                <a href="{{route('category.edit',$item->id)}}" class="btn btn-info" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a href="{{route('category.delete',$item->id)}}" class="btn btn-danger"  title="Delete" ><i class="fa fa-trash"></i></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <div class="col-4">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Category</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <form method="post" action="{{route('category.store')}}"  enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <h5>Category Name English <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="category_name_en" class="form-control"  value=""> <div class="help-block"></div></div>
                                        @error('category_name_en')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                            </div>

                            <div class="form-group">
                                <h5>Category Name Hindi <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="category_name_hin" class="form-control"  value=""> <div class="help-block"></div></div>
                                @error('category_name_hin')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <h5>Category Icon <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="category_icon" class="form-control"  value=""> <div class="help-block"></div></div>
                                @error('category_icon')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>


                            <div class="text-xs-right">
                                <input type="submit" class="btn btn-rounded btn-primary" value="Add New">
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
