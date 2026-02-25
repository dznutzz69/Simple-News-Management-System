<?php

 public function publish(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $article->update(['status' => 'published']);
        return response()->json(['message' => 'Article published successfully', 'article' => $article]);
    }