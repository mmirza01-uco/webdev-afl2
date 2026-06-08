<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    function destroy(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $article = $comment->article;

        $comment->delete();

        return redirect()->route('articles.show', $article->slug);
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('articles.show', $comment->article->slug);
    }
}