<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActivityLogger; 
use App\Models\Brand;
use App\Models\Product;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->activityLogger = $activityLogger;
    }

    public function index()
    {
        $brands = Brand::all();
        return view('admin.brand.dashboard', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Ensure it contains only letters and spaces
        ], [
            'brand_name.regex' => 'The brand name may only contain letters and spaces.',
            // other custom messages
        ]);

        $brand = Brand::create(['brand_name' => $request->brand_name]);

        // Log the creation
        $this->activityLogger->logCreate('brand', $brand->toArray());

        return redirect()->route('admin.brand.dashboard')->with('success', 'Brand created successfully.');
    }

    public function getProductsByBrand($brandId)
    {
        $products = Product::where('brand_id', $brandId)->get();
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
    public function edit($brand_id)
    {
        $brand = Brand::findOrFail($brand_id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $brand_id)
    {
        $request->validate([
            'brand_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Ensure it contains only letters and spaces
        ], [
            'brand_name.regex' => 'The brand name may only contain letters and spaces.',
        ]);

        $brand = Brand::findOrFail($brand_id);

        $oldData = $brand->toArray();

        $brand->update([
            'brand_name' => $request->brand_name,
        ]);

        $this->activityLogger->logUpdate('brand', [
            'before' => $oldData,
            'after' => $brand->toArray(),
        ]);

        return redirect()->route('admin.brand.dashboard')->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($brand_id)
    {
        $brand = Brand::findOrFail($brand_id);
        $brandName = $brand->brand_name;
        $brand->delete();

        $this->activityLogger->logDelete('brand', [
            'brand_name' => $brandName,
        ]);

        return redirect()->route('admin.brand.dashboard')->with('success', 'Brand deleted successfully.');
    }
}
