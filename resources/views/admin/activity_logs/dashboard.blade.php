@extends('Admin.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Activity Logs</h1>
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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <!-- Card Body -->
                        <div class="card-header">
                            <h3 class="card-title">Activity Logs Table</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 800px;">
                            <table class="table table-head-fixed text-nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Model</th>
                                        <th>User Name</th>
                                        <th>Action</th>
                                        <th>Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $log->model }}</td>
                                        <td>{{ $log->user_name }}</td>
                                        <td>
                                            @if ($log->action == 'create')
                                            <span class="badge bg-success">Created</span>
                                            @elseif ($log->action == 'update')
                                            <span class="badge bg-warning">Updated</span>
                                            @elseif ($log->action == 'delete')
                                            <span class="badge bg-danger">Deleted</span>
                                            @else
                                            {{ ucfirst($log->action) }}
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                            $action = ucfirst($log->action); // Action (e.g., Created, Updated, Deleted)
                                            $model = $log->model ?? 'record'; // Model name
                                            $timestamp = $log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('m/d/Y h:i A') : null; // Format date and time
                                            $details = json_decode($log->data, true); // Decode the JSON data

                                            // Extract relevant details based on the model
                                            switch ($model) {
                                            case 'brand':
                                            $name = $details['brand_name'] ?? 'No brand name found';
                                            break;
                                            case 'category':
                                            $name = $details['category_name'] ?? 'No category name found';
                                            break;
                                            case 'product':
                                            $name = $details['product_name'] ?? 'No product name found';
                                            break;
                                            case 'sub_category':
                                            $name = $details['after']['sub_category_name'] ?? 'No sub category name found';
                                            break;
                                            case 'sub_sub_category':
                                            $name = $details['after']['sub_sub_category_name'] ?? 'No sub sub category name found';
                                            break;
                                            case 'supplier':
                                            $name = $details['supplier_name'] ?? 'No supplier name found';
                                            break;
                                            case 'product_stocks':
                                            $name = $details['product_name'] ?? 'No product name found';
                                            $oldStock = $details['old_stock'] ?? null;
                                            $newStock = $details['new_stock'] ?? null;
                                            break;
                                            default:
                                            $name = 'No name found';
                                            break;
                                            }
                                            @endphp

                                            @if ($timestamp)
                                            @if ($model === 'product_stocks' && isset($oldStock) && isset($newStock))
                                            The stock for the product ({{ $name }}) was updated from {{ $oldStock }} to {{ $newStock }} on {{ $timestamp }}.
                                            @else
                                            This {{ strtolower($model) }} ({{ $name }}) was {{ strtolower($action) }} on {{ $timestamp }}.
                                            @endif
                                            @else
                                            No activity details available.
                                            @endif
                                        </td>

                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
</div>
</section>
<!-- /.content -->
</div>
@endsection