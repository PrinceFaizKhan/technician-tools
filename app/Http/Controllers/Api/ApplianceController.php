<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appliance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplianceController extends Controller
{
    /**
     * List all active appliance categories.
     */
    public function index(Request $request): JsonResponse
    {
        $appliances = Appliance::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $appliances,
        ]);
    }

    /**
     * Show single appliance with associated brands.
     */
    public function show(int $id): JsonResponse
    {
        $appliance = Appliance::with(['brands', 'filters'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $appliance,
        ]);
    }
}
