<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use App\Models\Supplier;
use App\Models\Product;

class SupplierController extends Controller
{

    protected $activityLogger;

    // Inject the ActivityLogger service through the constructor
    public function __construct(ActivityLogger $activityLogger)
    {
        $this->activityLogger = $activityLogger;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.supplier.dashboard', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/', 'unique:suppliers,supplier_name'], // Ensure it contains only letters and spaces
            'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z\.\-_]+@[a-zA-Z\.\-_]+\.[a-zA-Z]{2,}$/'], // Standard email format
            'phone_number' => ['required', 'string', 'max:20', 'regex:/^[0-9\s\-\(\)]+$/'], // Allow digits, spaces, dashes, and parentheses
            'address' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s,\.\-]+$/'], // Allow alphanumeric characters, spaces, commas, periods, and dashes
        ], [
            'supplier_name.regex' => 'The supplier name may only contain letters and spaces.',
            'supplier_name.unique' => 'The supplier name has already been taken.',
            'phone_number.regex' => 'The phone number must be in a valid format.',
            'address.regex' => 'The address may only contain letters, numbers, spaces, commas, periods, and dashes.',
        ]);

        $supplier = Supplier::create([
            'supplier_name' => $request->supplier_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        $this->activityLogger->logCreate('supplier', ['supplier_name' => $supplier->supplier_name]);

        return redirect()->route('admin.supplier.dashboard')->with('success', 'Supplier created successfully.');
    }

    public function getProductsBySupplier($supplierId)
    {
        $products = Product::where('supplier_id', $supplierId)->get();
        return response()->json($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($supplier_id)
    {
        $supplier = Supplier::findOrFail($supplier_id);
        return view('admin.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $supplier_id)
    {
        $request->validate([
            'supplier_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Ensure it contains only letters and spaces
            'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z\.\-_]+@[a-zA-Z\.\-_]+\.[a-zA-Z]{2,}$/'], // Standard email format
            'phone_number' => ['required', 'string', 'max:20', 'regex:/^[0-9\s\-\(\)]+$/'], // Allow digits, spaces, dashes, and parentheses
            'address' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s,\.\-]+$/'], // Allow alphanumeric characters, spaces, commas, periods, and dashes
        ], [
            'supplier_name.regex' => 'The supplier name may only contain letters and spaces.',
            'phone_number.regex' => 'The phone number must be in a valid format.',
            'address.regex' => 'The address may only contain letters, numbers, spaces, commas, periods, and dashes.',
        ]);

        $supplier = Supplier::findOrFail($supplier_id);
        $oldData = $supplier->toArray();

        $supplier->update([
            'supplier_name' => $request->supplier_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        $this->activityLogger->logUpdate('supplier', [
            'before' => $oldData,
            'after' => $supplier->toArray(),
        ]);

        return redirect()->route('admin.supplier.dashboard')->with('success', 'Supplier updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($supplier_id)
    {
        $supplier = Supplier::findOrFail($supplier_id);
        $supplierName = $supplier->supplier_name;
        $supplier->delete();

        $this->activityLogger->logDelete('supplier', [
            'supplier_name' => $supplierName,
        ]);

        return redirect()->route('admin.supplier.dashboard')->with('success', 'Supplier deleted successfully.');
    }
}
