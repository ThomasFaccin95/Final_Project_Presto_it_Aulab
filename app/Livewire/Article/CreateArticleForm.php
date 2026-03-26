<?php

namespace App\Livewire\Article;

use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateArticleForm extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $description = '';
    public string $price = '';
    public int $category_id = 0;

    // Array di immagini caricate temporaneamente
    public array $images = [];

    protected function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'category_id'   => ['required', 'integer', 'exists:categories,id'],
            // Valida ogni immagine nell'array
            'images.*'      => ['image', 'max:2048'],
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required'        => 'Il titolo è obbligatorio.',
            'title.max'             => 'Il titolo non può superare 255 caratteri.',
            'description.required'  => 'La descrizione è obbligatoria.',
            'price.required'        => 'Il prezzo è obbligatorio.',
            'price.numeric'         => 'Il prezzo deve essere un numero.',
            'price.min'             => 'Il prezzo non può essere negativo.',
            'category_id.required'  => 'Seleziona una categoria.',
            'category_id.exists'    => 'La categoria selezionata non è valida.',
            'images.*.image'        => 'Il file deve essere un\'immagine.',
            'images.*.max'          => 'Ogni immagine non può superare 2MB.',
        ];
    }

    // Rimuove una singola immagine dall'array per indice
    public function removeImage(int $index): void
    {
        array_splice($this->images, $index, 1);
    }

    public function store(): void
    {
        $this->validate();

        $article = Article::create([
            'user_id'     => Auth::id(),
            'category_id' => $this->category_id,
            'title'       => $this->title,
            'description' => $this->description,
            'price'       => $this->price,
        ]);

        // Salva ogni immagine nello storage e crea il record nel DB
        foreach ($this->images as $image) {
            $path = $image->store('articles', 'public');
            Image::create([
                'article_id' => $article->id,
                'path'       => $path,
            ]);
        }

        $this->reset(['title', 'description', 'price', 'category_id', 'images']);

        // In Livewire 3 il redirect si fa con redirectRoute()
        $this->redirectRoute('article.index');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.article.create-article-form', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
