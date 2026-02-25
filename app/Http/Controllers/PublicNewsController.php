<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Resources\ArticleResource; // Import the Resource
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicNewsController extends Controller
{
    /**
     * Display a listing of published articles with search and filter functionality.
     */
    public function index(Request $request)
    {
        // Start the query with eager loading to prevent N+1 issues
        $query = Article::with(['category', 'user'])->where('status', 'published');

        // Dev 9 Search Logic: Filter by title or content
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Dev 10 Filter Logic: Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Optional: Allow authenticated users to view different statuses
        if ($request->has('status') && Auth::check()) {
             $query->where('status', $request->status);
        }

        // Execute query and return via ArticleResource collection
        $articles = $query->latest()->get();
        
        return ArticleResource::collection($articles);
    }
}