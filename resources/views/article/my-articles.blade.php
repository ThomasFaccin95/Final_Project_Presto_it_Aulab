<x-layout>
    <x-slot:title>{{ __('messages.my_articles') }} — Presto</x-slot:title>

    <div class="row mb-4 mt-3">
        <div class="col">
            <h1 class="welcome-title display-5">{{ __('messages.my_articles') }}</h1>
            <p class="welcome-subtitle">{{ __('messages.my_articles_desc') }}</p>
        </div>
    </div>

    <div class="row gy-4 align-items-stretch">
        @forelse ($articles as $article)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <x-card :article="$article" :showStatus="true" />
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="welcome-subtitle">{{ __('messages.no_articles') }}</p>
                <a href="{{ route('article.create') }}" class="btn-presto mt-3">
                    {{ __('messages.insert_first') }}
                </a>
            </div>
        @endforelse
    </div>

    @if ($articles->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $articles->links() }}
        </div>
    @endif

</x-layout>
