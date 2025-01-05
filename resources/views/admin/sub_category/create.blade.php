@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Sub Category</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end align-items-center">
                    <!-- Additional controls can go here -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <!-- Card Header -->
                        <div class="card-header">
                            <h3 class="card-title">Add New Sub Category</h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- Card Body -->
                        <div class="card-body">
                            <form action="{{ route('sub_category.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="sub_category_name">SubCategory Name <span class="text-danger">*</span></label>
                                    <input type="text" name="sub_category_name" class="form-control" value="{{ old('sub_category_name') }}" placeholder="Enter SubCategory Name">
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control" id="category_id">
                                        <option value="">Select a Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.category.dashboard') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection