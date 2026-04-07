<?php

namespace App\Livewire\Article;

use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\ResizeImage;
use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionSafeSearch;
use App\Jobs\RemoveFaces;
// Gestione per le catene dei processi Google per sicrurezza,tag, offuscamento e ridimensione
use Illuminate\Support\Facades\Bus;


class CreateArticleForm extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $description = '';
    public string $price = '';
    public int $category_id = 0;

    // Array di immagini caricate temporaneamente
    public array $images = [];

    // Memorizza temporaneamente le nuove immagini prima del merge con l'array principale
    public $temporary_images = [];

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
            'title.required'        => __('messages.title_required'),
            'title.max'             => __('messages.title_max'), // Usa la traduzione!
            'description.required'  => __('messages.description_required'),
            'price.required'        => __('messages.price_required_numeric'),
            'price.numeric'         => __('messages.price_numeric'),
            'price.min'             => __('messages.price_min'),
            'category_id.required'  => __('messages.category_id_required'),
            'category_id.exists'    => __('messages.category_id_exists'),
            'images.*.image'        => __('messages.images_*_image'),
            'images.*.max'          => __('messages.images_*_max'),
        ];
    }

    // Questa funzione unisce le nuove foto a quelle vecchie
    public function updatedTemporaryImages()
    {
        // Prima validiamo le nuove foto in entrata
        $this->validate([
            'temporary_images.*' => 'image|max:2048|mimes:jpeg,png,jpg,webp',
        ]);

        // Aggiungiamo ogni nuova foto alla nostra lista principale
        foreach ($this->temporary_images as $image) {
            $this->images[] = $image;
        }
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

            $imageModel = Image::create([
                'article_id' => $article->id,
                'path'       => $path,
            ]);

            // Chain dei job: Verifica contenuti espliciti, Genera i tag (US8), Identifica e oscura i volti (US8), ridimensiona e mette il watermark (US9)
            Bus::chain([
                new GoogleVisionSafeSearch($imageModel),
                new GoogleVisionLabelImage($imageModel),
                new RemoveFaces($imageModel),
                new ResizeImage($imageModel),
            ])->dispatch();
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
