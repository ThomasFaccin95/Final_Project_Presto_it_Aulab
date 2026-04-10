{{-- <div class="search-wrapper" x-data="{ open: @entangle('results').defer }"> CASO DI UTILIZZO DI ALPINE --}}
<div class="search-wrapper">

    <form wire:submit="search" class="d-flex align-items-center gap-2">
        <div class="search-input-wrapper">
            <input type="text" wire:model.live.debounce.300ms="query" class="search-input"
                placeholder="{{ __('messages.search_placeholder') }}" autocomplete="off">

            {{-- Dropdown risultati --}}
            @if (strlen($query) >= 2)
                <div class="search-dropdown">
                    @forelse ($results as $article)
                        <a href="{{ route('article.show', $article) }}" class="search-result-item">
                            <div class="search-result-title">{{ $article->translated_title }}</div>
                            <div class="search-result-meta">
                                {{ $article->category->translated_name }} · €
                                {{ number_format($article->price, 2, ',', '.') }}
                            </div>
                        </a>
                    @empty
                        <div class="search-no-results">Nessun risultato per "{{ $query }}"</div>
                    @endforelse

                    @if (count($results) > 0)
                        <button type="submit" class="search-view-all">
                            {{ __('messages.search_view_all') }}
                        </button>
                    @endif
                </div>
            @endif
        </div>

        <button type="submit" class="btn-presto btn-sm">{{ __('messages.search') }}</button>
    </form>
</div>
