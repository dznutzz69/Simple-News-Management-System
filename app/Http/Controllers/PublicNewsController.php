<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicNewsController extends Controller
{

    //DEV 9 SEARCH FUNCTION (OBSOLETE)
    // public function index()
    // {
    //     $articles = Article::with(['category', 'user'])
    //         ->where('status', 'published')
    //         ->latest()
    //         ->get();

    //     return response()->json($articles);
    // }

     public function index(Request $request)
    {
        $query = Article::with(['category', 'user'])->where('status', 'published');

        // Dev 9 Search Logic
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Dev 10 Filter Logic
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Optional: Expose draft filtering for authenticated routes if needed
        if ($request->has('status') && Auth::check()) {
             $query->where('status', $request->status);
        }

        return response()->json($query->latest()->get());
    }
}
