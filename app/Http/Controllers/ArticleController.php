<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ArticleController extends Controller
{
    public function myArticles()
    {
        $articles = Article::with(['category', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('article.my-articles', compact('articles'));
    }
    public function index()
    {
        // Lista tutti gli articoli paginati - Solo annunci approvati
        $articles = Article::with(['category', 'user'])
            ->where('status', 'approved')
            ->when(auth()->check(), fn($q) => $q->where('user_id', '!=', Auth::id()))
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('article.index', compact('articles'));
    }

    // Solo annunci approvati nel dettaglio
    public function show(Article $article)
    {
        if ($article->status !== 'approved') {
            abort(404);
        }
        // Carica le relazioni necessarie
        $article->load('category', 'user');

        return view('article.show', compact('article'));
    }

    // Filtra gli articoli per categoria -solo annunci approvati
    public function byCategory(Category $category)
    {
        $articles = Article::with(['category', 'user'])
            ->where('category_id', $category->id)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('article.index', compact('articles', 'category'));
    }

    // Pagina risultati ricerca full-text - solo annunci approvati
    public function search(Request $request)
    {
        $query = $request->input('query', '');
        // Filtra gli articoli per query : $q -> Eloquent che mi permette di raggruppare condizioni logiche e definire query complesse
        $articles = Article::with(['category', 'user'])
            ->where('status', 'approved')
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
