<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $sort = $request->sort === 'desc' ? 'desc' : 'asc';
        $query->orderBy('title', $sort);

        $articles = $query->get();

        return view('articles.list', [
            'articles' => $articles,
            'search'   => $request->search,
            'sort'     => $sort,
        ]);
    }

    function show(Request $request, $slug)
    {
        $article = Article::where('slug', '=', $slug)->firstOrFail();
        return view('articles.show', [
            'article' => $article,
        ]);
    }
}