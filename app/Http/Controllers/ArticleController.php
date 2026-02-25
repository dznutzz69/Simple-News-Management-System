<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        return response()->json(Article::with(['category', 'user'])->get());
    }

    public function store(StoreArticleRequest $request)
    {
        // The incoming request is already validated!
        $validated = $request->validated();

        $article = Auth::user()->articles()->create($validated);
        return response()->json($article, 201);
    }

    public function show(Article $article)
    {
        return response()->json($article->load(['category', 'user']));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        // Authorization is already handled in the Form Request!
        // Validation is already handled!
        $validated = $request->validated();

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

    public function publish(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $article->update(['status' => 'published']);
        return response()->json(['message' => 'Article published successfully', 'article' => $article]);
    }
}