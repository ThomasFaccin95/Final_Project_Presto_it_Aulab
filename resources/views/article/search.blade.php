<x-layout>
    <x-slot:title>Risultati per "{{ $query }}" — Presto</x-slot:title>

    <div class="row mb-4 mt-3">
        <div class="col">
            <h1 class="welcome-title display-5">Risultati per "{{ $query }}"</h1>
            <p class="welcome-subtitle">{{ $articles->total() }} annunci trovati</p>
        </div>
    </div>

    <div class="row">

        {{-- Sidebar categorie --}}
        <x-category-sidebar />

        {{-- Griglia risultati --}}
        <div class="col">
            <div class="row gy-4">
                @forelse ($articles as $article)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                        <x-card :article="$article" />
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="welcome-subtitle">Nessun annuncio trovato per "{{ $query }}".</p>
                        <a href="{{ route('article.index') }}" class="btn-presto mt-3">
                            Vedi tutti gli annunci
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
