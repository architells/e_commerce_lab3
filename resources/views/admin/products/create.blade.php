@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Product</h1>
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
                            <h3 class="card-title">Product Information</h3>
                        </div>
                        <!-- /.card-header -->
                        @if (session('success'))
                        <script>
                            Swal.fire({
                                title: 'Success',
                                icon: 'success',
                                text: "{{ session('success') }}",
                            });
                        </script>
                        @endif

                        <!-- Card Body -->
                        <div class="card-body">
                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="brand_id">Brand <span class="text-danger">*</span></label>
                                    <select class="form-control @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id">
                                        <option value="">Select a brand</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->brand_id }}" {{ old('brand_id') == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" placeholder="Enter Product Name" value="{{ old('product_name') }}">
                                    @error('product_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price">Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                                    @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="stock_unit">Stock Unit <span class="text-danger">*</span></label>
                                    <select class="form-control @error('stock_unit') is-invalid @enderror" id="stock_unit" name="stock_unit">
                                        <option value="">Select stock unit</option>
                                        <option value="piece" {{ old('stock_unit') == 'piece' ? 'selected' : '' }}>Piece</option>
                                        <option value="dozen" {{ old('stock_unit') == 'dozen' ? 'selected' : '' }}>Dozen</option>
                                        <option value="box" {{ old('stock_unit') == 'box' ? 'selected' : '' }}>Box</option>
                                    </select>
                                    @error('stock_unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group" id="stock_field" style="display: none;">
                                    <label for="stock">Stock <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}">
                                    @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="sub_category_id">Sub Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('sub_category_id') is-invalid @enderror" id="sub_category_id" name="sub_category_id">
                                        <option value="">Select a sub category</option>
                                        @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->sub_category_id }}" {{ old('sub_category_id') == $subcategory->sub_category_id ? 'selected' : '' }}>{{ $subcategory->sub_category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="sub_sub_category_id">Sub Sub Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('sub_sub_category_id') is-invalid @enderror" id="sub_sub_category_id" name="sub_sub_category_id">
                                        <option value="">Select a sub sub category</option>
                                        @foreach($subsubcategories as $subsubcategory)
                                        <option value="{{ $subsubcategory->sub_sub_category_id }}" {{ old('sub_sub_category_id') == $subsubcategory->sub_sub_category_id ? 'selected' : '' }}>{{ $subsubcategory->sub_sub_category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_sub_category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="skin_type">Skin Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('skin_type') is-invalid @enderror" id="skin_type" name="skin_type">
                                        <option value="">Select skin type</option>
                                        <option value="oily" {{ old('skin_type') == 'oily' ? 'selected' : '' }}>Oily</option>
                                        <option value="dry" {{ old('skin_type') == 'dry' ? 'selected' : '' }}>Dry</option>
                                        <option value="combination" {{ old('skin_type') == 'combination' ? 'selected' : '' }}>Combination</option>
                                        <option value="sensitive" {{ old('skin_type') == 'sensitive' ? 'selected' : '' }}>Sensitive</option>
                                        <option value="normal" {{ old('skin_type') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    </select>
                                    @error('skin_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="dimension">Dimension <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('dimension') is-invalid @enderror" id="dimension" name="dimension" placeholder="e.g., 2x2x2x3" value="{{ old('dimension') }}">
                                    @error('dimension')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="volume_unit">Volume Unit <span class="text-danger">*</span></label>
                                    <select class="form-control @error('volume_unit') is-invalid @enderror" id="volume_unit" name="volume_unit">
                                        <option value="">Select volume unit</option>
                                        <option value="ml" {{ old('volume_unit') == 'ml' ? 'selected' : '' }}>ml</option>
                                        <option value="grams" {{ old('volume_unit') == 'grams' ? 'selected' : '' }}>grams</option>
                                        <option value="liters" {{ old('volume_unit') == 'liters' ? 'selected' : '' }}>liters</option>
                                        <option value="kg" {{ old('volume_unit') == 'kg' ? 'selected' : '' }}>kg</option>
                                        <option value="oz" {{ old('volume_unit') == 'oz' ? 'selected' : '' }}>oz</option>
                                        <option value="fl oz" {{ old('volume_unit') == 'fl oz' ? 'selected' : '' }}>fl oz</option>
                                    </select>
                                    @error('volume_unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group" id="volume_field" style="display: none;">
                                    <label for="volume">Volume <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('volume') is-invalid @enderror" id="volume" name="volume" placeholder="e.g., 500" value="{{ old('volume') }}">
                                    @error('volume')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                                    <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id">
                                        <option value="">Select a supplier</option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier_id }}" {{ old('supplier_id') == $supplier->supplier_id ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image">Product Image <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                    @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="date_manufactured">Date Manufactured</label>
                                    <input type="text" class="form-control @error('date_manufactured') is-invalid @enderror" id="date_manufactured" name="date_manufactured" value="{{ old('date_manufactured') }}" placeholder="YYYY-MM-DD">
                                    @error('date_manufactured')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Product</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var stockUnitDropdown = document.getElementById('stock_unit');
        var volumeUnitDropdown = document.getElementById('volume_unit');

        stockUnitDropdown.addEventListener('change', function() {
            var stockField = document.getElementById('stock_field');
            if (this.value) {
                stockField.style.display = 'block';
            } else {
                stockField.style.display = 'none';
                stockField.value = '';
            }
        });

        volumeUnitDropdown.addEventListener('change', function() {
            var volumeField = document.getElementById('volume_field');
            if (this.value) {
                volumeField.style.display = 'block';
            } else {
                volumeField.style.display = 'none';
                volumeField.value = '';
            }
        });
    });
</script>