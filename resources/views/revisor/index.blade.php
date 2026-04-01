<x-layout>
    <x-slot:title>{{ __('messages.revisor_title') }} — Presto</x-slot:title>

    <div class="row justify-content-center mt-4">
        <div class="col-12 col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="auth-title mb-1">{{ __('messages.revisor_title') }}</h1>
                    <p class="auth-subtitle mb-0">{{ __('messages.revisor_subtitle') }}</p>
                </div>

                {{-- EXTRA: bottone undo per annullare l'ultima operazione --}}
                @if (session('last_action'))
                    <form method="POST" action="{{ route('revisor.undo') }}">
                        @csrf
                        <button type="submit" class="btn-presto-outline btn-sm">
                            {{ __('messages.revisor_undo') }}
                        </button>
                    </form>
                @endif
            </div>

            {{-- Feedback operazione --}}
            @if (session('success'))
                <div class="alert-success-presto mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert-error-presto mb-4">{{ session('error') }}</div>
            @endif

            @if ($article)
                <div class="revisor-card">

                    {{-- Header con categoria tradotta e meta info --}}
                    <div class="revisor-card-header">
                        <span class="article-card-category">{{ $article->category->translated_name }}</span>
                        <span class="revisor-meta">
                            {{ __('messages.revisor_sent_by') }} {{ $article->user->name }} ·
                            {{ $article->created_at->diffForHumans() }}
                        </span>
                    </div>

                    {{-- Contenuto annuncio -- titolo e descrizione restano nella lingua originale dell'inserimento --}}
                    <h2 class="revisor-title">{{ $article->title }}</h2>
                    <p class="article-card-price">€ {{ number_format($article->price, 2, ',', '.') }}</p>
                    <p class="article-show-description">{{ $article->description }}</p>
                    {{-- Dati Google Vision per il revisore --}}
                    @if ($article->images->isNotEmpty())
                        <div class="mt-3">
                            @foreach ($article->images as $image)
                                <div class="vision-card mb-3">

                                    <img src="{{ asset('storage/' . $image->path) }}" alt="Immagine"
                                        class="vision-img">

                                    <div class="vision-data">
                                        {{-- Labels --}}
                                        @if ($image->labels)
                                            <div class="mb-2">
                                                <span class="presto-label">Etichette AI</span>
                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                    @foreach ($image->labels as $label)
                                                        <span class="vision-tag">{{ $label }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Safe Search --}}
                                        @if ($image->safe_search)
                                            <div>
                                                <span class="presto-label">Safe Search</span>
                                                <div class="d-flex gap-2 mt-1 flex-wrap">
                                                    <span class="vision-tag">Adult:
                                                        {{ $image->safe_search['adult'] }}</span>
                                                    <span class="vision-tag">Violence:
                                                        {{ $image->safe_search['violence'] }}</span>
                                                    <span class="vision-tag">Racy:
                                                        {{ $image->safe_search['racy'] }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!$image->labels && !$image->safe_search)
                                            <p class="article-show-meta">Analisi AI in corso...</p>
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Azioni revisione --}}
                    <div class="revisor-actions">
                        <form method="POST" action="{{ route('revisor.approve', $article) }}">
                            @csrf
                            <button type="submit" class="btn-revisor-approve">
                                ✓ {{ __('messages.approve') }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('revisor.reject', $article) }}">
                            @csrf
                            <button type="submit" class="btn-revisor-reject">
                                ✗ {{ __('messages.reject') }}
                            </button>
                        </form>
                    </div>

                </div>
            @else
                {{-- Nessun annuncio in attesa --}}
                <div class="revisor-empty">
                    <p class="welcome-subtitle">{{ __('messages.no_pending') }}</p>
                    <a href="{{ route('homepage') }}" class="btn-presto mt-3">{{ __('messages.back_home') }}</a>
                </div>
            @endif

        </div>
    </div>

</x-layout>
