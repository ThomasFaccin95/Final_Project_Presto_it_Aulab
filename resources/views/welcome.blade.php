<x-layout>
    <x-slot:title>Home — Presto.it</x-slot:title>

    {{-- Sezione hero --}}
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-8 text-center">
            <h1 class="display-4 fw-bold welcome-title">Presto.it</h1>
            {{-- Sottotitolo tradotto nella lingua corrente --}}
            <p class="lead mb-4 welcome-subtitle">{{ __('messages.hero_subtitle') }}</p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('article.index') }}" class="btn-presto btn-lg">{{ __('messages.view_articles') }}</a>
                {{-- Bottone diverso in base allo stato di autenticazione --}}
                @guest
                    <a href="{{ route('register') }}" class="btn-presto-outline btn-lg">{{ __('messages.register_free') }}</a>
                @endguest
                @auth
                    <a href="{{ route('article.create') }}"
                        class="btn-presto-outline btn-lg">{{ __('messages.insert_article_btn') }}</a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Sezione ultimi annunci --}}
    <div class="row mt-5 mb-3">
        <div class="col-12">
            <h2 class="welcome-title h4">{{ __('messages.latest_articles') }}</h2>
        </div>
    </div>

    {{-- Griglia ultimi 4 annunci approvati --}}
    <div class="row gy-4 align-items-stretch">
        @forelse ($articles as $article)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <x-card :article="$article" />
            </div>
        @empty
            <div class="col-12">
                <p class="welcome-subtitle">{{ __('messages.no_articles') }}</p>
            </div>
        @endforelse
    </div>

    {{-- Bottone per vedere tutti gli annunci --}}
    @if ($articles->isNotEmpty())
        <div class="text-center mt-4">
            <a href="{{ route('article.index') }}" class="btn-presto-outline">{{ __('messages.view_all') }}</a>
        </div>
    @endif

</x-layout>
