<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Category;


class ArticleController extends Controller
{
    public function index()
    {
        // Lista tutti gli articoli paginati
        $articles = Article::with(['category', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('article.index', compact('articles'));
    }

    public function show(Article $article)
    {
        // Carica le relazioni necessarie
        $article->load('category', 'user');

        return view('article.show', compact('article'));
    }

    // Filtra gli articoli per categoria
    public function byCategory(Category $category)
    {
        $articles = Article::with(['category', 'user'])
            ->where('category_id', $category->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('article.index', compact('articles', 'category'));
    }

    // Pagina risultati ricerca full-text
    public function search(Request $request)
    {
        $query = $request->input('query', '');

        $articles = Article::with(['category', 'user'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhereHas('category', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('article.search', compact('articles', 'query'));
    }

    public function create()
    {
        return view('article.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Article $article)
    {
        //
    }

    public function update(Request $request, Article $article)
    {
        //
    }

    public function destroy(Article $article)
    {
        //
    }
}
