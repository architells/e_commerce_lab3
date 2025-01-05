@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Categories</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end align-items-center">
                    <div class="btn-group">
                        <button id="show-categories-btn" class="btn btn-primary">Categories</button>
                        <button id="show-subcategories-btn" class="btn btn-primary">Subcategories</button>
                        <button id="show-sub-subcategories-btn" class="btn btn-primary">Sub-Subcategories</button>
                    </div>
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
                    <!-- Main Category Table -->
                    <div class="card" id="main-category-table">
                        <!-- Card Body -->
                        <div class="card-header">
                            <h3 class="card-title">Categories Table</h3>

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
                                        <th>Category ID</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr class="category-row" data-category-id="{{ $category->category_id }}">
                                        <td>{{ $category->category_id }}</td>
                                        <td>{{ $category->category_name }}</td>
                                        <td>
                                            <a href="{{ route('admin.category.edit', $category->category_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admin.category.destroy', $category->category_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                            </form>
                                            <button type="button" class="btn btn-info btn-sm show-products-btn" data-category-id="{{ $category->category_id }}">Show Products</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Subcategory Table -->
                    <div class="card" id="subcategory-table" style="display: none;">
                        <!-- Card Body -->
                        <div class="card-header">
                            <h3 class="card-title">Subcategories Table</h3>

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
                                        <th>Subcategory ID</th>
                                        <th>Subcategory Name</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subCategories as $subCategory)
                                    <tr class="subcategory-row" data-subcategory-id="{{ $subCategory->sub_category_id }}">
                                        <td>{{ $subCategory->sub_category_id }}</td>
                                        <td>{{ $subCategory->sub_category_name }}</td>
                                        <td>{{ $subCategory->category->category_name }}</td>
                                        <td>
                                            <a href="{{ route('sub_category.edit', $subCategory->sub_category_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('sub_category.destroy', $subCategory->sub_category_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subcategory?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Sub-Subcategory Table -->
                    <div class="card" id="sub-subcategory-table" style="display: none;">
                        <!-- Card Body -->
                        <div class="card-header">
                            <h3 class="card-title">Sub-Subcategories Table</h3>

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
                                        <th>Sub-Subcategory ID</th>
                                        <th>Sub-Subcategory Name</th>
                                        <th>Subcategory Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subSubCategories as $subSubCategory)
                                    <tr class="sub-subcategory-row" data-sub-subcategory-id="{{ $subSubCategory->sub_sub_category_id }}">
                                        <td>{{ $subSubCategory->sub_sub_category_id }}</td>
                                        <td>{{ $subSubCategory->sub_sub_category_name }}</td>
                                        <td>{{ $subSubCategory->subcategory->sub_category_name }}</td>
                                        <td>
                                            <a href="{{ route('sub_subcategory.edit', $subSubCategory->sub_sub_category_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('sub_subcategory.destroy', $subSubCategory->sub_sub_category_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this sub-subcategory?')">Delete</button>
                                            </form>
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
        const showCategoriesBtn = document.getElementById('show-categories-btn');
        const showSubcategoriesBtn = document.getElementById('show-subcategories-btn');
        const showSubSubcategoriesBtn = document.getElementById('show-sub-subcategories-btn');
        const mainCategoryTable = document.getElementById('main-category-table');
        const subcategoryTable = document.getElementById('subcategory-table');
        const subSubcategoryTable = document.getElementById('sub-subcategory-table');

        showCategoriesBtn.addEventListener('click', function() {
            mainCategoryTable.style.display = 'block';
            subcategoryTable.style.display = 'none';
            subSubcategoryTable.style.display = 'none';
        });

        showSubcategoriesBtn.addEventListener('click', function() {
            mainCategoryTable.style.display = 'none';
            subcategoryTable.style.display = 'block';
            subSubcategoryTable.style.display = 'none';
        });

        showSubSubcategoriesBtn.addEventListener('click', function() {
            mainCategoryTable.style.display = 'none';
            subcategoryTable.style.display = 'none';
            subSubcategoryTable.style.display = 'block';
        });

        const showProductsButtons = document.querySelectorAll('.show-products-btn');
        const productsTableBody = document.querySelector('#products-table tbody');

        showProductsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category-id');
                const subcategoryId = this.getAttribute('data-subcategory-id');
                const subSubcategoryId = this.getAttribute('data-sub-subcategory-id');

                let url;
                if (categoryId) {
                    url = `/products/category/${categoryId}`;
                } else if (subcategoryId) {
                    url = `/products/subcategory/${subcategoryId}`;
                } else if (subSubcategoryId) {
                    url = `/products/sub-subcategory/${subSubcategoryId}`;
                }

                fetch(url)
                    .then(response => response.json())
                    .then(products => {
                        productsTableBody.innerHTML = '';
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
