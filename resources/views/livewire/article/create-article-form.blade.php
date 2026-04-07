<div>
    <form wire:submit="store" novalidate>

        {{-- Titolo --}}
        <div class="mb-3">
            <label for="title" class="presto-label">{{ __('messages.title') }}</label>
            <input type="text" id="title" wire:model="title"
                class="presto-input @error('title') is-invalid @enderror"
                placeholder="{{ __('messages.title_placeholder') }}">
            @error('title')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Categoria --}}
        <div class="mb-3">
            <label for="category_id" class="presto-label">{{ __('messages.category') }}</label>
            <select id="category_id" wire:model="category_id"
                class="presto-input @error('category_id') is-invalid @enderror">
                <option value="0">{{ __('messages.select_category') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->translated_name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Prezzo --}}
        <div class="mb-3">
            <label for="price" class="presto-label">{{ __('messages.price') }}</label>
            <div class="input-group">

                <input type="number" id="price" wire:model="price"
                    class="presto-input @error('price') is-invalid @enderror" placeholder="Es. 49.99"
                    step="0.01">
            </div>
            {{-- Nota esplicativa per evitare errori di formattazione --}}
            <small class="price-hint">{{ __('messages.price_hint') }}</small>
            @error('price')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Descrizione --}}
        <div class="mb-3">
            <label for="description" class="presto-label">{{ __('messages.description') }}</label>
            <textarea id="description" wire:model="description" class="presto-input @error('description') is-invalid @enderror"
                rows="4" placeholder="{{ __('messages.description_placeholder') }}"></textarea>
            @error('description')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Upload immagini --}}
        <div class="mb-4">
            <label class="presto-label">{{ __('messages.images') }}</label>

            {{-- Input file nascosto: notare l'aggiunta di onchange="aggiornaTestoFile(this)" --}}
            <input type="file" id="images" wire:model="temporary_images" class="@error('temporary_images.*') is-invalid @enderror"
                style="display:none" multiple accept="image/jpeg, image/png, image/jpg, image/webp"
                onchange="aggiornaTestoFile(this)">

            {{-- Bottone custom traducibile --}}
            <div class="presto-input d-flex align-items-center gap-2"
                onclick="document.getElementById('images').click()" style="cursor: pointer;">
                <button type="button" class="btn-presto-outline-img-upload">{{ __('messages.choose_file') }}</button>

                {{-- Il nostro testo dinamico --}}
                <span id="file-label" class="text-muted small text-truncate" style="max-width: 250px;">
                    @if ($images && count($images) === 1)
                        {{-- Se c'è 1 immagine, prendi il nome originale del file --}}
                        {{ $images[0]->getClientOriginalName() }}
                    @elseif ($images && count($images) > 1)
                        {{-- Se ci sono più immagini, scrivi il numero --}}
                        {{ count($images) }} {{ __('messages.files_selected') }}
                    @else
                        {{-- Se non c'è nulla, testo di default --}}
                        {{ __('messages.no_file') }}
                    @endif
                </span>
            </div>

            {{-- Indicatore caricamento Livewire --}}
            <div wire:loading wire:target="temporary_images" class="mt-2 text-primary small">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Caricamento immagini...
            </div>

            {{-- Anteprima immagini caricate --}}
            @if (count($images) > 0)
                <div class="image-preview-grid mt-3">
                    @foreach ($images as $index => $image)
                        <div class="image-preview-item">
                            <img src="{{ $image->temporaryUrl() }}" alt="Anteprima {{ $index + 1 }}"
                                class="image-preview-thumb">
                            {{-- Bottone rimozione singola immagine --}}
                            <button type="button" wire:click="removeImage({{ $index }})"
                                class="image-preview-remove">
                                ✕
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <button type="submit" class="btn-presto w-100">{{ __('messages.insert_article_btn') }}</button>

    </form>
</div>
