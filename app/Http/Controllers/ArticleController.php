<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        return response()->json(Article::with(['category', 'user'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article = Auth::user()->articles()->create($validated);
        return response()->json($article, 201);
    }

    public function show(Article $article)
    {
        return response()->json($article->load(['category', 'user']));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        $article->update($validated);
        return response()->json($article);
    }

    public function destroy(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $article->delete();
        return response()->json(['message' => 'Article deleted']);
    }
}