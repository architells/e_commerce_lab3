@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Stocks Out</h1>
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
                            <form action="{{ route('stocks.update', $product->product_id) }}" method="POST">
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
                                
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="stock">Stock Out <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}">

                                    @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Stock Out</button>
                                <a href="{{ route('admin.stocks.dashboard') }}" class="btn btn-secondary">Cancel</a>
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