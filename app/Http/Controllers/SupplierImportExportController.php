<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SupplierImportExportController extends Controller
{
    public function export(Supplier $supplier): StreamedResponse {
        $supplier->load('cltLayups.cltLayers');

        $data = [
            'supplier' => [
                'id' => $supplier->id,
                'name' => $supplier->name,
            ],
            'layups' => $supplier->cltLayups->map(function ($layup) {
                return [
                    'id' => $layup->id,
                    'name' => $layup->name,
                    'layers' => $layup->cltLayers->sortBy('layer_order')->values()->map(function ($layer) {
                        return [
                            'layer_order' => $layer->layer_order,
                            'thickness' => (float) $layer->thickness,
                            'width' => (float) $layer->width,
                            'angle' => (float) $layer->angle,
                        ];
                    }),
                ];

            }),
        ];

        $filename = str($supplier->name)->slug()->append('-export.json');

        // return response(json_encode($data, JSON_PRETTY_PRINT))->header('Content-Type', 'application/json')->header('Content-Dispotition', 'attachment; filename="'.$filename.'"');
        return response()->streamDownload(
            function () use ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            },
            $filename,
            ['Content-Type' => 'application/json',],
        );
    }

    public function import(Request $request, Supplier $supplier): RedirectResponse {
        $request->validate([
            'file' => ['required', 'file', 'mimes:json,txt'],
        ]);

        $content = file_get_contents($request->file('file')->getRealPath());
        $data = json_decode($content, true);

        if(!is_array($data) || !isset($data['layups']) || !is_array($data['layups'])) {
            return back()->withErrors([
                'file' => 'Invalid JSON format. The file must be contain a layups array.',
            ]);
        }

        $conflicts = $this->detectConflicts($supplier, $data);

        session([
            'pending_import_supplier_id' => $supplier->id,
            'pending_import_data' => $data,
            'pending_import_conflicts' => $conflicts,
        ]);

        if(count($conflicts) > 0) {
            return redirect()->route('suppliers.import.conflicts', $supplier);
        }

        session()->forget([
            'pending_import_supplier_id',
            'pending_import_data',
            'pending_import_conflicts',
        ]);

        return $this->applyImport($supplier, $data, []);

        // $createdLayups = 0;
        // $updatedLayups = 0;
        // $createdLayers = 0;
        // $updatedLayers = 0;
        // $conflicts = 0;
        // $conflictReports = [];

        // foreach($data['layups'] as $incomingLayup) {
        //     if(!isset($incomingLayup['name'])) {
        //         continue;
        //     }

        //     $layup = $supplier->cltLayups()->where('name', $incomingLayup['name'])->first();

        //     if(!$layup) {
        //         $layup = $supplier->cltLayups()->create([
        //             'name' => $incomingLayup['name'],
        //         ]);

        //         $createdLayups++;
        //     }else{
        //         $updatedLayups++;
        //     }

        //     foreach($incomingLayup['layers'] ?? [] as $incomingLayer) {
        //         if(!isset($incomingLayer['layer_order'])) {
        //             continue;
        //         }

        //         $layer = $layup->cltLayers()->where('layer_order', $incomingLayer['layer_order'])->first();

        //         $payload = [
        //             'layer_order' => $incomingLayer['layer_order'],
        //             'thickness' => $incomingLayer['thickness'] ?? 0,
        //             'width' => $incomingLayer['width'] ?? 0,
        //             'angle' => $incomingLayer['angle'] ?? 0,
        //         ];

        //         if(!$layer) {
        //             $layup->cltLayers()->create($payload);
        //             $createdLayers++;
        //             continue;
        //         }

        //         $hasConflict = (float) $layer->thickness !== (float) $payload['thickness'] || (float) $layer->width !== (float) $payload['width'] || (float) $layer->angle !== (float) $payload['angle'];

        //         if($hasConflict) {
        //             $conflicts++;

        //             $conflictReports[] = [
        //                 'layup' => $layup->name,
        //                 'layer_order' => $layer->layer_order,

        //                 'existing' => [
        //                     'thickness' => (float) $layer->thickness,
        //                     'width' => (float) $layer->width,
        //                     'angle' => (float) $layer->angle,
        //                 ],

        //                 'incoming' => [
        //                     'thickness' => (float) $payload['thickness'],
        //                     'width' => (float) $payload['width'],
        //                     'angle' => (float) $payload['angle'],
        //                 ],

        //                 'strategy' => 'Overwrite Existing',
        //             ];

        //             $layer->update($payload);
        //             $updatedLayers++;
        //         }
        //     }
        // }

        // return redirect()->route('suppliers.show', $supplier)->with('success', "Import completed. Created layups: {$createdLayups}, updated layups: {$updatedLayups}, created layers: {$createdLayers}, overwritten conflicts: {$conflicts}.")->with('conflictReports', $conflictReports);
    }

    public function conflicts(Supplier $supplier): View|RedirectResponse {
        $conflicts = session('pending_import_conflicts', []);

        if(session('pending_import_supplier_id') !== $supplier->id || empty($conflicts)) {
            return redirect()->route('suppliers.show', $supplier);
        }

        return view('suppliers.import-conflicts', compact('supplier', 'conflicts'));
    }

    public function resolve(Request $request, Supplier $supplier): RedirectResponse {
        if(session('pending_import_supplier_id') !== $supplier->id) {
            return redirect()->route('suppliers.show', $supplier)->with('success', 'No pending import found.');
        }

        $data = session('pending_import_data');
        $resolutions = $request->input('resolutions', []);

        session()->forget([
            'pending_import_supplier_id',
            'pending_import_data',
            'pending_import_conflicts',
        ]);

        return $this->applyImport($supplier, $data, $resolutions);
    }

    private function detectConflicts(Supplier $supplier, array $data): array {
        $conflicts = [];

        foreach($data['layups'] as $layupIndex => $incomingLayup) {
            if(!isset($incomingLayup['name'])) {
                continue;
            }

            $layup = $supplier->cltLayups()->where('name', $incomingLayup['name'])->first();

            if(!$layup) {
                continue;
            }

            foreach($incomingLayup['layers'] ?? [] as $layerIndex => $incomingLayer) {
                if(!isset($incomingLayer['layer_order'])) {
                    continue;
                }

                $layer = $layup->cltLayers()->where('layer_order', $incomingLayer['layer_order'])->first();

                if(!$layer) {
                    continue;
                }

                $incomingPayload = [
                    'layer_order' => $incomingLayer['layer_order'],
                    'thickness' => $incomingLayer['thickness'] ?? 0,
                    'width' => $incomingLayer['width'] ?? 0,
                    'angle' => $incomingLayer['angle'] ?? 0,
                ];

                $hasConflict = (float) $layer->thickness !== (float) $incomingPayload['thickness'] || (float) $layer->width !== (float) $incomingPayload['width'] || (float) $layer->angle !== (float) $incomingPayload['angle'];

                if($hasConflict) {
                    $conflicts[] = [
                        'key' => "{$layupIndex}_{$layerIndex}",
                        'layup_name' => $layup->name,
                        'layer_order' => $layer->layer_order,

                        'existing' => [
                            'thickness' => (float) $layer->thickness,
                            'width' => (float) $layer->width,
                            'angle' => (float) $layer->angle,
                        ],

                        'incoming' => [
                            'thickness' => (float) $incomingPayload['thickness'],
                            'width' => (float) $incomingPayload['width'],
                            'angle' => (float) $incomingPayload['angle'],
                        ],
                    ];
                }
            }
        }

        return $conflicts;
    }

    private function applyImport(Supplier $supplier, array $data, array $resolutions): RedirectResponse {
        $createdLayups = 0;
        $createdLayers = 0;
        $updatedLayups = 0;
        $updatedLayers = 0;
        $keepExisting = 0;
        $acceptedIncoming = 0;

        foreach($data['layups'] as $layupIndex => $incomingLayup) {
            if(!isset($incomingLayup['name'])) {
                continue;
            }

            $layup = $supplier->cltLayups()->where('name', $incomingLayup['name'])->first();

            if(!$layup) {
                $layup = $supplier->cltLayups()->create([
                    'name' => $incomingLayup['name'],
                ]);

                $createdLayups++;
            }else{
                $updatedLayups++;
            }

            foreach($incomingLayup['layers'] ?? [] as $layerIndex => $incomingLayer) {
                if(!isset($incomingLayer['layer_order'])) {
                    continue;
                }

                $payload = [
                    'layer_order' => $incomingLayer['layer_order'],
                    'thickness' => $incomingLayer['thickness'] ?? 0,
                    'width' => $incomingLayer['width'] ?? 0,
                    'angle' => $incomingLayer['angle'] ?? 0,
                ];

                $layer = $layup->cltLayers()->where('layer_order', $incomingLayer['layer_order'])->first();

                if(!$layer) {
                    $layup->cltLayers()->create($payload);
                    $createdLayers++;
                    continue;
                }

                $hasConflict = (float) $layer->thickness !== (float) $payload['thickness'] || (float) $layer->width !== (float) $payload['width'] || (float) $layer->angle !== (float) $payload['angle'];

                if($hasConflict) {
                    $key = "{$layupIndex}_{$layerIndex}";
                    $resolution = $resolutions[$key] ?? 'existing';

                    if($resolution === 'existing') {
                        $keepExisting++;
                        continue;
                    }

                    $layer->update($payload);
                    $updatedLayers++;
                    $acceptedIncoming++;
                    continue;
                }

                $layer->update($payload);
                $updatedLayers++;
            }
        }

        return redirect()->route('suppliers.show', $supplier)->with('success', "Import completed. Created layups: {$createdLayups}, updated layups: {$updatedLayups}, created layers: {$createdLayers}, updated layers: {$updatedLayers}, accepted incoming: {$acceptedIncoming}, kept existing: {$keepExisting}.");
    }
}
