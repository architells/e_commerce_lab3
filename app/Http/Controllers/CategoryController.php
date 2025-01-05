<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class CategoryController extends Controller
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
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $subSubCategories = SubSubCategory::all();
        return view('admin.category.dashboard', compact('categories', 'subCategories', 'subSubCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/', 'unique:categories,category_name'], // Ensure it contains only letters and spaces
        ], [
            'category_name.regex' => 'The category name may only contain letters and spaces.',
            'category_name.unique' => 'The category name has already been taken.',
        ]);

        Category::create(['category_name' => $request->category_name]);

        $this->activityLogger->logCreate('categories', $request->toArray());

        return redirect()->route('admin.category.dashboard')->with('success', 'Category created successfully.');
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
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
    public function edit(string $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $categoryId)
    {
        $request->validate([
            'category_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Ensure it contains only letters and spaces
        ], [
            'category_name.regex' => 'The category name may only contain letters and spaces.',
            // other custom messages
        ]);

        $category = Category::findOrFail($categoryId);
        $category->update(['category_name' => $request->category_name]);

        $this->activityLogger->logUpdate('categories', $category->toArray());

        return redirect()->route('admin.category.dashboard')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $categoryName = $category->category_name;
        $category->delete();

        $this->activityLogger->logDelete('categories', [
            'category_name' => $categoryName,
        ]);

        return redirect()->route('admin.category.dashboard')->with('success', 'Category deleted successfully.');
    }
}
