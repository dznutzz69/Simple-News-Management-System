<?php

namespace App\Http\Controllers;

use App\Models\Article;

class PublicNewsController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'user'])
            ->where('status', 'published')
            ->latest()
            ->get();

        return response()->json($articles);
    }
}
