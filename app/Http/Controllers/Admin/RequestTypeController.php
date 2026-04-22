<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestType;
use Illuminate\Http\Request;

class RequestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestTypes = RequestType::with('categories')->paginate(10);
        return view('admin.utilities.request-types.index', compact('requestTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.utilities.request-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:request_types,name',
            'description' => 'nullable|string',
        ]);

        RequestType::create($validated);
        return redirect()->route('admin.request-types.index')->with('success', 'Jenis bantuan berjaya ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestType $requestType)
    {
        return view('admin.utilities.request-types.show', compact('requestType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestType $requestType)
    {
        return view('admin.utilities.request-types.edit', compact('requestType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestType $requestType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:request_types,name,' . $requestType->id,
            'description' => 'nullable|string',
        ]);

        $requestType->update($validated);
        return redirect()->route('admin.request-types.index')->with('success', 'Jenis bantuan berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestType $requestType)
    {
        if ($requestType->categories()->exists()) {
            return redirect()->route('admin.request-types.index')->with('error', 'Tidak boleh memadamkan jenis bantuan yang masih mempunyai kategori.');
        }

        $requestType->delete();
        return redirect()->route('admin.request-types.index')->with('success', 'Jenis bantuan berjaya dipadamkan.');
    }
}
