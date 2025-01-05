<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Stock;
use App\Models\StockHistory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $activityLogger;

    // Inject the ActivityLogger service through the constructor
    public function __construct(ActivityLogger $activityLogger)
    {
        $this->activityLogger = $activityLogger;
    }

    public function index()
    {
        $productsCount = Product::count();
        $products = Product::all();
        return view('admin.products.dashboard', compact('products', 'productsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $subsubcategories = SubSubCategory::all();
        $suppliers = Supplier::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'suppliers', 'brands', 'subcategories', 'subsubcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required',
            'product_name' =>  ['required', 'string', 'max:255', 'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\s]+$/'],
            'description' => 'nullable',
            'price' => ['required', 'regex:/^\d+(\.\d{2})?$/'],
            'stock' => ['required', 'integer', 'min:1'],
            'stock_unit' => 'required',
            'category_id' => 'required|exists:categories,category_id',
            'sub_category_id' => 'required|exists:sub_categories,sub_category_id',
            'sub_sub_category_id' => 'required|exists:sub_sub_categories,sub_sub_category_id',
            'skin_type' => 'required',
            'dimension' => ['required', 'regex:/^[0-9]+x[0-9]+x[0-9]$/'],
            'volume' => ['required', 'integer', 'max:255', 'regex:/^[0-9]+(\.[0-9]+)?\s?$/i'],
            'volume_unit' => 'required',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'date_manufactured' => ['required', 'date'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif|max:2048',
        ], [
            'brand_id.required' => 'The brand field is required.',
            'product_name.required' => 'The product name field is required.',
            'description.required' => 'The description field is required.',
            'price.required' => 'The price field is required.',
            'price.max' => 'The price must not exceed 1,000,000.',
            'price.regex' => 'The price must be a valid number with up to two decimal places.',
            'stock.required' => 'The stock field is required.',
            'stock_unit.required' => 'The stock unit field is required.',
            'category_id.required' => 'The category field is required.',
            'sub_category_id.required' => 'The sub category field is required.',
            'sub_sub_category_id.required' => 'The sub sub category field is required.',
            'skin_type.required' => 'The skin type field is required.',
            'dimension.required' => 'The dimension field is required.',
            'dimension.regex' => 'The dimension must be in the format 3x3x3x3 etc.',
            'volume.required' => 'The volume field is required.',
            'volume_unit.required' => 'The volume unit field is required.',
            'supplier_id.required' => 'The supplier field is required.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, avif.',
            'image.max' => 'The image may not be greater than 2048 kilobytes.',
            'date_manufactured.date' => 'The date manufactured must be a valid date.',
        ]);

        $imagePath = '';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        $product = Product::create([
            'brand_id' => $request->brand_id,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_unit' => $request->stock_unit,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_sub_category_id' => $request->sub_sub_category_id,
            'skin_type' => $request->skin_type,
            'dimension' => $request->dimension,
            'volume' => $request->volume,
            'volume_unit' => $request->volume_unit,
            'supplier_id' => $request->supplier_id,
            'date_manufactured' => $request->date_manufactured,
            'image' => $imagePath,
        ]);

        // Create a stock record for the product
        $stock = Stock::create([
            'product_id' => $product->product_id,
            'quantity' => $request->stock,
            'stock_unit' => $request->stock_unit,
        ]);

        // Log the initial stock in
        StockHistory::create([
            'stock_id' => $stock->stock_id,
            'quantity_change' => $request->stock,
            'action' => 'stock_in',
        ]);


        $this->activityLogger->logCreate('products', $product->toArray());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $products = Product::with(['category', 'supplier'])->get();
        return view('admin.products.show', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($product_id)
    {
        $product = Product::findOrFail($product_id);
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $subsubcategories = SubSubCategory::all();
        $suppliers = Supplier::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'suppliers', 'brands', 'subcategories', 'subsubcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $product_id)
    {
        $request->validate([
            'brand_id' => 'required',
            'product_name' =>  ['required', 'string', 'max:255', 'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\s]+$/'],
            'description' => 'nullable',
            'price' => 'required|numeric|max:1000000',
            'stock' => 'required|integer|max:1000000',
            'stock_unit' => 'required',
            'category_id' => 'required|exists:categories,category_id',
            'sub_category_id' => 'required|exists:sub_categories,sub_category_id',
            'sub_sub_category_id' => 'required|exists:sub_sub_categories,sub_sub_category_id',
            'skin_type' => 'required',
            'dimension' => 'required',
            'volume' => ['required', 'string', 'max:255', 'regex:/^[0-9]+(\.[0-9]+)?\s?$/i'],
            'volume_unit' => 'required',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'date_manufactured' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif|max:2048',
        ], [
            'brand_id.required' => 'The brand field is required.',
            'product_name.required' => 'The product name field is required.',
            'description.required' => 'The description field is required.',
            'price.required' => 'The price field is required.',
            'stock.required' => 'The stock field is required.',
            'stock_unit.required' => 'The stock unit field is required.',
            'category_id.required' => 'The category field is required.',
            'sub_category_id.required' => 'The sub category field is required.',
            'sub_sub_category_id.required' => 'The sub sub category field is required.',
            'skin_type.required' => 'The skin type field is required.',
            'dimension.required' => 'The dimension field is required.',
            'volume.required' => 'The volume field is required.',
            'volume_unit.required' => 'The volume unit field is required.',
            'supplier_id.required' => 'The supplier field is required.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, avif.',
            'image.max' => 'The image may not be greater than 2048 kilobytes.',
        ]);

        $product = Product::findOrFail($product_id);
        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        $product->update([
            'brand_id' => $request->brand_id,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'stock_unit' => $request->stock_unit,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_sub_category_id' => $request->sub_sub_category_id,
            'skin_type' => $request->skin_type,
            'ingredients' => $request->ingredients,
            'benefits' => $request->benefits,
            'dimension' => $request->dimension,
            'volume' => $request->volume,
            'volume_unit' => $request->volume_unit,
            'supplier_id' => $request->supplier_id,
            'date_manufactured' => $request->date_manufactured,
            'image' => $imagePath,
        ]);

        $this->activityLogger->logUpdate('products', $product->toArray());

        return redirect()->route('admin.products.dashboard')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();

        $this->activityLogger->logDelete('products', $product->toArray());

        return redirect()->route('admin.products.dashboard')->with('success', 'Product deleted successfully.');
    }
}
