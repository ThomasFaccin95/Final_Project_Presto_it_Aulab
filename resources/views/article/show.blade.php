<x-layout>
    <x-slot:title>{{ $article->title }} — Presto</x-slot:title>

    <div class="row justify-content-center mt-4">
        <div class="col-12 col-lg-8">

            {{-- Breadcrumb con categoria tradotta --}}
            <nav class="mb-4">
                <ol class="breadcrumb-presto">
                    <li>
                        <a href="{{ route('article.index') }}" class="auth-link">{{ __('messages.articles') }}</a>
                    </li>
                    <li class="breadcrumb-separator">›</li>
                    <li>
                        <a href="{{ route('article.byCategory', $article->category) }}" class="auth-link">
                            {{ $article->category->translated_name }}
                        </a>
                    </li>
                    <li class="breadcrumb-separator">›</li>
                    <li class="breadcrumb-current">{{ $article->translated_title }}</li>
                </ol>
            </nav>

            {{-- Carosello immagini -- reali se presenti, segnaposto altrimenti --}}
            <div class="article-carousel mb-4">
                @if ($article->images->count() > 0)
                    @foreach ($article->images as $i => $image)
                        <img src="{{ asset('storage/' . $image->path) }}"
                            alt="Immagine {{ $i + 1 }} di {{ $article->title }}"
                            class="article-carousel-img {{ $i === 0 ? 'active' : '' }}">
                    @endforeach
                @else
                    {{-- Segnaposto se non ci sono immagini --}}
                    <img src="https://picsum.photos/seed/{{ $article->id }}/400/400" alt="{{ $article->title }}"
                        class="article-carousel-img active">
                @endif
                <button class="carousel-btn carousel-btn-prev" onclick="changeSlide(-1)">‹</button>
                <button class="carousel-btn carousel-btn-next" onclick="changeSlide(1)">›</button>
            </div>

            {{-- Dettaglio annuncio --}}
            <div class="article-show-card">

                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        {{-- Categoria tradotta nella lingua corrente --}}
                        <span class="article-card-category">{{ $article->category->translated_name }}</span>
                        <h1 class="article-show-title">{{ $article->translated_title }}</h1>
                    </div>
                    <span class="article-show-price">€ {{ number_format($article->price, 2, ',', '.') }}</span>
                </div>

                <hr class="auth-divider my-3">

                <p class="article-show-description">{{ $article->translated_description }}</p>

                <hr class="auth-divider my-3">

                <div class="d-flex justify-content-between align-items-center">
                    {{-- Meta informazioni -- venditore e data --}}
                    <span class="article-show-meta">
                        {{ __('messages.sold_by') }} <strong>{{ $article->user->name }}</strong>
                    </span>
                    <span class="article-show-meta">
                        {{ $article->created_at->diffForHumans() }}
                    </span>
                </div>

                <hr class="auth-divider my-3">

                {{-- Bottone aggiungi al carrello --}}
                @auth
                    @if ($article->user_id !== auth()->id())
                        <form method="POST" action="{{ route('cart.add', $article) }}">
                            @csrf
                            <button type="submit" class="btn-presto">
                                {{ __('messages.cart_add') }}
                            </button>
                        </form>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn-presto-outline d-inline-block">
                        {{ __('messages.login') }} — {{ __('messages.cart_add') }}
                    </a>
                @endguest

            </div>

        </div>
    </div>

</x-layout>
