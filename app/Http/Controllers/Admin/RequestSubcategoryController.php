<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestSubcategory;
use App\Models\RequestCategory;
use Illuminate\Http\Request;

class RequestSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = RequestSubcategory::with('category.requestType')->paginate(10);
        return view('admin.utilities.request-subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = RequestCategory::all();
        return view('admin.utilities.request-subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_category_id' => 'required|exists:request_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
        ]);

        RequestSubcategory::create($validated);
        return redirect()->route('admin.request-subcategories.index')->with('success', 'Sub-kategori bantuan berjaya ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestSubcategory $requestSubcategory)
    {
        return view('admin.utilities.request-subcategories.show', compact('requestSubcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestSubcategory $requestSubcategory)
    {
        $categories = RequestCategory::all();
        return view('admin.utilities.request-subcategories.edit', compact('requestSubcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestSubcategory $requestSubcategory)
    {
        $validated = $request->validate([
            'request_category_id' => 'required|exists:request_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
        ]);

        $requestSubcategory->update($validated);
        return redirect()->route('admin.request-subcategories.index')->with('success', 'Sub-kategori bantuan berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestSubcategory $requestSubcategory)
    {
        $requestSubcategory->delete();
        return redirect()->route('admin.request-subcategories.index')->with('success', 'Sub-kategori bantuan berjaya dipadamkan.');
    }
}
