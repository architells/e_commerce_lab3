<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;
use App\Models\DiscountProduct;

class ProductDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productDiscounts = DiscountProduct::with(['product', 'discount'])->get();
        $products = Product::all();
        $discounts = Discount::all();
        return view('admin.product_discount.dashbaord', compact('productDiscounts', 'products', 'discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $discounts = Discount::all();
        return view('admin.product_discounts.create', compact('products', 'discounts'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'discount_id' => 'required|exists:discounts,discount_id',
        ]);

        // Find the discount
        $discount = Discount::find($request->discount_id);

        // Check if the discount exists
        if (!$discount) {
            return redirect()->back()->with('error', 'Discount not found.');
        }

        // Check if the discount has expired
        if ($discount->end_date < now()) {
            return redirect()->back()->with('error', 'Discount has expired.');
        }

        // Store the discount-product relation
        DiscountProduct::create($request->all());

        // Add a success message even for upcoming discounts
        if ($discount->start_date > now()) {
            return redirect()->route('admin.product_discount.dashboard')->with('success', 'Discount will start in the future and is successfully applied.');
        }

        return redirect()->route('admin.product_discount.dashboard')->with('success', 'Discount applied successfully.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the discount product record
        $discountProduct = DiscountProduct::where('discount_id', $id)->first();

        if ($discountProduct) {
            // Delete the record
            $discountProduct->delete();

            return redirect()->route('admin.product_discount.dashboard')->with('success', 'Discount removed successfully.');
        }

        return redirect()->route('admin.product_discount.dashboard')->with('error', 'Discount not found.');
    }
}
