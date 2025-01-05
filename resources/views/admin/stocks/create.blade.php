@extends('admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Stock</h1>
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
                        <!-- Card Body -->
                        <div class="card-body">
                            <form action="{{ route('stocks.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="product_id">Product</label>
                                    <select class="form-control" id="product_id" name="product_id" required>
                                        @foreach($products as $product)
                                        <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                                </div>
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <select class="form-control" id="unit" name="unit" required>
                                        <option value="piece">Piece</option>
                                        <option value="box">Box</option>
                                        <option value="dozen">Dozen</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Stock</button>
                            </form>
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