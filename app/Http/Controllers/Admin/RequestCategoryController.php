<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestCategory;
use App\Models\RequestType;
use Illuminate\Http\Request;

class RequestCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RequestCategory::with('requestType', 'subcategories');
        $requestTypes = RequestType::all();
        $selectedType = $request->get('type_id');

        if ($selectedType) {
            $query->where('request_type_id', $selectedType);
        }

        $categories = $query->paginate(10);
        return view('admin.utilities.request-categories.index', compact('categories', 'requestTypes', 'selectedType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $requestTypes = RequestType::all();
        return view('admin.utilities.request-categories.create', compact('requestTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_type_id' => 'required|exists:request_types,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        RequestCategory::create($validated);
        return redirect()->route('admin.request-categories.index')->with('success', 'Kategori bantuan berjaya ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestCategory $requestCategory)
    {
        return view('admin.utilities.request-categories.show', compact('requestCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestCategory $requestCategory)
    {
        $requestTypes = RequestType::all();
        return view('admin.utilities.request-categories.edit', compact('requestCategory', 'requestTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestCategory $requestCategory)
    {
        $validated = $request->validate([
            'request_type_id' => 'required|exists:request_types,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $requestCategory->update($validated);
        return redirect()->route('admin.request-categories.index')->with('success', 'Kategori bantuan berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestCategory $requestCategory)
    {
        if ($requestCategory->subcategories()->exists()) {
            return redirect()->route('admin.request-categories.index')->with('error', 'Tidak boleh memadamkan kategori yang masih mempunyai sub-kategori.');
        }

        $requestCategory->delete();
        return redirect()->route('admin.request-categories.index')->with('success', 'Kategori bantuan berjaya dipadamkan.');
    }
}
