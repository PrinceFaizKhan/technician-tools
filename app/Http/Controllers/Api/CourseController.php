<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * List all courses with videos count.
     */
    public function index(Request $request): JsonResponse
    {
        $courses = Course::withCount('videos')
            ->where('is_active', true)
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $courses,
        ]);
    }

    /**
     * Show single course with all its videos.
     */
    public function show(int $id): JsonResponse
    {
        $course = Course::with(['videos' => function ($q): void {
            $q->orderBy('sort_order')->orderBy('id');
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $course,
        ]);
    }
}
