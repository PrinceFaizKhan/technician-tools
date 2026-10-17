<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refrigerant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefrigerantController extends Controller
{
    /**
     * List all refrigerants with pressure data.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Refrigerant::where('is_active', true);

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where('title', 'LIKE', "%{$search}%");
        }

        $refrigerants = $query->orderBy('title')->get();

        return response()->json([
            'success' => true,
            'data' => $refrigerants,
        ]);
    }

    /**
     * Show single refrigerant details.
     */
    public function show(int $id): JsonResponse
    {
        $refrigerant = Refrigerant::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $refrigerant,
        ]);
    }
}
