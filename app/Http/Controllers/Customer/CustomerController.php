<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class CustomerController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        $subCategories = SubCategory::all();
        $subSubCategories = SubSubCategory::all();

        // Calculate the maximum price
        $maxPrice = $products->max('price');

        return view('welcome', compact('products', 'categories', 'brands', 'subCategories', 'subSubCategories', 'maxPrice'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('product_name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        $categories = Category::all();
        $brands = Brand::all();
        $subCategories = SubCategory::all();
        $subSubCategories = SubSubCategory::all();

        // Calculate the maximum price
        $maxPrice = $products->max('price');

        return view('welcome', compact('products', 'categories', 'brands', 'subCategories', 'subSubCategories', 'maxPrice'));
    }

    public function description($productId)
    {
        $product = Product::with('stock')->find($productId);
        return view('description', compact('product'));
    }

    public function filter(Request $request)
    {
        $query = Product::query();

        if ($request->has('category_id')) {
            $query->whereIn('category_id', $request->category_id);
        }

        if ($request->has('sub_category_id')) {
            $query->whereIn('sub_category_id', $request->sub_category_id);
        }

        if ($request->has('sub_sub_category_id')) {
            $query->whereIn('sub_sub_category_id', $request->sub_sub_category_id);
        }

        if ($request->has('brand_id')) {
            $query->whereIn('brand_id', $request->brand_id);
        }

        if ($request->has('price')) {
            $query->where('price', '<=', $request->price);
        }

        $products = $query->get();
        $filteredProductCount = $products->count();

        $selectedFilters = [
            'category' => $request->has('category_id') ? Category::whereIn('category_id', $request->category_id)->get() : null,
            'sub_category' => $request->has('sub_category_id') ? SubCategory::whereIn('sub_category_id', $request->sub_category_id)->get() : null,
            'sub_sub_category' => $request->has('sub_sub_category_id') ? SubSubCategory::whereIn('sub_sub_category_id', $request->sub_sub_category_id)->get() : null,
            'brand' => $request->has('brand_id') ? Brand::whereIn('brand_id', $request->brand_id)->get() : null,
            'price' => $request->has('price') ? $request->price : null,
        ];

        $categories = Category::all();
        $brands = Brand::all();
        $subCategories = SubCategory::all();
        $subSubCategories = SubSubCategory::all();

        // Calculate the maximum price
        $maxPrice = $products->max('price');

        return view('welcome', compact('products', 'categories', 'brands', 'subCategories', 'subSubCategories', 'maxPrice', 'filteredProductCount', 'selectedFilters'));
    }

    public function cancelFilters()
    {
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        $subCategories = SubCategory::all();
        $subSubCategories = SubSubCategory::all();

        // Calculate the maximum price
        $maxPrice = $products->max('price');

        return view('welcome', compact('products', 'categories', 'brands', 'subCategories', 'subSubCategories', 'maxPrice'));
    }
}
