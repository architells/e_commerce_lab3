@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products Information</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    @push('scripts')
    @if (session('success'))
    <script>
        Swal.fire({
            title: 'Success',
            icon: 'success',
            text: "{{ session('success') }}",
        });
    </script>
    @endif
    @endpush
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <!-- Card Body -->
                        <div class="card-header">
                            <h3 class="card-title">Products Table</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 1100px;">
                            <table class="table table-head-fixed text-nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Brand</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Sub Sub Category</th>
                                        <th>Supplier</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->product_id }}</td>
                                        <td>
                                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('path/to/default/image.jpg') }}" alt="{{ $product->product_name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->brand->brand_name ?? 'No Brand'}}</td>
                                        <td>₱{{ $product->price }}</td>
                                        <td>{{ $product->category ? $product->category->category_name : 'Uncategorized' }}</td>
                                        <td>{{ $product->subcategory ? $product->subcategory->sub_category_name : 'Uncategorized' }}</td>
                                        <td>{{ $product->subsubcategory ? $product->subsubcategory->sub_sub_category_name : 'Uncategorized' }}</td>
                                        <td>{{ $product->supplier ? $product->supplier->supplier_name : 'No Supplier' }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
