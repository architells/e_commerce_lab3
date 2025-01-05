<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
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
        $subCategories = SubCategory::all();
        return view('admin.sub_category.dashboard', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.sub_category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'sub_category_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/', 'unique:sub_categories,sub_category_name'],
        ], [
            'sub_category_name.regex' => 'The sub category name may only contain letters and spaces.',
            'sub_category_name.unique' => 'The sub category name has already been taken.',
        ]);

        $subCategory = SubCategory::create([
            'category_id' => $request->category_id,
            'sub_category_name' => $request->sub_category_name,
        ]);

        $this->activityLogger->logCreate('sub_category', ['sub_category_name' => $subCategory->sub_category_name]);

        return redirect()->route('admin.category.dashboard')->with('success', 'SubCategory created successfully.');
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
    public function edit(string $sub_category_id)
    {
        $subCategory = SubCategory::findOrFail($sub_category_id);
        $categories = Category::all();
        return view('admin.sub_category.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $sub_category_id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'sub_category_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
        ], [
            'sub_category_name.regex' => 'The sub category name may only contain letters and spaces.',
        ]);

        $subCategory = SubCategory::findOrFail($sub_category_id);
        $oldData = $subCategory->toArray();

        $subCategory->update([
            'category_id' => $request->category_id,
            'sub_category_name' => $request->sub_category_name,
        ]);

        $this->activityLogger->logUpdate('sub_category', [
            'before' => $oldData,
            'after' => $subCategory->toArray(),
        ]);


        return redirect()->route('admin.category.dashboard')->with('success', 'SubCategory updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $sub_category_id)
    {
        $subCategory = SubCategory::findOrFail($sub_category_id);
        $subCategoryName = $subCategory->sub_category_name;
        $subCategory->delete();

        $this->activityLogger->logDelete('sub_category', [
            'sub_category_name' => $subCategoryName,
        ]);

        return redirect()->route('admin.category.dashboard')->with('success', 'SubCategory deleted successfully.');
    }
}
