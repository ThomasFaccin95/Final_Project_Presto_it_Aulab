<div class="article-card">

    {{-- Mostra la prima immagine reale se disponibile, altrimenti usa picsum --}}
    <img src="{{ $article->images->first() ? asset('storage/' . $article->images->first()->path) : 'https://picsum.photos/seed/' . $article->id . '/400/180' }}"
        alt="Immagine di {{ $article->title }}" class="article-card-img">

    <div class="article-card-body">
        <div class="article-card-category">{{ $article->category->translated_name }}</div>
        <h5 class="article-card-title">{{ $article->title }}</h5>
        <p class="article-card-price">€ {{ number_format($article->price, 2, ',', '.') }}</p>

        <div class="article-card-footer">
            <a href="{{ route('article.show', $article) }}" class="article-card-link">{{ __('messages.detail') }}</a>
            <a href="{{ route('article.byCategory', $article->category) }}"
                class="article-card-link">{{ $article->category->translated_name }}</a>
        </div>
    </div>

</div>
