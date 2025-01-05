@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Discount Products</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDiscountModal">
                        Add Discount Event
                    </button>
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

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <!-- Card Body -->
                        <div class="card-header">
                            <h3 class="card-title">Discount Events Table</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 1100px;">
                            <table class="table table-head-fixed text-nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Discount Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th> <!-- New column -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($discounts as $discount)
                                    <tr>
                                        <td>{{ $discount->event_name }}</td>
                                        <td>{{ $discount->discount_amount }}%</td>
                                        <td>{{ $discount->start_date->format('Y-m-d') }}</td>
                                        <td>{{ $discount->end_date->format('Y-m-d') }}</td>
                                        <td>
                                            <!-- Display status -->
                                            <span class="badge 
                                    @if($discount->getDiscountStatusAttribute() == 'Ongoing') 
                                        badge-success 
                                    @elseif($discount->getDiscountStatusAttribute() == 'Upcoming') 
                                        badge-info 
                                    @else 
                                        badge-danger 
                                    @endif">
                                                {{ $discount->getDiscountStatusAttribute() }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editDiscountModal{{ $discount->discount_id }}">Edit</button>
                                            <form action="{{ route('admin.discounts.destroy', $discount->discount_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this discount event?')">Delete</button>
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


            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <!-- Card Body -->
                        <div class="card-header">
                            <h3 class="card-title">Apply Discounts to Products</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applyDiscountModal">
                                    Apply Discount
                                </button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 1100px;">
                            <table class="table table-head-fixed text-nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Discount Event</th>
                                        <th>Discount Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productDiscounts as $productDiscount)
                                    <tr>
                                        <td>{{ $productDiscount->product->product_name }}</td>
                                        <td>{{ $productDiscount->discount->event_name }}</td>
                                        <td>{{ $productDiscount->discount->discount_amount }}%</td>
                                        <td>
                                            <form action="{{ route('admin.product_discounts.destroy', $productDiscount->discount_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this discount from the product?')">Remove</button>
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

<!-- Add Discount Modal -->
<div class="modal fade" id="addDiscountModal" tabindex="-1" role="dialog" aria-labelledby="addDiscountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDiscountModalLabel">Add Discount Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('discount.store') }}" method="POST">
                    @csrf
                    <!-- Event Name -->
                    <div class="form-group">
                        <label for="eventName">Event Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('event_name') is-invalid @enderror" id="eventName" name="event_name" value="{{ old('event_name') }}">
                        @error('event_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Discount Amount -->
                    <div class="form-group">
                        <label for="discountAmount">Discount Amount <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('discount_amount') is-invalid @enderror" id="discountAmount" name="discount_amount" value="{{ old('discount_amount') }}">
                        @error('discount_amount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Start Date -->
                    <div class="form-group">
                        <label for="startDate">Start Date <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" id="startDate" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div class="form-group">
                        <label for="endDate">End Date <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="endDate" name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Add Discount</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Discount Modal -->
@foreach($discounts as $discount)
<div class="modal fade" id="editDiscountModal{{ $discount->discount_id }}" tabindex="-1" role="dialog" aria-labelledby="editDiscountModalLabel{{ $discount->discount_id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDiscountModalLabel{{ $discount->discount_id }}">Edit Discount Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.discounts.update', $discount->discount_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="eventName{{ $discount->discount_id }}">Event Name</label>
                        <input type="text" class="form-control" id="eventName{{ $discount->discount_id }}" name="event_name" value="{{ $discount->event_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="discountAmount{{ $discount->discount_id }}">Discount Amount</label>
                        <input type="number" class="form-control" id="discountAmount{{ $discount->discount_id }}" name="discount_amount" value="{{ $discount->discount_amount }}" required>
                    </div>
                    <div class="form-group">
                        <label for="startDate{{ $discount->discount_id }}">Start Date</label>
                        <input type="datetime-local" class="form-control" id="startDate{{ $discount->discount_id }}" name="start_date" value="{{ $discount->start_date }}" required>
                    </div>
                    <div class="form-group">
                        <label for="endDate{{ $discount->discount_id }}">End Date</label>
                        <input type="datetime-local" class="form-control" id="endDate{{ $discount->discount_id }}" name="end_date" value="{{ $discount->end_date }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Discount</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Apply Discount Modal -->
<div class="modal fade" id="applyDiscountModal" tabindex="-1" role="dialog" aria-labelledby="applyDiscountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyDiscountModalLabel">Apply Discount to Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.product_discounts.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="productId">Product</label>
                        <select class="form-control" id="productId" name="product_id" required>
                            @foreach($products as $product)
                            <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discountId">Discount Event</label>
                        <select class="form-control" id="discountId" name="discount_id" required>
                            @foreach($discounts as $discount)
                            <option value="{{ $discount->discount_id }}">{{ $discount->event_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Discount</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection