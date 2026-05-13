<?php

namespace App\Http\Controllers;

use App\Models\CltLayer;
use App\Models\CltLayup;
use App\Models\Supplier;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'suppliers' => Supplier::count(),
            'layups' => CltLayup::count(),
            'layers' => CltLayer::count(),
        ];

        $recentSuppliers = Supplier::latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentSuppliers'));
    }
}