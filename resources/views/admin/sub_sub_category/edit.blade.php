@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sub-SubCategory</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <!-- Card Header -->
                        <div class="card-header">
                            <h3 class="card-title">Sub-SubCategory Information</h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- Card Body -->
                        <div class="card-body">
                            <form action="{{ route('sub_sub_category.update', $subSubCategory->sub_sub_category_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="sub_category_id">Sub Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('sub_category_id') is-invalid @enderror" id="sub_category_id" name="sub_category_id">
                                        <option value="">Select a sub category</option>
                                        @foreach($subCategories as $subCategory)
                                        <option value="{{ $subCategory->sub_category_id }}" {{ $subSubCategory->sub_category_id == $subCategory->sub_category_id ? 'selected' : '' }}>{{ $subCategory->sub_category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="sub_sub_category_name">Sub-SubCategory Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('sub_sub_category_name') is-invalid @enderror" id="sub_sub_category_name" name="sub_sub_category_name" placeholder="Enter Sub-SubCategory Name" value="{{ old('sub_sub_category_name', $subSubCategory->sub_sub_category_name) }}">
                                    @error('sub_sub_category_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update Sub-SubCategory</button>
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
