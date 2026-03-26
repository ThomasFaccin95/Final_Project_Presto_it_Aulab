{{-- Carosello immagini -- reali se presenti, segnaposto altrimenti --}}
<div class="article-carousel mb-4">
    @if ($article->images->count() > 0)
        @foreach ($article->images as $i => $image)
            <img src="{{ asset('storage/' . $image->path) }}" alt="Immagine {{ $i + 1 }} di {{ $article->title }}"
                class="article-carousel-img {{ $i === 0 ? 'active' : '' }}">
        @endforeach
    @else
        {{-- Segnaposto se non ci sono immagini --}}
        <img src="https://picsum.photos/seed/{{ $article->id }}/800/400" alt="{{ $article->title }}"
            class="article-carousel-img active">
    @endif
    <button class="carousel-btn carousel-btn-prev" onclick="changeSlide(-1)">‹</button>
    <button class="carousel-btn carousel-btn-next" onclick="changeSlide(1)">›</button>
</div>
