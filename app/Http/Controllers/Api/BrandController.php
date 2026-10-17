<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * List all brands, optionally filtered by appliance.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Brand::where('is_active', true);

        if ($request->filled('appliance_id')) {
            $applianceId = (int) $request->input('appliance_id');
            $query->whereHas('appliances', function ($q) use ($applianceId): void {
                $q->where('appliances.id', $applianceId);
            });
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where('title', 'LIKE', "%{$search}%");
        }

        $brands = $query->orderBy('title')->get();

        return response()->json([
            'success' => true,
            'data' => $brands,
        ]);
    }

    /**
     * Show single brand details.
     */
    public function show(int $id): JsonResponse
    {
        $brand = Brand::with('appliances')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $brand,
        ]);
    }
}
