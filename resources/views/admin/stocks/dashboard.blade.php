@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Stocks</h1>
                </div>
            </div>
        </div>
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

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">In Stock Products</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 500px;">
                            <table class="table table-head-fixed text-nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Dimension</th>
                                        <th>Stock Unit</th>
                                        <th>Stocks</th>
                                        <th>Stocks Level</th>
                                        <th>Date Manufactured</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    @if($product->stock && $product->stock->quantity > 0)
                                    <tr>
                                        <td>{{ $product->product_id }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->dimension }}</td>
                                        <td>{{ $product->stock_unit }}</td>
                                        <td>{{ $product->stock->quantity }}</td>
                                        <td>{{ $product->getStockLevel() }}</td>
                                        <td>{{ $product->date_manufactured }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#stockInModal" data-product-id="{{ $product->product_id }}" data-product-name="{{ $product->product_name }}" data-stock-unit="{{ $product->stock_unit }}" data-initial-stock="{{ $product->stock->quantity }}">
                                                Stock In
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#stockOutModal" data-product-id="{{ $product->product_id }}" data-product-name="{{ $product->product_name }}" data-stock-unit="{{ $product->stock_unit }}">
                                                Stock Out
                                            </button>
                                            <a href="{{ route('admin.stocks.stocks_history', ['productId' => $product->product_id]) }}" class="btn btn-info btn-sm">
                                                History
                                            </a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Zero Stock Products</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 500px;">
                            @if($zeroStockProducts->isEmpty())
                            <div class="alert alert-info">
                                No zero stock products available.
                            </div>
                            @else
                            <table class="table table-head-fixed text-nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Stocks</th>
                                        <th>Stocks Level</th>
                                        <th>Date Manufactured</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($zeroStockProducts as $product)
                                    <tr>
                                        <td>{{ $product->product_id }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->stock ? $product->stock->quantity : 0 }}</td>
                                        <td>{{ $product->getStockLevel() }}</td>
                                        <td>{{ $product->date_manufactured }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#stockInModal" data-product-id="{{ $product->product_id }}" data-product-name="{{ $product->product_name }}" data-stock-unit="{{ $product->stock_unit }}" data-initial-stock="{{ $product->stock ? $product->stock->quantity : 0 }}">
                                                Stock In
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#stockHistoryModal" data-product-id="{{ $product->product_id }}" data-product-name="{{ $product->product_name }}">
                                                History
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="stockInModal" tabindex="-1" role="dialog" aria-labelledby="stockInModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockInModalLabel">Stock In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="stockInForm" action="{{ route('stocks.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="stockInProductId" name="product_id" value="{{ isset($product) && $product ? $product->product_id : 'null' }}">
                    <div class="form-group">
                        <label for="stockInProductName">Product Name</label>
                        <input type="text" class="form-control" id="stockInProductName" value="{{ $product->product_name ?? 'No product name available' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="initialStock">Current Stock</label>
                        <input type="number" class="form-control" id="initialStock" value="{{ $product->stock->quantity ?? 0 }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="stockInUnit">Stock Unit</label>
                        <select class="form-control" id="stockInUnit" name="stock_unit" required>
                            <option value="piece">Piece</option>
                            <option value="box">Box</option>
                            <option value="dozen">Dozen</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stockInQuantity">Add Quantity</label>
                        <input type="number" class="form-control" id="stockInQuantity" name="stockInQuantity" required min="1">
                    </div>
                    <button type="submit" class="btn btn-primary">Stock In</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="stockOutModal" tabindex="-1" role="dialog" aria-labelledby="stockOutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockOutModalLabel">Stock Out</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="stockOutForm" method="POST" action="{{ route('admin.stocks.update', $product->product_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="stockOutProductId" name="product_id" value="{{ $product->product_id}}">
                    <input type="hidden" id="stockOutStockUnit" name="stock_unit">
                    <div class="form-group">
                        <label for="stockOutProductName">Product Name</label>
                        <input type="text" class="form-control" id="stockOutProductName" value="{{ $product->product_name ?? 'No Product Name' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="currentStock">Current Stock</label>
                        <input type="number" class="form-control" id="currentStock" value="{{ $product->stock->quantity ?? 0 }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="stockOutQuantity">Quantity to Remove</label>
                        <input type="number" class="form-control" id="stockOutQuantity" name="stockOutQuantity" required min="1">
                    </div>
                    <button type="submit" class="btn btn-primary">Stock Out</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $('#stockInModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal

        // Extract info from data-* attributes
        var productId = button.data('product-id');
        var productName = button.data('product-name');
        var initialStock = button.data('initial-stock');
        var stockUnit = button.data('stock-unit');

        // Update modal fields
        var modal = $(this);
        modal.find('#stockInProductId').val(productId);
        modal.find('#stockInProductName').val(productName);
        modal.find('#initialStock').val(initialStock);
        modal.find('#stockInUnit').val(stockUnit);
    });

    $('#stockOutModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var actionUrl = button.data('action'); // Get the action URL
        var productId = button.data('product-id'); // Get the product ID
        var productName = button.data('product-name'); // Get the product name
        var stockUnit = button.data('stock-unit'); // Get the stock unit

        var modal = $(this);
        modal.find('#stockOutForm').attr('action', actionUrl); // Set form action URL
        modal.find('#stockOutProductId').val(productId); // Set product ID in hidden input
        modal.find('#stockOutStockUnit').val(stockUnit); // Set stock unit in hidden input
        modal.find('#stockOutProductName').val(productName); // Set product name
    });
</script>
@endsection