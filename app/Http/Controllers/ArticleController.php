<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('pages.artikel-index', [
            'articles' => Article::published()->ordered()->paginate(9),
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless($article->status === 'published', 404);

        return view('pages.artikel-show', [
            'article' => $article,
            'related' => Article::published()
                ->ordered()
                ->whereKeyNot($article->id)
                ->take(3)
                ->get(),
        ]);
    }
}
