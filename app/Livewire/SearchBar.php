<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class SearchBar extends Component
{
    // Query di ricerca
    public string $query = '';

    // Risultati della ricerca
    public $results = [];

    // Aggiorna i risultati in tempo reale al cambiamento della query
    public function updatedQuery(): void
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }
        // Traduce la query in italiano per cercare nel DB
        $searchQuery = \App\Helpers\TranslateHelper::translate($this->query, 'it');
        $originalQuery = $this->query;

        $this->results = Article::with(['category'])
            ->where('status', 'approved')
            ->where(function ($q) use ($searchQuery, $originalQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('title', 'like', '%' . $originalQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $originalQuery . '%')
                    ->orWhereHas('category', function ($q) use ($searchQuery, $originalQuery) {
                        $q->where('name', 'like', '%' . $searchQuery . '%')
                            ->orWhere('name', 'like', '%' . $originalQuery . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    // Redirect alla pagina di ricerca con la query
    public function search(): void
    {
        $this->redirectRoute('article.search', ['query' => $this->query]);
    }
    public function render()
    {
        return view('livewire.search-bar');
    }
}
