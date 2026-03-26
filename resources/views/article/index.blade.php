<x-layout>
    <x-slot:title>{{ __('messages.all_articles_title') }} — Presto</x-slot:title>

    {{-- Messaggio flash dopo operazione --}}
    @if (session('message'))
        <div id="flash-message" class="alert-success-presto mb-4" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div class="row mb-4 mt-3">
        <div class="col">
            {{-- Mostra il nome tradotto della categoria se filtrata, altrimenti il titolo generico --}}
            <h1 class="welcome-title display-5">
                {{ isset($category) ? $category->translated_name : __('messages.all_articles_title') }}
            </h1>
            {{-- Mostra la categoria attiva nel sottotitolo, altrimenti il testo generico --}}
            <p class="welcome-subtitle">
                {{ isset($category) ? __('messages.discover') : __('messages.discover') }}
            </p>
        </div>
    </div>

    <div class="row">

        {{-- Passa la categoria attiva al component sidebar --}}
        <x-category-sidebar :category="$category ?? null" />

        {{-- Griglia articoli --}}
        <div class="col">
            <div class="row gy-4 align-items-stretch">
                @forelse ($articles as $article)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                        <x-card :article="$article" />
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="welcome-subtitle">{{ __('messages.no_articles') }}</p>
                        @auth
                            <a href="{{ route('article.create') }}" class="btn-presto mt-3">
                                {{ __('messages.insert_first') }}
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>

            {{-- Paginazione --}}
            @if ($articles->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layout>
