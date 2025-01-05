<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Product;
use App\Models\DiscountProduct;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productDiscounts = DiscountProduct::with(['product', 'discount'])->get();
        $products = Product::all();
        $discounts = Discount::all();
        return view('admin.product_discount.dashboard', compact('productDiscounts', 'products', 'discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'discount_amount' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ], [
            'discount_amount.required' => 'The discount amount is required.',
            'discount_amount.integer' => 'The discount amount must be a whole number.',
            'discount_amount.between' => 'The discount amount must be between 1 and 100.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $discount = new Discount();
        $discount->event_name = $request->event_name;
        $discount->discount_amount = $request->discount_amount;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->save();

        return redirect()->route('admin.product_discount.dashboard')->with('success', 'Discount event created successfully.');
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
    public function update(Request $request, string $discount_id)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'discount_amount' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ], [
            'discount_amount.required' => 'The discount amount is required.',
            'discount_amount.integer' => 'The discount amount must be a whole number.',
            'discount_amount.between' => 'The discount amount must be between 1 and 100.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $discount = Discount::findOrFail($discount_id);
        $discount->event_name = $request->event_name;
        $discount->discount_amount = $request->discount_amount;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->save();

        return redirect()->route('admin.product_discount.dashboard')->with('success', 'Discount event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $discount_id)
    {
        $discount = Discount::findOrFail($discount_id);
        $discount->delete();

        return redirect()->route('admin.product_discount.dashboard')->with('success', 'Discount event deleted successfully.');
    }
}
