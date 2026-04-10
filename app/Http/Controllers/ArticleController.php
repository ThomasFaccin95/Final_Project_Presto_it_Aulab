<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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

        // Traduce la query nella lingua base (italiano) per cercare nel DB
        $searchQuery = \App\Helpers\TranslateHelper::translate($query, 'it');

        // Debug per verificare la traduzione
        // \Illuminate\Support\Facades\Log::info('[Search] Query originale: ' . $query);
        // \Illuminate\Support\Facades\Log::info('[Search] Query tradotta: ' . $searchQuery);

        // Filtra gli articoli per query : $q -> Eloquent che mi permette di raggruppare condizioni logiche e definire query complesse
        $articles = Article::with(['category', 'user'])
            ->where('status', 'approved')
            ->when(auth()->check(), fn($q) => $q->where('user_id', '!=', Auth::id()))
            ->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%')
                    ->orWhereHas('category', function ($q) use ($searchQuery) {
                        $q->where('name', 'like', '%' . $searchQuery . '%');
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
        // Solo il proprietario può modificare
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }

        return view('article.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        //
    }

    public function destroy(Article $article)
    {
        // Solo il proprietario può eliminare
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }

        // Elimina le immagini dallo storage
        foreach ($article->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $article->delete();

        return redirect()->route('article.my')->with('success', __('messages.article_deleted'));
    }
}
