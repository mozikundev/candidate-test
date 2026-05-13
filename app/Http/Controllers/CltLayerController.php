<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCltLayerRequest;
use App\Http\Requests\UpdateCltLayerRequest;
use App\Models\CltLayer;
use App\Models\CltLayup;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CltLayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Supplier $supplier, CltLayup $layup): RedirectResponse {
        return redirect()->route('suppliers.layups.show', [$supplier, $layup]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Supplier $supplier, CltLayup $layup): View {
        return view('layers.create', compact('supplier', 'layup'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCltLayerRequest $request, Supplier $supplier, CltLayup $layup): RedirectResponse {
        $layup->cltLayers()->create($request->validated());

        return redirect()->route('suppliers.layups.show', [$supplier, $layup])->with('success', 'Layer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier, CltLayup $layup, CltLayer $layer): RedirectResponse {
        return redirect()->route('suppliers.layups.show', [$supplier, $layup]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier, CltLayup $layup, CltLayer $layer): View {
        return view('layers.edit', compact('supplier', 'layup', 'layer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCltLayerRequest $request, Supplier $supplier, CltLayup $layup, CltLayer $layer): RedirectResponse {
        $layer->update($request->validated());

        return redirect()->route('suppliers.layups.show', [$supplier, $layup])->with('success', 'Layer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier, CltLayup $layup, CltLayer $layer): RedirectResponse {
        $layer->delete();

        return redirect()->route('suppliers.layups.show', [$supplier, $layup])->with('success', 'Layer deleted successfully.');
    }
}
