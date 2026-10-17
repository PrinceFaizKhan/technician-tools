<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compressor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompressorController extends Controller
{
    /**
     * List all compressors with specifications.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Compressor::with('refrigerant')->where('is_active', true);

        if ($request->filled('brand_name')) {
            $query->where('brand_name', $request->input('brand_name'));
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('brand_name', 'LIKE', "%{$search}%")
                    ->orWhere('model_number', 'LIKE', "%{$search}%");
            });
        }

        $compressors = $query->latest('id')->paginate((int) $request->input('per_page', 30));

        return response()->json([
            'success' => true,
            'data' => $compressors->items(),
            'pagination' => [
                'current_page' => $compressors->currentPage(),
                'last_page' => $compressors->lastPage(),
                'total' => $compressors->total(),
            ],
        ]);
    }

    /**
     * Show compressor details.
     */
    public function show(int $id): JsonResponse
    {
        $compressor = Compressor::with('refrigerant')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $compressor,
        ]);
    }
}
