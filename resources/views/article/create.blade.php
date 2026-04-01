<x-layout>
    <x-slot:title>Inserisci annuncio — Presto</x-slot:title>

    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-8 col-lg-6">

            <h1 class="auth-title mb-1">{{ __('messages.insert_article_title') }}</h1>
            <p class="auth-subtitle mb-4">{{ __('messages.insert_article_subtitle') }}</p>

            @livewire('article.create-article-form')

        </div>
    </div>

</x-layout>
