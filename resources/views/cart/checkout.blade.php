<x-layout>
    <x-slot:title>{{ __('messages.cart_checkout') }} — Presto</x-slot:title>

    <div class="row justify-content-center mt-4">
        <div class="col-12 col-lg-8">

            <h1 class="auth-title mb-1">{{ __('messages.cart_checkout') }}</h1>
            <p class="auth-subtitle mb-4">{{ __('messages.cart_checkout_subtitle') }}</p>

            {{-- Riepilogo ordine --}}
            <div class="auth-card mb-4">
                <h5 class="revisor-title mb-3">{{ __('messages.cart_summary') }}</h5>

                @foreach ($cartItems as $item)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <span class="article-card-category">{{ $item->article->category->translated_name }}</span>
                            <p class="mb-0 fw-500">{{ $item->article->title }}</p>
                            <small class="article-show-meta">{{ __('messages.sold_by') }}
                                {{ $item->article->user->name }}</small>
                        </div>
                        <span class="article-card-price">€
                            {{ number_format($item->article->price, 2, ',', '.') }}</span>
                    </div>
                @endforeach

                {{-- Totale --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="cart-total-label">{{ __('messages.cart_total') }}</span>
                    <span class="article-show-price">€ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>

            {{-- Info acquirente --}}
            <div class="auth-card mb-4">
                <h5 class="revisor-title mb-3">{{ __('messages.cart_buyer_info') }}</h5>
                <div class="mb-2">
                    <span class="presto-label">{{ __('messages.full_name') }}</span>
                    <p class="mb-0">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <span class="presto-label">{{ __('messages.email') }}</span>
                    <p class="mb-0">{{ auth()->user()->email }}</p>
                </div>
            </div>

            {{-- Azioni --}}
            <div class="d-flex gap-3">
                <a href="{{ route('cart.index') }}" class="btn-presto-outline">
                    ← {{ __('messages.cart_back') }}
                </a>
                {{-- Il checkout reale sarà implementato in futuro --}}
                <button class="btn-presto" disabled>
                    {{ __('messages.cart_confirm') }} (coming soon)
                </button>
            </div>

        </div>
    </div>

</x-layout>
