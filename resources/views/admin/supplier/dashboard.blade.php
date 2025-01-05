@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Suppliers</h1>
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
                            <h3 class="card-title">Suppliers Table</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 500px;">
                            <table class="table table-head-fixed text-nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Supplier ID</th>
                                        <th>Supplier Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($suppliers as $supplier)
                                    <tr class="supplier-row" data-supplier-id="{{ $supplier->supplier_id }}">
                                        <td>{{ $supplier->supplier_id }}</td>
                                        <td>{{ $supplier->supplier_name }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->phone_number }}</td>
                                        <td>{{ $supplier->address }}</td>
                                        <td>
                                            <a href="{{ route('supplier.edit', $supplier->supplier_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('supplier.destroy', $supplier->supplier_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this supplier?')">Delete</button>
                                            </form>
                                            <button type="button" class="btn btn-info btn-sm show-products-btn" data-supplier-id="{{ $supplier->supplier_id }}">Show Products</button>
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
                                        <th>Product ID</th>
                                        <th>Product Name</th>
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
                const supplierId = this.getAttribute('data-supplier-id');
                console.log('Fetching products for supplier ID:', supplierId); // Debugging statement

                fetch(`/products/supplier/${supplierId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(products => {
                        console.log('Fetched products:', products); // Debugging statement
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