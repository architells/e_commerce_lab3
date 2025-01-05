@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Brands</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end align-items-center">
                    <!-- Additional controls can go here -->
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
                            <h3 class="card-title">Brand Table</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0" style="height: 500px;">
                            <table class="table table-head-fixed text-nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Brand ID</th>
                                        <th>Brand Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brands as $brand)
                                    <tr>
                                        <td>{{ $brand->brand_id }}</td>
                                        <td>{{ $brand->brand_name }}</td>
                                        <td>
                                            <a href="{{ route('admin.brand.edit', $brand->brand_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admin.brand.destroy', $brand->brand_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                            </form>
                                            <button class="btn btn-info btn-sm show-products-btn" data-brand-id="{{ $brand->brand_id }}">Show Products</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <!-- Products Table -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Products Table</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 500px;">
                            <table class="table table-head-fixed text-nowrap table-bordered table-hover" id="products-table">
                                <thead>
                                    <tr>
                                        <th>Product_id</th>
                                        <th>Product_name</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Products will be dynamically inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showProductsButtons = document.querySelectorAll('.show-products-btn');
        const productsTableBody = document.querySelector('#products-table tbody');

        showProductsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const brandId = this.getAttribute('data-brand-id');

                fetch(`/products/brand/${brandId}`)
                    .then(response => response.json())
                    .then(products => {
                        productsTableBody.innerHTML = ''; // Clear previous products
                        products.forEach(product => {
                            const newRow = document.createElement('tr');
                            newRow.innerHTML = `
                                <td>${product.product_id}</td>
                                <td>${product.product_name}</td>
                                <td>₱${product.price}</td>
                            `;
                            productsTableBody.appendChild(newRow);
                        });
                    })
                    .catch(error => console.error('Error fetching products:', error));
            });
        });
    });
</script>
@endsection