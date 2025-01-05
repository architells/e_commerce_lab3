<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class SubSubCategoriesController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subCategories = SubCategory::all();
        return view('admin.sub_sub_category.create', compact('subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,sub_category_id',
            'sub_sub_category_name' => ['required', 'string', 'max:255', 'unique:sub_sub_categories,sub_sub_category_name'],
        ], [
            'sub_sub_category_name.regex' => 'The sub sub category name may only contain letters and spaces.',
            'sub_sub_category_name.unique' => 'The sub sub category name has already been taken.',
        ]);

        $subSubCategory = SubSubCategory::create([
            'sub_category_id' => $request->sub_category_id,
            'sub_sub_category_name' => $request->sub_sub_category_name,
        ]);

        $this->activityLogger->logCreate('sub_sub_category', ['sub_sub_category_name' => $subSubCategory->sub_sub_category_name]);

        return redirect()->route('admin.category.dashboard')->with('success', 'SubSubCategory created successfully.');
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
    public function edit(string $sub_sub_category_id)
    {
        $subSubCategory = SubSubCategory::findOrFail($sub_sub_category_id);
        $subCategories = SubCategory::all();
        return view('admin.sub_sub_category.edit', compact('subSubCategory', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $sub_sub_category_id)
    {
        $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,sub_category_id',
            'sub_sub_category_name' => ['required', 'string', 'max:255'],
        ], [
            'sub_sub_category_name.regex' => 'The sub sub category name may only contain letters and spaces.',
        ]);

        $subSubCategory = SubSubCategory::findOrFail($sub_sub_category_id);
        $oldData = $subSubCategory->toArray();


        $subSubCategory->update([
            'sub_category_id' => $request->sub_category_id,
            'sub_sub_category_name' => $request->sub_sub_category_name,
        ]);

        $this->activityLogger->logUpdate('sub_sub_category', [
            'before' => $oldData,
            'after' => $subSubCategory->toArray(),
        ]);

        return redirect()->route('admin.category.dashboard')->with('success', 'SubSubCategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sub_sub_category_id)
    {
        $subSubCategory = SubSubCategory::findOrFail($sub_sub_category_id);
        $subSubCategoryName = $subSubCategory->sub_sub_category_name;
        $subSubCategory->delete();

        $this->activityLogger->logDelete('sub_sub_category', [
            'sub_sub_category_name' => $subSubCategoryName,
        ]);

        return redirect()->route('admin.category.dashboard')->with('success', 'SubSubCategory deleted successfully.');
    }
}
