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
        $this->results = Article::with(['category'])
            ->where(function ($q) {
                $q->where('title', 'like', '%' . $this->query . '%')
                    ->orWhere('description', 'like', '%' . $this->query . '%')
                    ->orWhereHas('category', function ($q) {
                        $q->where('name', 'like', '%' . $this->query . '%');
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
