<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCltLayupRequest;
use App\Http\Requests\UpdateCltLayupRequest;
use App\Models\CltLayup;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CltLayupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Supplier $supplier): View {
        return redirect()->route('suppliers.show', $supplier);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Supplier $supplier): View {
        return view('layups.create', compact('supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCltLayupRequest $request, Supplier $supplier): RedirectResponse {
        $supplier->cltLayups()->create($request->validated());

        return redirect()->route('suppliers.show', $supplier)->with('success', 'Layup created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier, CltLayup $layup): View {
        $layup->load('cltLayers');

        return view('layups.show', compact('supplier', 'layup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier, CltLayup $layup): View {
        return view('layups.edit', compact('supplier', 'layup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCltLayupRequest $request, Supplier $supplier, CltLayup $layup): RedirectResponse {
        $layup->update($request->validated());

        return redirect()->route('suppliers.show', $supplier)->with('success', 'Layup update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier, CltLayup $layup): RedirectResponse {
        $layup->delete();

        return redirect()->route('suppliers.show', $supplier)->with('success', 'Layup deleted successfully.');
    }
}
