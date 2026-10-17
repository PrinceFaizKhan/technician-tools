<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ErrorCode;
use App\Services\ErrorCodeSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ErrorCodeController extends Controller
{
    /**
     * Use constructor promotion to inject the singleton search service.
     */
    public function __construct(
        protected ErrorCodeSearchService $searchService
    ) {}

    /**
     * Search and list error codes.
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => $request->input('search'),
            'appliance_id' => $request->filled('appliance_id') ? (int) $request->input('appliance_id') : null,
            'brand_id' => $request->filled('brand_id') ? (int) $request->input('brand_id') : null,
            'filter_id' => $request->filled('filter_id') ? (int) $request->input('filter_id') : null,
            'per_page' => (int) $request->input('per_page', 25),
        ];

        $results = $this->searchService->search($filters);

        return response()->json([
            'success' => true,
            'data' => $results->items(),
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
            ],
        ]);
    }

    /**
     * Show detailed error code information.
     */
    public function show(int $id): JsonResponse
    {
        $errorCode = ErrorCode::with(['appliance', 'brand', 'filter'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $errorCode,
        ]);
    }
}
