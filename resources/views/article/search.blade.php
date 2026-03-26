<x-layout>
    <x-slot:title>{{ __('messages.search_results_title', ['query' => $query]) }} — Presto</x-slot:title>

    <div class="row mb-4 mt-3">
        <div class="col">
            {{-- Titolo con query di ricerca --}}
            <h1 class="welcome-title display-5">{{ __('messages.search_results_title', ['query' => $query]) }}</h1>
            <p class="welcome-subtitle">{{ __('messages.search_results_count', ['count' => $articles->total()]) }}</p>
        </div>
    </div>

    <div class="row">

        {{-- Sidebar categorie --}}
        <x-category-sidebar />

        {{-- Griglia risultati --}}
        <div class="col">
            <div class="row gy-4 align-items-stretch">
                @forelse ($articles as $article)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                        <x-card :article="$article" />
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="welcome-subtitle">{{ __('messages.no_search_results', ['query' => $query]) }}</p>
                        <a href="{{ route('article.index') }}" class="btn-presto mt-3">
                            {{ __('messages.view_articles') }}
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($articles->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layout>
