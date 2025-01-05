<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockHistory;

class StocksController extends Controller
{
    protected $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->activityLogger = $activityLogger;
    }

    public function index()
    {
        $products = Product::with('stock')->get(['product_id', 'product_name', 'dimension', 'stock_unit', 'date_manufactured']);
        $zeroStockProducts = Product::with('stock')->whereHas('stock', function ($query) {
            $query->where('quantity', 0);
        })->get(['product_id', 'product_name', 'date_manufactured']);

        return view('admin.stocks.dashboard', compact('products', 'zeroStockProducts'));
    }

    public function create()
    {
        return view('admin.stocks.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'stockInQuantity' => ['required', 'integer', 'min:1'],
            'stock_unit' => 'required|in:piece,dozen,box',
        ]);

        // Find the product by product_id
        $product = Product::findOrFail($validated['product_id']);

        // Find the existing stock record or create a new one
        $stock = Stock::firstOrNew(['product_id' => $product->product_id]);

        // Save the old quantity for logging
        $oldQuantity = $stock->quantity ?? 0;

        // Update the stock quantity and unit
        $stock->quantity = $oldQuantity + $validated['stockInQuantity'];
        $stock->stock_unit = $validated['stock_unit'];
        $stock->save();

        // Log the stock change in the stock history table
        StockHistory::create([
            'stock_id' => $stock->stock_id,
            'quantity_change' => $validated['stockInQuantity'],
            'action' => 'stock_in',
        ]);

        // Log the update activity for auditing purposes
        $this->activityLogger->logStockIn($product, $validated['stockInQuantity']);

        // Redirect back with a success message
        return redirect()->route('admin.stocks.dashboard')->with('success', 'Stock added successfully.');
    }




    public function edit($productId)
    {
        $product = Product::findOrFail($productId);
        return view('admin.stocks.edit', compact('product'));
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'stockOutQuantity' => ['required', 'integer', 'min:1'],
        ], [
            'stockOutQuantity.required' => 'The stock out quantity field is required.',
            'stockOutQuantity.integer' => 'The stock out quantity must be an integer.',
            'stockOutQuantity.min' => 'The stock out quantity must be a positive number.',
        ]);

        $product = Product::findOrFail($productId);

        // Find the existing stock record
        $stock = Stock::firstOrNew(['product_id' => $product->product_id]);

        // Store old quantity for logging
        $oldQuantity = $stock->quantity ?? 0;

        // Check if there's enough stock
        if ($request->stockOutQuantity > $oldQuantity) {
            return redirect()->back()->with('error', 'Insufficient stock.');
        }

        // Update the stock quantity
        $stock->quantity = $oldQuantity - $request->stockOutQuantity;
        $stock->save();

        // Log stock history for stock-out action
        StockHistory::create([
            'stock_id' => $stock->stock_id,
            'quantity_change' => -$request->stockOutQuantity,
            'action' => 'stock_out',
        ]);

        // Log activity
        $this->activityLogger->logStockOut($product, $request->stockOutQuantity);

        return redirect()->route('admin.stocks.dashboard')->with('success', 'Stock updated successfully.');
    }




    public function showStockHistory($productId)
    {
        $product = Product::findOrFail($productId);

        // Retrieve the stock history by filtering the stock table through the product_id
        $stockHistory = StockHistory::whereHas('stock', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })->get();

        return view('admin.stocks.stocks_history', compact('product', 'stockHistory'));
    }
}
