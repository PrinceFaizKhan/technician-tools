<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * List technical articles and service tips.
     */
    public function index(Request $request): JsonResponse
    {
        $articles = Article::where('is_active', true)
            ->latest('id')
            ->paginate((int) $request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $articles->items(),
            'pagination' => [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'total' => $articles->total(),
            ],
        ]);
    }

    /**
     * Show single article and increment views.
     */
    public function show(int $id): JsonResponse
    {
        $article = Article::findOrFail($id);
        $article->increment('views');

        return response()->json([
            'success' => true,
            'data' => $article,
        ]);
    }
}
