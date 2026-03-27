<x-layout>
    <x-slot:title>{{ __('messages.cart_title') }} — Presto</x-slot:title>

    <div class="row justify-content-center mt-4">
        <div class="col-12 col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="auth-title mb-1">{{ __('messages.cart_title') }}</h1>
                    <p class="auth-subtitle mb-0">{{ $cartItems->count() }} {{ __('messages.cart_items_count') }}</p>
                </div>
                {{-- Svuota carrello --}}
                @if ($cartItems->isNotEmpty())
                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-presto-outline btn-sm">
                            {{ __('messages.cart_clear') }}
                        </button>
                    </form>
                @endif
            </div>

            {{-- Feedback --}}
            @if (session('success'))
                <div class="alert-success-presto mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert-error-presto mb-4">{{ session('error') }}</div>
            @endif

            @if ($cartItems->isEmpty())
                {{-- Carrello vuoto --}}
                <div class="revisor-empty">
                    <p class="welcome-subtitle mb-3">{{ __('messages.cart_empty') }}</p>
                    <a href="{{ route('article.index') }}" class="btn-presto">
                        {{ __('messages.view_articles') }}
                    </a>
                </div>
            @else
                {{-- Lista articoli --}}
                @foreach ($cartItems as $item)
                    <div class="cart-item">
                        {{-- Immagine --}}
                        <img src="{{ $item->article->images->first() ? asset('storage/' . $item->article->images->first()->path) : 'https://picsum.photos/seed/' . $item->article->id . '/120/90' }}"
                            alt="{{ $item->article->title }}" class="cart-item-img">

                        {{-- Dettagli --}}
                        <div class="cart-item-body">
                            <div class="article-card-category">{{ $item->article->category->translated_name }}</div>
                            <h5 class="cart-item-title">{{ $item->article->title }}</h5>
                            <p class="article-show-meta">{{ __('messages.sold_by') }} {{ $item->article->user->name }}
                            </p>
                        </div>

                        {{-- Prezzo e rimozione --}}
                        <div class="cart-item-actions">
                            <span class="article-card-price">€
                                {{ number_format($item->article->price, 2, ',', '.') }}</span>
                            <form method="POST" action="{{ route('cart.remove', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cart-remove-btn">✕</button>
                            </form>
                        </div>
                    </div>
                @endforeach

                {{-- Totale e checkout --}}
                <div class="cart-total-box">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="cart-total-label">{{ __('messages.cart_total') }}</span>
                        <span class="article-show-price">€ {{ number_format($total, 2, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('cart.checkout') }}" class="btn-presto w-100 mt-3 d-block text-center">
                        {{ __('messages.cart_checkout') }}
                    </a>
                </div>
            @endif

        </div>
    </div>

</x-layout>
